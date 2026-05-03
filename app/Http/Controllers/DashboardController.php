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

        return view('dashboard.index', [
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
            'absensiDates' => $absensiDates,
            'selectedAbsensiDate' => $selectedAbsensiDate,
            'absensiList' => $absensiList,
        ]);
    }
}