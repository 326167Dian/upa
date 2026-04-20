<?php

namespace App\Http\Controllers;

use App\Models\Operator;
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
        ]);
    }
}