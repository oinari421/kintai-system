<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $todayClockIn = Attendance::where('user_id', $userId)
            ->whereDate('clock_in', Carbon::today())
            ->first();

        return view('dashboard', [
            'todayClockIn' => $todayClockIn,
        ]);
    }
}
