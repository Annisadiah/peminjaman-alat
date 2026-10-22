<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;

class DashboardController extends Controller
{
    public function index()
    {
        $logs = LogAktivitas::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('logs'));
    }
}
