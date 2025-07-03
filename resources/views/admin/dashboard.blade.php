<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            管理者ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">ユーザー一覧</h3>
<form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
    <label for="date">日付を選択:</label>
    <input type="date" name="date" id="date" value="{{ request('date', $date ?? '') }}">
    <button type="submit">検索</button>
</form>

                <table class="w-full text-left">
                    <thead>
    <tr>
        <th>名前</th>
        <th>メール</th>
        <th>出勤</th>
        <th>退勤</th>
        <th>編集</th> {{-- ← ここを追加！ --}}
    </tr>
</thead>

  <tbody>
@foreach ($users as $user)
    <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            {{ $user->todayClockIn?->clock_in ? $user->todayClockIn->clock_in->format('H:i') : '-' }}
        </td>
        <td>
            {{ $user->todayClockIn?->clock_out ? $user->todayClockIn->clock_out->format('H:i') : '-' }}
        </td>
        <td> {{-- ← 編集列のセル開始 --}}
            @if ($user->todayClockIn)
                <a href="{{ route('attendance.edit', $user->todayClockIn->id) }}"
                   class="text-blue-600 underline hover:text-blue-800">
                    編集
                </a>
            @else
                -
            @endif
        </td> {{-- 編集列のセル終了 --}}
    </tr>
@endforeach
</tbody>


                </table>
            </div>
        </div>
    </div>
</x-app-layout>
