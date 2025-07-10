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
        <th class="px-4 py-2">名前</th>
        <th class="px-4 py-2">メール</th>
        <th class="px-4 py-2">出勤</th>
        <th class="px-4 py-2">退勤</th>
        <th class="px-4 py-2">編集</th>
    </tr>
</thead>
<tbody>
@foreach ($users as $user)
    <tr class="border-t border-gray-300">
        <td class="px-4 py-2">{{ $user->name }}</td>
        <td class="px-4 py-2">{{ $user->email }}</td>
        <td class="px-4 py-2 text-center">
            {{ $user->todayClockIn?->clock_in ? $user->todayClockIn->clock_in->format('H:i') : '-' }}
        </td>
        <td class="px-4 py-2 text-center">
            {{ $user->todayClockIn?->clock_out ? $user->todayClockIn->clock_out->format('H:i') : '-' }}
        </td>
        <td class="px-4 py-2 text-center">
            <div class="flex justify-center space-x-2">
                {{-- 編集ボタン --}}
                @if ($user->todayClockIn)
                    <a href="{{ route('attendance.edit', $user->todayClockIn->id) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-3 py-1 rounded shadow">
                        編集
                    </a>
                @endif

                {{-- 管理者付与/表示 --}}
                @if (!$user->is_admin)
                    <form method="POST" action="{{ route('admin.promote', $user->id) }}">
                        @csrf
                        <button type="submit"
                                class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold px-3 py-1 rounded shadow">
                            管理者付与
                        </button>
                    </form>
                @else
                    <span class="bg-gray-300 text-gray-800 text-sm font-semibold px-3 py-1 rounded shadow">
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
