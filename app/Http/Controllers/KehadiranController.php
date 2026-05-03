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
                ['Operator', 'Kegiatan', 'Waktu', 'Status', 'Keterangan'],
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

            fputcsv($handle, ['Operator', 'Kegiatan', 'Waktu', 'Status', 'Keterangan']);

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

        return view('kehadiran.create', [
            'kehadiran' => new Kehadiran(),
            'operators' => $this->availableOperators(request()),
            'currentOperator' => $currentOperator,
            'lockOperatorSelection' => $this->shouldLockOperatorSelection(request(), $currentOperator),
            'kegiatanList' => Kegiatan::orderBy('nama_kegiatan')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Kehadiran::create($this->validatedData($request));

        return redirect()
            ->route('kehadiran.index')
            ->with('success', 'Data kehadiran berhasil ditambahkan.');
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
        $kehadiran->update($this->validatedData($request));

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
    protected function validatedData(Request $request): array
    {
        $currentOperator = $this->currentOperator($request);

        if ($this->shouldLockOperatorSelection($request, $currentOperator)) {
            $request->merge([
                'id' => $currentOperator->id,
            ]);
        }

        return $request->validate([
            'id' => ['required', 'exists:operators,id'],
            'id_kegiatan' => ['required', 'exists:kegiatan,id_kegiatan'],
            'waktu' => ['required', 'date'],
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
}