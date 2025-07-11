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
        <th class="px-4 py-2 text-center">編集</th>
        <th class="px-4 py-2 text-center">管理者</th>
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

        {{-- 編集ボタン --}}
        <td class="px-4 py-2 text-center">
            @if ($user->todayClockIn)
                <a href="{{ route('attendance.edit', $user->todayClockIn->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold px-3 py-1 rounded shadow">
                    編集
                </a>
            @else
                <span class="text-gray-400 text-sm">-</span>
            @endif
        </td>

        {{-- 管理者付与／解除ボタン --}}
        <td class="px-4 py-2 text-center">
            <form method="POST" action="{{ route('admin.toggle', $user->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit"
                        class="{{ $user->is_admin ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}
                               text-white text-sm font-semibold px-3 py-1 rounded shadow">
                    {{ $user->is_admin ? '管理者解除' : '管理者付与' }}
                </button>
            </form>
        </td>
    </tr>
@endforeach
</tbody>


                </table>
            </div>
        </div>
    </div>
</x-app-layout>
