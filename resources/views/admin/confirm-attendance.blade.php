<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            編集内容の確認
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-bold mb-4">以下の内容に変更します。よろしいですか？</h3>

                <div class="mb-4">
                    <p>■ 出勤時間</p>
                    <p>変更前：{{ $oldClockIn ?? 'なし' }}</p>
                    <p>変更後：{{ $newClockIn ?? 'なし' }}</p>
                </div>

                <div class="mb-4">
                    <p>■ 退勤時間</p>
                    <p>変更前：{{ $oldClockOut ?? 'なし' }}</p>
                    <p>変更後：{{ $newClockOut ?? 'なし' }}</p>
                </div>

                <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="clock_in" value="{{ $newClockIn }}">
                    <input type="hidden" name="clock_out" value="{{ $newClockOut }}">

                    <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white">
                        ✅ この内容で確定
                    </x-primary-button>
                </form>

                <div class="mt-4">
                    <a href="{{ route('attendance.edit', $attendance->id) }}" class="text-blue-500 underline">
                        🔙 修正する
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
