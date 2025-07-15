<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- 名前 -->
        <div>
            <x-input-label for="name" :value="'名前'" />
            <x-text-input id="name"  class="block mt-1 w-full bg-gray-200 text-gray-900 border border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- メールアドレス -->
        <div class="mt-4">
            <x-input-label for="email" :value="'メールアドレス'" />
            <x-text-input id="email" class="block mt-1 w-full bg-white text-gray-900" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- パスワード -->
        <div class="mt-4">
            <x-input-label for="password" :value="'パスワード'" />
            <x-text-input id="password" class="block mt-1 w-full bg-white text-gray-900"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- パスワード確認 -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="'パスワード確認'" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-white text-gray-900"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- ボタン -->
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                登録済みの方はこちら
            </a>

            <x-primary-button class="ml-4">
                登録する
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
