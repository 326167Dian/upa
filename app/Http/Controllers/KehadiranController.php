<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Operator;
use App\Support\SimpleXlsxWriter;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class KehadiranController extends Controller
{
    public function index(Request $request): View
    {
        $selectedDate = $request->query('waktu', '');
        $selectedStatus = $request->query('status', '');
        
        $availableDates = Kehadiran::query()
            ->whereNotNull('waktu')
            ->selectRaw('DATE(waktu) as tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->pluck('tanggal')
            ->map(fn (string $date) => [
                'value' => $date,
                'label' => Carbon::parse($date)->format('d M Y'),
            ])
            ->values();
        
        $query = Kehadiran::with(['operator', 'kegiatan']);
        
        if ($selectedDate) {
            $query->whereRaw('DATE(waktu) = ?', [$selectedDate]);
        }

        if ($selectedStatus !== '') {
            $query->where('hadir', (int) $selectedStatus);
        }
        
        return view('kehadiran.index', [
            'kehadiran' => $query->latest('id_kehadiran')->get(),
            'availableDates' => $availableDates,
            'selectedDate' => $selectedDate,
            'selectedStatus' => $selectedStatus,
        ]);
    }

    public function export(Request $request): BinaryFileResponse|StreamedResponse
    {
        $selectedDate = (string) $request->query('waktu', '');
        $selectedStatus = (string) $request->query('status', '');

        $parts = array_filter([$selectedDate ?: null, $selectedStatus !== '' ? ($selectedStatus === '1' ? 'hadir' : 'tidak-hadir') : null]);
        $suffix = $parts ? implode('-', $parts) : 'semua';
        $filename = 'kehadiran-'.$suffix.'.xlsx';
        $rows = $this->buildExportRows($selectedDate, $selectedStatus);

        try {
            $xlsxPath = SimpleXlsxWriter::create(
                ['Operator', 'Kegiatan', 'Waktu', 'Lokasi', 'Status', 'Keterangan'],
                $rows
            );

            return response()->download($xlsxPath, $filename)->deleteFileAfterSend(true);
        } catch (Throwable) {
            return $this->fallbackCsvExport($rows, $suffix);
        }
    }

    /**
     * @return array<int, array<int, string>>
     */
    protected function buildExportRows(string $selectedDate, string $selectedStatus = ''): array
    {
        $query = Kehadiran::with(['operator', 'kegiatan'])->latest('id_kehadiran');

        if ($selectedDate !== '') {
            $query->whereRaw('DATE(waktu) = ?', [$selectedDate]);
        }

        if ($selectedStatus !== '') {
            $query->where('hadir', (int) $selectedStatus);
        }

        return $query->get()->map(function (Kehadiran $item): array {
            return [
                $item->operator?->name ?? '-',
                $item->kegiatan?->nama_kegiatan ?? '-',
                $item->waktu?->format('Y-m-d H:i:s') ?? '-',
                $item->lokasi ?? '-',
                $item->hadir === 1 ? 'Hadir' : 'Tidak Hadir',
                $item->keterangan ?: '-',
            ];
        })->all();
    }

    /**
     * @param array<int, array<int, string>> $rows
     */
    protected function fallbackCsvExport(array $rows, string $suffix): StreamedResponse
    {
        $filename = 'kehadiran-'.$suffix.'.csv';

        return response()->streamDownload(function () use ($rows): void {
            $handle = fopen('php://output', 'w');

            if ($handle === false) {
                return;
            }

            // UTF-8 BOM so Excel reads Indonesian characters correctly.
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Operator', 'Kegiatan', 'Waktu', 'Lokasi', 'Status', 'Keterangan']);

            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function create(): View
    {
        $currentOperator = $this->currentOperator(request());
        $isAdmin = request()->user()?->role === User::ROLE_ADMIN;

        return view('kehadiran.create', [
            'kehadiran' => new Kehadiran(),
            'operators' => $this->availableOperators(request()),
            'currentOperator' => $currentOperator,
            'lockOperatorSelection' => $this->shouldLockOperatorSelection(request(), $currentOperator),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
            'minAttendanceDateTime' => $isAdmin ? null : now()->startOfDay()->format('Y-m-d\TH:i'),
        ]);
    }

    public function createAdmin(Request $request): View
    {
        $this->abortIfNotAdmin($request);

        return view('kehadiran.create-admin', [
            'operators' => Operator::orderBy('name')->get(),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
            'defaultAttendanceDateTime' => now()->format('Y-m-d\TH:i'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Kehadiran::create($this->validatedData($request, true));

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil ditambahkan.');
    }

    public function storeAdmin(Request $request): RedirectResponse
    {
        $this->abortIfNotAdmin($request);

        $validated = $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'waktu' => ['required', 'date'],
            'lokasi' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'selected_operators' => ['required', 'array', 'min:1'],
            'selected_operators.*' => ['required', 'distinct', 'exists:operators,id'],
        ], [
            'selected_operators.required' => 'Pilih minimal satu operator yang hadir.',
            'selected_operators.min' => 'Pilih minimal satu operator yang hadir.',
        ]);

        $operatorIds = array_map('intval', $validated['selected_operators']);
        $waktu = Carbon::parse((string) $validated['waktu']);
        $keterangan = (string) ($validated['keterangan'] ?? '');

        DB::transaction(function () use ($operatorIds, $validated, $waktu, $keterangan): void {
            foreach ($operatorIds as $operatorId) {
                Kehadiran::create([
                    'id' => $operatorId,
                    'id_kegiatan' => (int) $validated['id_kegiatan'],
                    'waktu' => $waktu,
                    'lokasi' => (string) $validated['lokasi'],
                    'hadir' => 1,
                    'keterangan' => $keterangan !== '' ? $keterangan : null,
                ]);
            }
        });

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran massal berhasil ditambahkan untuk '.count($operatorIds).' operator.');
    }

    public function massUpdateAdmin(Request $request): View
    {
        $this->abortIfNotAdmin($request);

        $validated = $request->validate([
            'id_kegiatan' => ['nullable', 'exists:kegiatan,id_kegiatan'],
            'tanggal' => ['nullable', 'date'],
        ]);

        $selectedKegiatanId = (string) ($validated['id_kegiatan'] ?? '');
        $selectedDate = (string) ($validated['tanggal'] ?? now()->toDateString());
        $operators = Operator::orderBy('name')->get();
        $existingRows = collect();
        $checkedOperatorIds = [];
        $defaultLokasi = '';
        $defaultKeterangan = '';

        if ($selectedKegiatanId !== '') {
            $existingRows = Kehadiran::query()
                ->where('id_kegiatan', (int) $selectedKegiatanId)
                ->whereDate('waktu', $selectedDate)
                ->latest('id_kehadiran')
                ->get()
                ->unique('id')
                ->values();

            $checkedOperatorIds = $existingRows
                ->where('hadir', 1)
                ->pluck('id')
                ->map(fn (int $operatorId): string => (string) $operatorId)
                ->all();

            $latestRow = $existingRows->first();
            if ($latestRow !== null) {
                $defaultLokasi = (string) ($latestRow->lokasi ?? '');
                $defaultKeterangan = (string) ($latestRow->keterangan ?? '');
            }
        }

        return view('kehadiran.mass-update-admin', [
            'operators' => $operators,
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
            'selectedKegiatanId' => $selectedKegiatanId,
            'selectedDate' => $selectedDate,
            'checkedOperatorIds' => $checkedOperatorIds,
            'defaultTime' => now()->format('H:i'),
            'defaultLokasi' => $defaultLokasi,
            'defaultKeterangan' => $defaultKeterangan,
        ]);
    }

    public function processMassUpdateAdmin(Request $request): RedirectResponse
    {
        $this->abortIfNotAdmin($request);

        $validated = $request->validate([
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'tanggal' => ['required', 'date'],
            'jam' => ['required', 'date_format:H:i'],
            'lokasi' => ['required', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string'],
            'selected_operators' => ['nullable', 'array'],
            'selected_operators.*' => ['required', 'distinct', 'exists:operators,id'],
        ]);

        $selectedOperatorIds = collect($validated['selected_operators'] ?? [])
            ->map(fn (string|int $operatorId): int => (int) $operatorId)
            ->unique()
            ->values();
        $selectedOperatorLookup = array_fill_keys($selectedOperatorIds->all(), true);
        $allOperatorIds = Operator::query()->orderBy('id')->pluck('id')->map(fn (int $operatorId): int => (int) $operatorId);
        $attendanceDateTime = Carbon::createFromFormat('Y-m-d H:i', $validated['tanggal'].' '.$validated['jam']);
        $keterangan = trim((string) ($validated['keterangan'] ?? ''));

        DB::transaction(function () use ($allOperatorIds, $selectedOperatorLookup, $validated, $attendanceDateTime, $keterangan): void {
            foreach ($allOperatorIds as $operatorId) {
                $payload = [
                    'id' => $operatorId,
                    'id_kegiatan' => (int) $validated['id_kegiatan'],
                    'waktu' => $attendanceDateTime,
                    'lokasi' => (string) $validated['lokasi'],
                    'hadir' => isset($selectedOperatorLookup[$operatorId]) ? 1 : 0,
                    'keterangan' => $keterangan !== '' ? $keterangan : null,
                ];

                $latestRow = Kehadiran::query()
                    ->where('id', $operatorId)
                    ->where('id_kegiatan', (int) $validated['id_kegiatan'])
                    ->whereDate('waktu', $validated['tanggal'])
                    ->latest('id_kehadiran')
                    ->first();

                if ($latestRow) {
                    $latestRow->update($payload);
                    continue;
                }

                Kehadiran::create($payload);
            }
        });

        return redirect()
            ->route('kehadiran.admin.mass-update', [
                'id_kegiatan' => $validated['id_kegiatan'],
                'tanggal' => $validated['tanggal'],
            ])
            ->with('success', 'Update massal kehadiran berhasil. Hadir: '.$selectedOperatorIds->count().' operator.');
    }

    public function edit(Kehadiran $kehadiran): View
    {
        $currentOperator = $this->currentOperator(request());

        return view('kehadiran.edit', [
            'kehadiran' => $kehadiran,
            'operators' => $this->availableOperators(request()),
            'currentOperator' => $currentOperator,
            'lockOperatorSelection' => $this->shouldLockOperatorSelection(request(), $currentOperator),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function update(Request $request, Kehadiran $kehadiran): RedirectResponse
    {
        $kehadiran->update($this->validatedData($request, false));

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil diperbarui.');
    }

    public function destroy(Kehadiran $kehadiran): RedirectResponse
    {
        $kehadiran->delete();

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(Request $request, bool $isCreate = false): array
    {
        $currentOperator = $this->currentOperator($request);
        $shouldBlockPastDate = $isCreate && $request->user()?->role !== User::ROLE_ADMIN;

        if ($this->shouldLockOperatorSelection($request, $currentOperator)) {
            $request->merge([
                'id' => $currentOperator->id,
            ]);
        }

        $waktuRules = ['required', 'date'];
        if ($shouldBlockPastDate) {
            $waktuRules[] = function (string $attribute, mixed $value, \Closure $fail): void {
                try {
                    if (Carbon::parse((string) $value)->toDateString() < now()->toDateString()) {
                        $fail('Selain admin, tanggal kehadiran tidak boleh kurang dari hari ini.');
                    }
                } catch (Throwable) {
                    // Validation rule "date" already handles invalid formats.
                }
            };
        }

        return $request->validate([
            'id' => ['required', 'exists:operators,id'],
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'waktu' => $waktuRules,
            'lokasi' => ['nullable', 'string', 'max:255'],
            'hadir' => ['required', 'in:0,1'],
            'keterangan' => ['nullable', 'string'],
        ]);
    }

    /**
     * @return Collection<int, Operator>
     */
    protected function availableOperators(Request $request): Collection
    {
        $currentOperator = $this->currentOperator($request);

        if ($this->shouldLockOperatorSelection($request, $currentOperator)) {
            return collect([$currentOperator]);
        }

        return Operator::orderBy('name')->get();
    }

    protected function currentOperator(Request $request): ?Operator
    {
        return $request->user()?->operator;
    }

    protected function shouldLockOperatorSelection(Request $request, ?Operator $operator): bool
    {
        return $request->user()?->role !== User::ROLE_ADMIN && $operator !== null;
    }

    protected function abortIfNotAdmin(Request $request): void
    {
        abort_if($request->user()?->role !== User::ROLE_ADMIN, 403);
    }
}