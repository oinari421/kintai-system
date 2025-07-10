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
        <th>操作</th> {{-- ← 編集と管理者付与の両方をこの列に集約 --}}
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
        <td>
            <div class="flex space-x-2">
                {{-- 編集リンク --}}
                @if ($user->todayClockIn)
                    <a href="{{ route('attendance.edit', $user->todayClockIn->id) }}"
                       class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600">
                        編集
                    </a>
                @endif

                {{-- 管理者付与フォーム --}}
                @if (!$user->is_admin)
                    <form method="POST" action="{{ route('admin.promote', $user->id) }}">
                        @csrf
                        <button type="submit"
                            class="px-3 py-1 bg-green-500 text-white text-sm rounded hover:bg-green-600">
                            管理者付与
                        </button>
                    </form>
                @else
                    <span class="px-3 py-1 bg-gray-300 text-sm text-gray-700 rounded">
                        管理者
                    </span>
                @endif
            </div>
        </td>
    </tr>
@endforeach
</tbody>


                </table>
            </div>
        </div>
    </div>
</x-app-layout>
