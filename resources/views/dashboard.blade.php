{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    {{-- ✅ 管理者専用リンク --}}
                    @if (Auth::user()->is_admin)
                        <div class="mb-4">
                            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 underline">
                                🔒 管理者メニュー
                            </a>
                        </div>
                    @endif

                    {{-- ✅ 本日の日付 --}}
                    <p class="text-lg font-bold mb-4">
                        本日：{{ \Carbon\Carbon::today()->format('Y年m月d日（D）') }}
                    </p>

                    {{-- ✅ メッセージ表示 --}}
                    @if (session('message'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('message') }}
                        </div>
                    @endif

                    {{-- ✅ 出勤済み情報 --}}
                    @if ($todayClockIn)
                        <p class="mb-2">出勤：{{ \Carbon\Carbon::parse($todayClockIn->clock_in)->format('H:i') }}</p>

                        @if ($todayClockIn->clock_out)
                            <p class="mb-4">退勤：{{ \Carbon\Carbon::parse($todayClockIn->clock_out)->format('H:i') }}</p>
                        @endif
                    @endif

                    {{-- ✅ 出勤ボタン --}}
                    @unless ($todayClockIn)
                        <form method="POST" action="{{ route('attendance.clockIn') }}" class="mb-4">
                            @csrf
                            <x-primary-button>出勤</x-primary-button>
                        </form>
                    @endunless

                    {{-- ✅ 退勤ボタン --}}
                    @if ($todayClockIn && is_null($todayClockIn->clock_out))
                        <form method="POST" action="{{ route('attendance.clockOut') }}">
                            @csrf
                            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded">
                                退勤
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
