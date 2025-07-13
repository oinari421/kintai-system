<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            出退勤の編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('attendance.confirm', $attendance->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="clock_in" class="block text-sm font-medium text-gray-700">出勤時間</label>
                        <input type="datetime-local" name="clock_in" id="clock_in" value="{{ $attendance->clock_in ? $attendance->clock_in->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="clock_out" class="block text-sm font-medium text-gray-700">退勤時間</label>
                        <input type="datetime-local" name="clock_out" id="clock_out" value="{{ $attendance->clock_out ? $attendance->clock_out->format('Y-m-d\TH:i') : '' }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            変更実行
                        </button>

                        <!-- ✅ 一覧に戻るボタン -->
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            一覧に戻る
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
