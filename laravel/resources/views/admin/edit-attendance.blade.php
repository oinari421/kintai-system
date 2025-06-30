<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            出退勤の編集
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('attendance.confirm', $attendance->id) }}">
    @csrf


                    <div class="mb-4">
    <label for="clock_in" class="block font-bold mb-1">出勤時間</label>
    <input type="datetime-local" id="clock_in" name="clock_in"
           value="{{ old('clock_in', $attendance->clock_in ? $attendance->clock_in->format('Y-m-d\TH:i') : '') }}"
           class="w-full border rounded px-3 py-2">
    @error('clock_in')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-4">
    <label for="clock_out" class="block font-bold mb-1">退勤時間</label>
    <input type="datetime-local" id="clock_out" name="clock_out"
           value="{{ old('clock_out', $attendance->clock_out ? $attendance->clock_out->format('Y-m-d\TH:i') : '') }}"
           class="w-full border rounded px-3 py-2">
    @error('clock_out')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>


               <button type="submit"
    class="bg-blue-600 text-white text-lg px-6 py-3 rounded hover:bg-blue-700 border border-blue-800 mt-4">
    ✅ 
</button>


                </form>
            </div>
        </div>
    </div>
</x-app-layout>
