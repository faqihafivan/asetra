<x-guest-layout>
    <div x-data="{
        email: '{{ old('email') }}',
        password: '',
        showPass: false
    }">

        {{-- Header: Logo + Title --}}
        <div class="flex items-center gap-3 mb-5">
            <div class="p-2 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg shadow-blue-200 shrink-0">
                <img src="{{ asset('logo.png') }}" class="h-8 w-8 object-contain" alt="ASETRA">
            </div>
            <div>
                <h1 class="text-lg font-extrabold text-gray-900 tracking-wide leading-tight">ASETRA</h1>
                <p class="text-xs text-gray-400 leading-tight">Sistem Manajemen Aset</p>
            </div>
        </div>

        {{-- Greeting --}}
        <div class="mb-5">
            <h2 class="text-xl font-extrabold text-gray-900">Selamat Datang 👋</h2>
            <p class="text-xs text-gray-400 mt-0.5">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        <x-auth-session-status class="mb-3 text-xs" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Email</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <input id="email" type="email" name="email" x-model="email"
                           required autofocus autocomplete="username"
                           placeholder="nama@email.com"
                           class="block w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-400 bg-red-50 @enderror">
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs" />
            </div>

            {{-- Password --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-bold text-gray-600 uppercase tracking-wide">Kata Sandi</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-blue-600 hover:underline font-semibold">Lupa?</a>
                    @endif
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </span>
                    <input id="password" :type="showPass ? 'text' : 'password'" name="password"
                           x-model="password" required autocomplete="current-password"
                           placeholder="••••••••"
                           class="block w-full pl-10 pr-10 py-2.5 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-400 bg-red-50 @enderror">
                    <button type="button" @click="showPass = !showPass"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition-colors">
                        <svg x-show="!showPass" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="showPass" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs" />
            </div>

            {{-- Remember + Submit --}}
            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 text-xs focus:ring-blue-500">
                    <span class="text-xs text-gray-500">Ingat saya</span>
                </label>
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-200 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Masuk ke Sistem
            </button>
        </form>

        {{-- Quick Demo Buttons --}}
        <div class="mt-4 pt-4 border-t border-gray-100">
            <p class="text-center text-xxs font-bold text-gray-300 uppercase tracking-widest mb-2.5">Demo Akun</p>
            <div class="grid grid-cols-2 gap-2">
                <button type="button"
                        @click="email = 'admin@asetra.com'; password = 'password'"
                        class="flex items-center gap-2 px-3 py-2 bg-blue-50 hover:bg-blue-100 border border-blue-100 hover:border-blue-200 rounded-xl transition-all duration-150 group">
                    <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center text-white text-xs shrink-0">A</div>
                    <div class="text-left min-w-0">
                        <p class="text-xs font-bold text-blue-700 leading-none">Admin</p>
                        <p class="text-xxs text-blue-400 truncate leading-none mt-0.5">admin@asetra.com</p>
                    </div>
                </button>
                <button type="button"
                        @click="email = 'operator@asetra.com'; password = 'password'"
                        class="flex items-center gap-2 px-3 py-2 bg-emerald-50 hover:bg-emerald-100 border border-emerald-100 hover:border-emerald-200 rounded-xl transition-all duration-150 group">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600 flex items-center justify-center text-white text-xs shrink-0">O</div>
                    <div class="text-left min-w-0">
                        <p class="text-xs font-bold text-emerald-700 leading-none">Operator</p>
                        <p class="text-xxs text-emerald-400 truncate leading-none mt-0.5">operator@asetra.com</p>
                    </div>
                </button>
            </div>
        </div>

    </div>
</x-guest-layout>
