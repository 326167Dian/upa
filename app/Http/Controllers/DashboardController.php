<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Kehadiran;
use App\Models\Operator;
use App\Models\Pengumuman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
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
        ]);
    }
}