@props(['disabled' => false, 'icon' => null])

<div class="relative">
    @if ($icon === 'email')
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
    @elseif($icon === 'password')
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
    @endif

    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'w-full rounded-md border border-gray-800 bg-gray-900/50 py-2 ' .
            ($icon ? 'pl-10' : 'px-4') .
            ' text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none',
    ]) !!}>

    @if ($attributes['type'] === 'password')
        <button type="button" onclick="togglePasswordVisibility('{{ $attributes['id'] }}')"
            class="absolute right-2 top-2 rounded-md p-1 text-gray-700 hover:text-gray-500 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="password-eye-icon h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="password-eye-off-icon hidden h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
            </svg>
        </button>
    @endif
</div>

@once
    <script>
        function togglePasswordVisibility(inputId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcons = document.querySelectorAll(
                `#${inputId} ~ button .password-eye-icon, #${inputId} ~ button .password-eye-off-icon`);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcons[0].classList.add('hidden');
                eyeIcons[1].classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcons[0].classList.remove('hidden');
                eyeIcons[1].classList.add('hidden');
            }
        }
    </script>
@endonce
