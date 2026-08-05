<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold text-gray-900 mb-1">Masuk ke Akun Anda</h2>
    <p class="text-sm text-gray-500 mb-6">Selamat datang kembali! Silakan masukkan kredensial Anda.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1.5 w-full" type="email" name="email" :value="old('email')" placeholder="nama@um.ac.id" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1.5 w-full"
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-2">
            <x-primary-button class="w-full justify-center">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <p class="text-center text-xs text-gray-500 mt-4">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-semibold text-primary-600 hover:text-primary-700 transition">Daftar sekarang</a>
        </p>
    </form>
</x-guest-layout>
