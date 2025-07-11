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
                                <td class="px-4 py-2 text-center">
                                    <button onclick="openModal('{{ $user->id }}', '{{ $user->name }}', {{ $user->is_admin ? 'true' : 'false' }})"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold px-3 py-1 rounded shadow">
                                        管理者変更
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- モーダル部分 -->
    <div id="adminModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-700 rounded-lg shadow-lg p-6 w-full max-w-md">
            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">🔒 管理者権限の変更確認</h2>
            <p id="adminModalMessage" class="mb-4 text-gray-700 dark:text-gray-200"></p>

            <form id="adminModalForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">キャンセル</button>
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">実行</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function openModal(userId, userName, isAdmin) {
            const form = document.getElementById('adminModalForm');
            const message = document.getElementById('adminModalMessage');
            const modal = document.getElementById('adminModal');

            const actionUrl = `/admin/${userId}/toggle`;
            form.action = actionUrl;

            message.innerText = `${userName}さんの管理者権限を ${isAdmin ? '解除' : '付与'} しますか？`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('adminModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
