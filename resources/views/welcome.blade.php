<!-- resources/views/welcome.blade.php -->

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- ✅ 追加！ -->
    <title>オーガランド 勤怠管理システム</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 text-center"> <!-- ✅ padding追加 -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-6">
            オーガランド 勤怠管理システム
        </h1>

        <p class="text-sm sm:text-base md:text-lg mb-8">
            社員の出勤・退勤をスマートに管理する社内ツール
        </p>

        @if (Route::has('login'))
            <div class="flex flex-col sm:flex-row gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-blue-600 underline">ダッシュボードへ</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 text-sm sm:text-base">
                        ログイン
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 text-sm sm:text-base">
                            登録
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
