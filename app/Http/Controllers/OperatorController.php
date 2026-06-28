<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Operator;
use App\Models\User;
use App\Support\FeaturePermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OperatorController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $role = (string) $request->string('role');
        $operators = Operator::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $nestedQuery) use ($search) {
                    $nestedQuery
                        ->where('name', 'like', '%'.$search.'%')
                        ->orWhere('username', 'like', '%'.$search.'%')
                        ->orWhere('phone_number', 'like', '%'.$search.'%')
                        ->orWhere('full_address', 'like', '%'.$search.'%');
                });
            })
            ->when(in_array($role, [User::ROLE_ADMIN, User::ROLE_USER, User::ROLE_CUSTOM], true), function (Builder $query) use ($role) {
                $query->where('role', $role);
            })
            ->latest()
            ->get();

        return view('operators.index', [
            'operators' => $operators,
            'filters' => [
                'search' => $search,
                'role' => $role,
            ],
            'featureDefinitions' => FeaturePermission::definitions(),
            'permissionSummaries' => $operators
                ->mapWithKeys(fn (Operator $operator) => [
                    $operator->id => FeaturePermission::summarize($operator->permissions),
                ]),
        ]);
    }

    public function create(): View
    {
        return view('operators.create', [
            'operator' => new Operator(),
            'featureDefinitions' => FeaturePermission::definitions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        DB::transaction(function () use ($data): void {
            $permissions = $this->normalizePermissions((string) $data['role'], $data['permissions'] ?? []);
            $passwordHash = Hash::make($data['password']);
            $user = $this->upsertOperatorUser($data, null, $passwordHash);

            Operator::create([
                ...Arr::except($data, ['password']),
                'user_id' => $user->id,
                'password' => $passwordHash,
                'permissions' => $permissions,
            ]);
        });

        return redirect()
            ->route('operators.index')
            ->with('success', 'Operator berhasil ditambahkan.');
    }

    public function edit(Operator $operator): View
    {
        return view('operators.edit', [
            'operator' => $operator,
            'featureDefinitions' => FeaturePermission::definitions(),
        ]);
    }

    public function show(int $operator): RedirectResponse
    {
        $existingOperator = Operator::find($operator);

        if (! $existingOperator) {
            return redirect()
                ->route('operators.index')
                ->with('error', 'Operator yang diminta tidak ditemukan atau sudah dihapus.');
        }

        return redirect()->route('operators.edit', $existingOperator);
    }

    public function update(Request $request, Operator $operator): RedirectResponse
    {
        $data = $this->validatedData($request, $operator);

        DB::transaction(function () use ($data, $operator): void {
            $permissions = $this->normalizePermissions((string) $data['role'], $data['permissions'] ?? []);
            $passwordHash = filled($data['password'] ?? null)
                ? Hash::make($data['password'])
                : $operator->password;

            $user = $this->upsertOperatorUser($data, $operator, $passwordHash);

            $operator->update([
                ...Arr::except($data, ['password']),
                'user_id' => $user->id,
                'password' => $passwordHash,
                'permissions' => $permissions,
            ]);
        });

        return redirect()
            ->route('operators.index')
            ->with('success', 'Data operator berhasil diperbarui.');
    }

    public function destroy(Request $request, Operator $operator): RedirectResponse
    {
        DB::transaction(function () use ($operator): void {
            $linkedUser = $operator->user;

            $operator->delete();

            $linkedUser?->delete();
        });

        return redirect()
            ->route('operators.index')
            ->with('success', 'Data operator berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function validatedData(Request $request, ?Operator $operator = null): array
    {
        $passwordRule = $operator && filled($operator->password) ? 'nullable' : 'required';

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('operators', 'username')->ignore($operator?->id),
                Rule::unique('users', 'username')->ignore($operator?->user_id),
            ],
            'password' => [$passwordRule, 'string', 'min:8'],
            'role' => ['required', 'in:admin,user,custom'],
            'permissions' => ['required_if:role,custom', 'array'],
            'permissions.*' => ['string', Rule::in(FeaturePermission::keys())],
            'phone_number' => ['required', 'string', 'max:30'],
            'full_address' => ['required', 'string'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function upsertOperatorUser(array $data, ?Operator $operator, string $passwordHash): User
    {
        $user = $operator?->user ?? new User();
        $permissions = $this->normalizePermissions((string) $data['role'], $data['permissions'] ?? []);

        $user->fill([
            'name' => $data['name'],
            'username' => $data['username'],
            'role' => $data['role'],
            'permissions' => $permissions,
            'email' => $this->operatorEmail((string) $data['username']),
            'password' => $passwordHash,
        ]);

        $user->save();

        return $user;
    }

    protected function operatorEmail(string $username): string
    {
        return strtolower($username).'@upa.local';
    }

    /**
     * @param  array<int, string>  $permissions
     * @return array<int, string>
     */
    protected function normalizePermissions(string $role, array $permissions): array
    {
        if ($role === User::ROLE_ADMIN) {
            return FeaturePermission::keys();
        }

        if ($role === User::ROLE_USER) {
            if ($permissions === []) {
                return FeaturePermission::keys();
            }

            return array_values(array_intersect(FeaturePermission::keys(), $permissions));
        }

        return array_values(array_intersect(FeaturePermission::keys(), $permissions));
    }

    public function exportPdf(): \Illuminate\Http\JsonResponse
    {
        $operators = Operator::latest()->get();

        $data = $operators->map(function (Operator $operator) {
            return [
                'nama' => $operator->name,
                'telp_wa' => $operator->phone_number ?? '-',
                'alamat' => trim(strip_tags($operator->full_address)) ?? '-',
                'mulai_upa' => $operator->mulai_upa_tahun ?? '-',
            ];
        })->toArray();

        return response()->json([
            'success' => true,
            'data' => $data,
            'filename' => 'data-operator-' . date('Y-m-d-H-i-s') . '.pdf'
        ]);
    }

    public function personalAttendance(Request $request, Operator $operator): View
    {
        $singleDate = trim((string) $request->query('tanggal', ''));
        $startDate = trim((string) $request->query('tanggal_mulai', ''));
        $endDate = trim((string) $request->query('tanggal_selesai', ''));

        // Kompatibilitas URL lama: ?tanggal=YYYY-MM-DD dianggap satu hari.
        if ($singleDate !== '' && $startDate === '' && $endDate === '') {
            $startDate = $singleDate;
            $endDate = $singleDate;
        }

        $startDate = $this->normalizeYmdDate($startDate);
        $endDate = $this->normalizeYmdDate($endDate);

        if ($startDate !== '' && $endDate !== '' && $startDate > $endDate) {
            [$startDate, $endDate] = [$endDate, $startDate];
        }

        $filterDateLabel = '-';
        if ($startDate !== '' && $endDate !== '') {
            $filterDateLabel = Carbon::parse($startDate)->format('d M Y').' - '.Carbon::parse($endDate)->format('d M Y');
        } elseif ($startDate !== '') {
            $filterDateLabel = 'Mulai '.Carbon::parse($startDate)->format('d M Y');
        } elseif ($endDate !== '') {
            $filterDateLabel = 'Sampai '.Carbon::parse($endDate)->format('d M Y');
        }

        $attendanceRecords = Kehadiran::query()
            ->with('kegiatan')
            ->where('id', $operator->id)
            ->when($startDate !== '', fn (Builder $query) => $query->whereDate('waktu', '>=', $startDate))
            ->when($endDate !== '', fn (Builder $query) => $query->whereDate('waktu', '<=', $endDate))
            ->orderByDesc('waktu')
            ->get();

        $attendanceRows = $attendanceRecords->map(function (Kehadiran $item): array {
            return [
                'waktu' => $item->waktu,
                'kegiatan_label' => $item->kegiatan?->nama_kegiatan ?? '-',
                'hadir' => (int) ($item->hadir ?? 0),
                'keterangan' => $item->keterangan ?: '-',
                'is_inferred' => false,
            ];
        })->values();

        $groupedByDate = $attendanceRecords
            ->filter(fn (Kehadiran $item) => $item->waktu !== null)
            ->groupBy(fn (Kehadiran $item) => $item->waktu->toDateString());

        // Tanggal referensi diambil dari seluruh data kehadiran (group by tanggal waktu),
        // lalu operator tanpa data pada tanggal tersebut dianggap tidak hadir.
        $referenceDatesQuery = Kehadiran::query()
            ->whereNotNull('waktu')
            ->when($startDate !== '', fn (Builder $query) => $query->whereDate('waktu', '>=', $startDate))
            ->when($endDate !== '', fn (Builder $query) => $query->whereDate('waktu', '<=', $endDate));

        $referenceDates = $referenceDatesQuery
            ->selectRaw('DATE(waktu) as tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->pluck('tanggal');

        if ($referenceDates->isEmpty()) {
            $referenceDates = $attendanceRecords
                ->filter(fn (Kehadiran $item) => $item->waktu !== null)
                ->map(fn (Kehadiran $item) => $item->waktu->toDateString())
                ->unique()
                ->sortDesc()
                ->values();
        }

        $attendanceRows = $referenceDates->map(function (string $dateKey) use ($groupedByDate): array {
            $recordsInDate = $groupedByDate->get($dateKey, collect());

            if ($recordsInDate->isEmpty()) {
                return [
                    'waktu' => Carbon::parse($dateKey)->startOfDay(),
                    'kegiatan_label' => '-',
                    'hadir' => 0,
                    'keterangan' => 'Tidak ada data operator pada tanggal ini.',
                    'is_inferred' => true,
                ];
            }

            $isPresent = $recordsInDate->contains(fn (Kehadiran $item) => (int) ($item->hadir ?? 0) === 1);
            $kegiatanLabel = $recordsInDate
                ->map(fn (Kehadiran $item) => $item->kegiatan?->nama_kegiatan)
                ->filter()
                ->unique()
                ->values()
                ->implode(', ');

            $keterangan = $recordsInDate
                ->map(fn (Kehadiran $item) => trim((string) $item->keterangan))
                ->filter(fn (string $text) => $text !== '')
                ->values()
                ->implode(' | ');

            return [
                'waktu' => Carbon::parse($dateKey)->startOfDay(),
                'kegiatan_label' => $kegiatanLabel !== '' ? $kegiatanLabel : '-',
                'hadir' => $isPresent ? 1 : 0,
                'keterangan' => $keterangan !== '' ? $keterangan : '-',
                'is_inferred' => false,
            ];
        })->values();

        $totalHadir = (int) $attendanceRows->filter(fn (array $row) => (int) $row['hadir'] === 1)->count();
        $totalTidakHadir = (int) $attendanceRows->filter(fn (array $row) => (int) $row['hadir'] !== 1)->count();
        $totalEvaluasi = $totalHadir + $totalTidakHadir;
        $persentaseHadir = $totalEvaluasi > 0 ? round(($totalHadir / $totalEvaluasi) * 100, 1) : 0.0;

        return view('operators.personal-attendance', [
            'operator' => $operator,
            'attendanceRows' => $attendanceRows,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'filterDateLabel' => $filterDateLabel,
            'summaryStats' => [
                'total_hadir' => $totalHadir,
                'total_tidak_hadir' => $totalTidakHadir,
                'total_evaluasi' => $totalEvaluasi,
                'persentase_hadir' => $persentaseHadir,
            ],
        ]);
    }

    protected function normalizeYmdDate(string $date): string
    {
        if ($date === '') {
            return '';
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $date)->toDateString();
        } catch (\Throwable) {
            return '';
        }
    }
}