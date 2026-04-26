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
            ->pluck('period');

        $selectedPeriod = (string) $request->query('period', '');

        if (! $periodOptions->contains($selectedPeriod)) {
            $selectedPeriod = $periodOptions->first() ?? now()->format('Y-m');
        }

        $attendanceTrend = Kehadiran::query()
            ->whereNotNull('waktu')
            ->whereRaw("DATE_FORMAT(waktu, '%Y-%m') = ?", [$selectedPeriod])
            ->selectRaw('DATE(waktu) as tanggal, SUM(hadir) as total_hadir')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $attendancePeriodOptions = $periodOptions
            ->map(fn (string $period) => [
                'value' => $period,
                'label' => Carbon::createFromFormat('Y-m', $period)->format('F Y'),
            ])
            ->values();

        $attendanceChartLabels = $attendanceTrend
            ->pluck('tanggal')
            ->map(fn (string $date) => Carbon::parse($date)->format('d-m-Y'))
            ->values();

        $attendanceChartValues = $attendanceTrend
            ->pluck('total_hadir')
            ->map(fn ($value) => (int) $value)
            ->values();

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
        ]);
    }
}