<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kormorán 11</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (Route::currentRouteName() != 'dashboard.settings')
        @vite(['resources/css/background.css'])
    @endif
</head>
@if (Route::currentRouteName() != 'dashboard.settings')

    <body class="bg-gray-100 font-sans text-gray-900 antialiased dark:bg-gray-900 dark:text-white">
    @else

        <body>
@endif
<nav
    class="fixed top-0 left-0 z-50 w-full bg-gray-900 border-b border-gray-800/50 shadow-lg backdrop-blur-sm bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-center h-16">
            <div class="grid grid-cols-3 items-center w-full max-w-6xl">
                <div class="flex items-center">
                    <a href="/dashboard"
                        class="flex items-center gap-3 text-white group transition-all duration-300 hover:scale-105">
                        <div class="bg-blue-600 p-1.5 rounded-lg shadow-md group-hover:bg-blue-500 hidden xxs:block">
                            <img src="{{ asset('storage/kormoran.jpg') }}" alt="Kormoran" class="h-9 w-9 rounded-lg">
                        </div>
                        <span class="text-xl font-bold tracking-tight">Kormorán</span>
                    </a>
                </div>
                <div class="flex items-center justify-center">
                    <div class="hidden md:flex items-center bg-gray-800/60 rounded-full px-1.5 py-1">
                        <a href="/dashboard"
                            class="flex items-center px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-200 ease-in-out
                                      {{ Route::currentRouteName() == 'dashboard' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                            <i
                                class="fas fa-home mr-2 {{ Route::currentRouteName() == 'dashboard' ? 'text-white' : 'text-blue-400' }}"></i>
                            <span>Hlavní Panel</span>
                        </a>

                    </div>
                </div>
                <div class="flex items-center justify-end gap-2">

                    <div class="relative group">
                        <button type="button"
                            class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                            data-dropdown-toggle="dropdown-user">
                            <div class="w-7 h-7 rounded-full bg-blue-600 flex items-center justify-center shadow-md">
                                <span
                                    class="text-xs font-bold text-white">{{ Str::upper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span
                                class="hidden sm:inline text-sm font-medium truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        <div id="dropdown-user"
                            class="hidden z-50 w-64 mt-2 bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                            <div class="px-4 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center mr-3">
                                        <span
                                            class="text-sm font-bold text-white">{{ Str::upper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">
                                            {{ Auth::user()->name }} {{ Auth::user()->surname }}
                                        </p>
                                        <p class="text-xs text-blue-100 truncate mt-0.5">
                                            {{ Auth::user()->email }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <ul class="py-2">
                                @if (Route::currentRouteName() != 'dashboard')
                                    <li>
                                        <a href="/dashboard"
                                            class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                            <i class="fas fa-tachometer-alt w-5 mr-2 text-blue-400"></i>
                                            Hlavní panel
                                        </a>
                                    </li>
                                @endif
                                @if (Auth::user()->role == 'admin')
                                    <li>
                                        <a href="/"
                                            class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                            <i class="fas fa-shield-alt w-5 mr-2 text-blue-400"></i>
                                            Administrace
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="/settings"
                                        class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                        <i class="fas fa-cog w-5 mr-2 text-blue-400"></i>
                                        Nastavení účtu
                                    </a>
                                </li>
                                <li class="border-t border-gray-700 mt-1">
                                    <form action="/logout" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                            <i class="fas fa-sign-out-alt w-5 mr-2 text-red-400"></i>
                                            Odhlásit se
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="md:hidden">
                        <button type="button"
                            class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                            data-dropdown-toggle="mobile-menu">
                            <span class="sr-only">Otevřít menu</span>
                            <i class="fas fa-bars"></i>
                        </button>
                        <div id="mobile-menu"
                            class="hidden absolute right-4 mt-2 w-56 bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                            <div class="py-2">
                                <a href="/dashboard"
                                    class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                    <i class="fas fa-home w-5 mr-2 text-blue-400"></i>
                                    Hlavní panel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>
</body>

</html>
