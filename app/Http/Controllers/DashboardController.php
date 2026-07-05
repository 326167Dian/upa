<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Operator;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $userAgent = (string) $request->header('User-Agent', '');
        $isMobileClient = (bool) preg_match('/Android|iPhone|iPad|iPod|IEMobile|Opera Mini|Mobile/i', $userAgent);

        $requestedMode = (string) $request->query('mode', '');
        if (in_array($requestedMode, ['mobile', 'desktop'], true)) {
            $request->session()->put('dashboard_mode', $requestedMode);
        }

        $preferredMode = (string) $request->session()->get('dashboard_mode', '');
        $useMobileDashboard = $isMobileClient;

        if ($preferredMode === 'desktop') {
            $useMobileDashboard = false;
        } elseif ($preferredMode === 'mobile') {
            $useMobileDashboard = true;
        }

        $recapStartDate = $this->normalizeYmdDate((string) $request->query('recap_tanggal_mulai', ''));
        $recapEndDate = $this->normalizeYmdDate((string) $request->query('recap_tanggal_selesai', ''));

        if ($recapStartDate !== '' && $recapEndDate !== '' && $recapStartDate > $recapEndDate) {
            [$recapStartDate, $recapEndDate] = [$recapEndDate, $recapStartDate];
        }

        $periodOptions = Kehadiran::query()
            ->whereNotNull('waktu')
            ->selectRaw("DATE_FORMAT(waktu, '%Y-%m') as period")
            ->distinct()
            ->orderByDesc('period')
            ->pluck('period')
            ->toArray();

        $selectedPeriod = (string) $request->query('period', '');

        if (! in_array($selectedPeriod, $periodOptions, true)) {
            $selectedPeriod = $periodOptions[0] ?? now()->format('Y-m');
        }

        $attendanceTrend = collect();
        if ($selectedPeriod && in_array($selectedPeriod, $periodOptions, true)) {
            $attendanceTrend = Kehadiran::query()
                ->whereNotNull('waktu')
                ->whereRaw("DATE_FORMAT(waktu, '%Y-%m') = ?", [$selectedPeriod])
                ->selectRaw('DATE(waktu) as tanggal, SUM(hadir) as total_hadir')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        }

        $attendancePeriodOptions = collect($periodOptions)
            ->map(fn (string $period) => [
                'value' => $period,
                'label' => Carbon::createFromFormat('Y-m', $period)->format('F Y'),
            ])
            ->values()
            ->toArray();

        $attendanceChartLabels = $attendanceTrend
            ->pluck('tanggal')
            ->map(fn (string $date) => Carbon::parse($date)->format('d-m-Y'))
            ->values()
            ->toArray();

        $attendanceChartValues = $attendanceTrend
            ->pluck('total_hadir')
            ->map(fn ($value) => (int) $value)
            ->values()
            ->toArray();

        $recapReferenceDates = Kehadiran::query()
            ->whereNotNull('waktu')
            ->when($recapStartDate !== '', fn ($query) => $query->whereDate('waktu', '>=', $recapStartDate))
            ->when($recapEndDate !== '', fn ($query) => $query->whereDate('waktu', '<=', $recapEndDate))
            ->selectRaw('DATE(waktu) as tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->pluck('tanggal')
            ->values();

        $attendanceGroupedByOperatorDate = Kehadiran::query()
            ->whereNotNull('waktu')
            ->when($recapStartDate !== '', fn ($query) => $query->whereDate('waktu', '>=', $recapStartDate))
            ->when($recapEndDate !== '', fn ($query) => $query->whereDate('waktu', '<=', $recapEndDate))
            ->select('id', 'hadir')
            ->selectRaw('DATE(waktu) as tanggal')
            ->get()
            ->groupBy('id')
            ->map(fn ($rows) => $rows->groupBy('tanggal'));

        $attendanceRecapRows = Operator::query()
            ->select('id', 'name')
            ->whereNotIn('user_id', [33, 34])
            ->orderBy('name')
            ->get()
            ->map(function (Operator $operator) use ($recapReferenceDates, $attendanceGroupedByOperatorDate): array {
                $recordsByDate = $attendanceGroupedByOperatorDate->get($operator->id, collect());

                $totalHadir = 0;
                $totalTidakHadir = 0;

                foreach ($recapReferenceDates as $dateKey) {
                    $recordsInDate = $recordsByDate->get($dateKey, collect());

                    if ($recordsInDate->isEmpty()) {
                        $totalTidakHadir++;
                        continue;
                    }

                    $isPresent = $recordsInDate->contains(fn ($item) => (int) ($item->hadir ?? 0) === 1);
                    if ($isPresent) {
                        $totalHadir++;
                    } else {
                        $totalTidakHadir++;
                    }
                }

                return [
                    'operator_id' => $operator->id,
                    'operator_name' => $operator->name,
                    'hadir' => $totalHadir,
                    'tidak_hadir' => $totalTidakHadir,
                ];
            })
            ->values();

        $recapPeriodLabel = 'Semua periode';
        if ($recapStartDate !== '' && $recapEndDate !== '') {
            $recapPeriodLabel = Carbon::parse($recapStartDate)->format('d M Y').' - '.Carbon::parse($recapEndDate)->format('d M Y');
        } elseif ($recapStartDate !== '') {
            $recapPeriodLabel = 'Mulai '.Carbon::parse($recapStartDate)->format('d M Y');
        } elseif ($recapEndDate !== '') {
            $recapPeriodLabel = 'Sampai '.Carbon::parse($recapEndDate)->format('d M Y');
        }

        // Absensi (tidak hadir) table
        $absensiDates = Kehadiran::query()
            ->where('hadir', 0)
            ->whereNotNull('waktu')
            ->selectRaw('DATE(waktu) as tanggal')
            ->distinct()
            ->orderByDesc('tanggal')
            ->pluck('tanggal')
            ->toArray();

        $selectedAbsensiDate = (string) $request->query('absensi_date', '');

        if (! in_array($selectedAbsensiDate, $absensiDates, true)) {
            $selectedAbsensiDate = $absensiDates[0] ?? '';
        }

        $absensiList = collect();
        if ($selectedAbsensiDate !== '') {
            $absensiList = Kehadiran::with('operator')
                ->where('hadir', 0)
                ->whereRaw('DATE(waktu) = ?', [$selectedAbsensiDate])
                ->orderBy('id_kehadiran')
                ->get();
        }

        return view($useMobileDashboard ? 'dashboard.mobile' : 'dashboard.index', [
            'operatorCount' => Operator::count(),
            'adminCount' => Operator::where('role', 'admin')->count(),
            'userCount' => Operator::where('role', 'user')->count(),
            'latestOperators' => Operator::latest()->take(5)->get(),
            'kegiatanCount' => Kegiatan::count(),
            'latestKegiatan' => Kegiatan::with('operator')->latest('id_kegiatan')->take(5)->get(),
            'kehadiranCount' => Kehadiran::count(),
            'latestKehadiran' => Kehadiran::with(['operator', 'kegiatan'])->latest('id_kehadiran')->take(5)->get(),
            'latestAnnouncement' => Pengumuman::with('operator')->latest('created_at')->first(),
            'attendancePeriodOptions' => $attendancePeriodOptions,
            'selectedAttendancePeriod' => $selectedPeriod,
            'attendanceChartLabels' => $attendanceChartLabels,
            'attendanceChartValues' => $attendanceChartValues,
            'attendanceRecapRows' => $attendanceRecapRows,
            'attendanceRecapPeriodLabel' => $recapPeriodLabel,
            'recapStartDate' => $recapStartDate,
            'recapEndDate' => $recapEndDate,
            'absensiDates' => $absensiDates,
            'selectedAbsensiDate' => $selectedAbsensiDate,
            'absensiList' => $absensiList,
            'isMobileClient' => $isMobileClient,
            'useMobileDashboard' => $useMobileDashboard,
        ]);
    }

    protected function normalizeYmdDate(string $date): string
    {
        if ($date === '') {
            return '';
        }

        try {
            return Carbon::createFromFormat('Y-m-d', $date)->toDateString();
        } catch (\Throwable $exception) {
            return '';
        }
    }
}