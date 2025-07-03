<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function clockIn()
{
    $time = now(); // 現在時刻を取得

    Attendance::create([
        'user_id' => Auth::id(),
        'clock_in' => $time,
    ]);

    return redirect()->back()->with([
        'message' => '出勤を記録しました。',
        'timestamp' => $time->format('Y年m月d日 H:i:')
    ]);
}

public function clockOut(Request $request)
{
    $attendance = Attendance::where('user_id', auth()->id())
        ->whereDate('clock_in', \Carbon\Carbon::today())
        ->latest()
        ->first();

    if ($attendance && is_null($attendance->clock_out)) {
        $attendance->update([
            'clock_out' => \Carbon\Carbon::now(),
        ]);

        return redirect()->route('dashboard')->with('message', '退勤しました、お疲れさまでした。');
    }

    return redirect()->route('dashboard')->with('message', 'すでに退勤済みか、出勤記録が見つかりません');
}

}

