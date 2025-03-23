<div
    class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-gray-900 to-black">
    <div>
        {{ $logo }}
    </div>

    <div
        class="w-full sm:max-w-md mt-6 px-6 py-8 bg-gradient-to-b from-gray-900/95 to-black shadow-xl overflow-hidden sm:rounded-xl border border-gray-800 text-white relative">
        <div class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>
        <div class="absolute -left-20 -top-20 h-40 w-40 rounded-full bg-blue-500/20 blur-3xl"></div>

        <h1 class="text-2xl font-bold tracking-wider text-center mb-6">PŘIHLÁŠENÍ</h1>
        {{ $slot }}
    </div>
</div>
