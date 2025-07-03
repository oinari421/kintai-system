<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $date = $request->input('date') ?? Carbon::today()->toDateString();

        $users = User::with(['attendances' => function ($query) use ($date) {
            $query->whereDate('clock_in', $date);
        }])->get();

        foreach ($users as $user) {
            $user->todayClockIn = $user->attendances->first();
        }

        return view('admin.dashboard', compact('users', 'date'));
    }

    public function edit(Attendance $attendance)
    {
        return view('admin.edit-attendance', compact('attendance'));
    }

  public function confirm(Request $request, Attendance $attendance)
{
   $request->validate([
    'clock_in' => 'nullable|date',
    'clock_out' => 'nullable|date',
]);


    $newClockIn = $request->input('clock_in');
    $newClockOut = $request->input('clock_out');

    // 変更前の時刻
    $oldClockIn = optional($attendance->clock_in)->format('Y-m-d H:i');
    $oldClockOut = optional($attendance->clock_out)->format('Y-m-d H:i');

    return view('admin.confirm-attendance', compact(
        'attendance', 'oldClockIn', 'oldClockOut', 'newClockIn', 'newClockOut'
    ));
}


    // ✅ 更新処理（確認後の確定ボタンから来る）
    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
    'clock_in' => 'nullable|date',
    'clock_out' => 'nullable|date',
]);


        $beforeIn = $attendance->clock_in;
        $beforeOut = $attendance->clock_out;

        $attendance->clock_in = $request->clock_in;
        $attendance->clock_out = $request->clock_out;
        $attendance->save();

        $message = "出退勤時間を更新しました。";
        if ($beforeIn != $attendance->clock_in) {
            $message .= " 出勤：" . \Carbon\Carbon::parse($beforeIn)->format('H:i') . " → " . \Carbon\Carbon::parse($attendance->clock_in)->format('H:i');
        }
        if ($beforeOut != $attendance->clock_out) {
            $message .= " 退勤：" . \Carbon\Carbon::parse($beforeOut)->format('H:i') . " → " . \Carbon\Carbon::parse($attendance->clock_out)->format('H:i');
        }

        return redirect()->route('admin.dashboard')->with('message', $message);
    }
}
