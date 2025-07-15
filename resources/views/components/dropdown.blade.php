@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white text-black' // ← 文字色を黒に固定
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $width = match ($width) {
        '48' => 'w-48',
        default => $width,
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <!-- トリガー（クリックで開く） -->
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <!-- ドロップダウンメニュー本体 -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}"
         style="display: none;"
         @click="open = false"
    >
        <!-- 内部コンテンツ：背景白・文字黒を固定 -->
        <div class="rounded-md ring-1 ring-black ring-opacity-5 bg-white text-black {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
