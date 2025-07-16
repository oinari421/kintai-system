<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            管理者ダッシュボード
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="px-4">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">ユーザー一覧</h3>

                <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-4">
                    <label for="date">日付を選択:</label>
                    <input type="date" name="date" id="date" value="{{ request('date', $date ?? '') }}">
                    <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">検索</button>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-[800px] text-left text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 whitespace-nowrap">名前</th>
                                <th class="px-4 py-2 whitespace-nowrap">メール</th>
                                <th class="px-4 py-2 whitespace-nowrap">出勤</th>
                                <th class="px-4 py-2 whitespace-nowrap">退勤</th>
                                <th class="px-4 py-2 text-center whitespace-nowrap">編集</th>
                                <th class="px-4 py-2 text-center whitespace-nowrap">編集履歴の有無</th>
                                <th class="px-4 py-2 text-center whitespace-nowrap">権限</th>
                                <th class="px-4 py-2 text-center whitespace-nowrap">管理者付与</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-t border-gray-300 hover:bg-gray-50">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $user->name }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $user->email }}</td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        {{ $user->todayClockIn?->clock_in?->format('H:i') ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        {{ $user->todayClockIn?->clock_out?->format('H:i') ?? '-' }}
                                    </td>
                           <td class="px-4 py-2 text-center whitespace-nowrap w-auto">
                        @if ($user->todayClockIn)
    <a
      href="{{ route('attendance.edit', $user->todayClockIn->id) }}"
      class="inline-block bg-blue-500 hover:bg-blue-600 text-white text-xs sm:text-sm font-semibold px-3 py-1 rounded shadow whitespace-nowrap">
      編集
    </a>
  @else
    <span class="text-gray-400 text-sm">-</span>
  @endif
</td>

                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        @if ($user->todayClockIn && $user->todayClockIn->is_edited)
                                            <span class="text-red-500 font-semibold">編集済</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <span class="inline-block px-2 py-1 rounded-full text-xs sm:text-sm font-semibold {{ $user->is_admin ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-800' }}">
                                            {{ $user->is_admin ? '管理者' : '一般' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center whitespace-nowrap">
                                        <button onclick="openModal('{{ $user->id }}', '{{ $user->name }}', {{ $user->is_admin ? 'true' : 'false' }})"
                                            type="button" class="bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm px-3 py-1 rounded whitespace-nowrap">
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
    </div>

    <!-- モーダル -->
    <div id="adminModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h3 class="text-lg font-bold mb-4 flex items-center">
                <span class="mr-2">🔒</span> 管理者権限の変更確認
            </h3>
            <p id="adminModalMessage" class="mb-6 text-sm text-gray-800">
                ユーザーの管理者権限を変更しますか？
            </p>

            <div class="flex justify-center gap-4">
                <button onclick="closeModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">
                    いいえ
                </button>

                <form id="adminModalForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded shadow">
                        はい
                    </button>
                </form>
            </div>
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
