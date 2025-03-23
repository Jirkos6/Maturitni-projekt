<x-guest-layout>
    <x-authentication-card>

        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>
        @if (\Session::has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-blue-400">
                {{ $value }}
            </div>
        @endsession

        <p class="text-sm text-gray-400 text-center mb-6">Zadejte své přihlašovací údaje</p>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-input-secondary id="email" class="block w-full" type="email" name="email" :value="old('email')"
                    required autofocus autocomplete="username" placeholder="{{ __('E-mail') }}" icon="email" />
            </div>

            <div class="mt-4">
                <x-input-secondary id="password" class="block w-full" type="password" name="password" required
                    autocomplete="current-password" placeholder="{{ __('Heslo') }}" icon="password" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-400">{{ __('Zapamatovat údaje') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-400 hover:text-blue-500" href="{{ route('password.request') }}">
                        {{ __('Zapomněli jste heslo?') }}
                    </a>
                @endif
            </div>

            <div class="mt-6">
                <x-button class="w-full justify-center">
                    {{ __('PŘIHLÁSIT SE') }}
                </x-button>
            </div>
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-800"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-gray-900 px-2 text-gray-500">Nebo</span>
                </div>
            </div>

            <a href="{{ route('google.redirect') }}"
                class="flex items-center justify-center rounded-md border border-gray-800 bg-gray-900/50 py-2 text-white transition-colors hover:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-5 w-5" viewBox="0 0 24 24">
                    <path fill="#EA4335"
                        d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z" />
                    <path fill="#34A853"
                        d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z" />
                    <path fill="#4A90E2"
                        d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z" />
                    <path fill="#FBBC05"
                        d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z" />
                </svg>
                Google
            </a>
            @if (Route::has('register'))
                <p class="text-center text-sm text-gray-400 mt-6">
                    Nemáte účet?
                    <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-400">
                        Registrovat se
                    </a>
                </p>
            @endif
        </form>
    </x-authentication-card>
</x-guest-layout>
