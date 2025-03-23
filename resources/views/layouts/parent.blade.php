<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kormorán 11</title>
    <meta charset="UTF-8">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (Route::is('dashboard.calendar'))
        @vite(['resources/css/calendar.css'])
    @elseif (Route::is('dashboard.attendance'))
        @vite(['resources/js/attendance.js'])
    @endif
    @vite(['resources/css/background.css'])
    <meta name="viewport" content="width=device-width, initial-scale=1" />
</head>

<body class="bg-gray-100 font-sans text-gray-900 antialiased dark:bg-gray-900 dark:text-white">
    <nav
        class="fixed top-0 left-0 z-50 w-full bg-gray-900 border-b border-gray-800/50 shadow-lg backdrop-blur-sm bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="lg:hidden flex items-center justify-center w-10 h-10 rounded-full bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        <span class="sr-only">Otevřít levý panel</span>
                        <i class="fas fa-bars"></i>
                    </button>
                    <a href="/dashboard"
                        class="flex items-center gap-2 sm:gap-3 text-white group transition-all duration-300 hover:scale-105">
                        <div class="bg-blue-600 p-1.5 rounded-lg shadow-md group-hover:bg-blue-500 hidden xxs:block">
                            <img src="{{ asset('storage/kormoran.jpg') }}" alt="Kormoran" class="h-9 w-9 rounded-lg">
                        </div>
                        <span class="text-lg sm:text-xl font-bold tracking-tight">Kormorán 11</span>
                    </a>
                </div>
                <div class="flex items-center gap-2 sm:gap-3">
                
                    <div class="relative group">
                        <button type="button"
                            class="flex items-center gap-1 sm:gap-2 px-2 sm:px-3 py-1.5 rounded-full bg-gray-800 hover:bg-gray-700 text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                            data-dropdown-toggle="dropdown-user">
                            <div
                                class="w-7 h-7 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                                <span
                                    class="text-xs font-bold text-white">{{ Str::upper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span
                                class="hidden sm:inline text-sm font-medium truncate max-w-[80px] sm:max-w-[100px]">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                        </button>
                        <div id="dropdown-user"
                            class="hidden z-50 w-64 mt-2 bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-700">
                            <div class="px-4 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center mr-3">
                                        <span
                                            class="text-sm font-bold text-white">{{ Str::upper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}
                                            {{ Auth::user()->surname }}</p>
                                        <p class="text-xs text-blue-100 truncate mt-0.5">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                            <ul class="py-2">
                                @if (Route::currentRouteName() != 'dashboard')
                                    <li>
                                        <a href="/dashboard"
                                            class="flex items-center px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
                                            <i class="fas fa-home-alt w-5 mr-2 text-blue-400"></i>
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
                                            class="w-full text-left flex items-центer px-4 py-2.5 text-sm text-gray-300 hover:bg-gray-700 hover:text-white transition-colors">
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
                            <i class="fas fa-ellipsis-v"></i>
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
    </nav>
    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-16 transition-transform -translate-x-full bg-gray-900 border-r border-gray-800/50 lg:translate-x-0">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-gray-900">
            <div class="px-3 py-2">
                <h3 class="text-xs uppercase font-semibold text-gray-500 tracking-wider">Profil skauta</h3>
            </div>
            <div class="px-3 py-2 mb-4 bg-gray-800/50 rounded-lg">
                <div class="flex items-center mb-3">
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center mr-3">
                        <span class="text-sm font-bold text-white">{{ substr($members->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ $members->name }} {{ $members->surname }}</p>
                        <p class="text-xs text-gray-400">Družina: {{ $teamname->name }}</p>
                    </div>
                </div>
            </div>
            <div class="mt-8 pt-4 border-t border-gray-800"></div>
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="/dashboard"
                        class="flex items-center p-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 group">
                        <div
                            class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-200">
                            <i class="fas fa-home "></i>
                        </div>
                        <span class="flex-1 ms-3 font-medium">Hlavní panel</span>

                    </a>
                </li>
                @if (Route::currentRouteName() == 'dashboard.members')
                    <li class="bg-blue-800 rounded-lg">
                    @else
                    <li>
                @endif
                <a href="/dashboard/members/{{ $members->id }}"
                    class="flex items-center p-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 group">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-200">

                        <i class="fa fa-list"></i>
                    </div>
                    <span class="flex-1 ms-3 font-medium">Přehled</span>

                </a>
                </li>
                @if (Route::currentRouteName() == 'dashboard.attendance')
                    <li class="bg-blue-800 rounded-lg">
                    @else
                    <li>
                @endif

                <a href="/dashboard/members/attendance/{{ $members->id }}"
                    class="flex items-center p-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 group">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-200">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span class="flex-1 ms-3 font-medium">Potvrzení účasti</span>

                </a>
                </li>
                @if (Route::currentRouteName() == 'dashboard.achievements')
                    <li class="bg-blue-800 rounded-lg">
                    @else
                    <li>
                @endif
                <a href="/dashboard/members/achievements/{{ $members->id }}"
                    class="flex items-center p-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 group">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-200">
                        <i class="fas fa-award"></i>
                    </div>
                    <span class="flex-1 ms-3 font-medium">Odborky</span>
                    <span
                        class="inline-flex items-center justify-center h-5 px-2 ms-2 text-xs font-medium text-white bg-blue-600 rounded-full">{{ count($achievements) }}</span>
                </a>
                </li>
                @if (Route::currentRouteName() == 'dashboard.calendar')
                    <li class="bg-blue-800 rounded-lg">
                    @else
                    <li>
                @endif
                <a href="/dashboard/members/calendar/{{ $members->id }}"
                    class="flex items-center p-2 rounded-lg text-gray-300 hover:bg-gray-800 hover:text-white transition-all duration-200 group">
                    <div
                        class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-800 text-blue-400 group-hover:bg-blue-600 group-hover:text-white transition-all duration-200">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <span class="flex-1 ms-3 font-medium">Kalendář akcí</span>
                    <span
                        class="inline-flex items-center justify-center h-5 px-2 ms-2 text-xs font-medium text-white bg-blue-600 rounded-full">{{ $upcomingeventcount }}</span>
                </a>
                </li>
            </ul>
        </div>
    </aside>
    <main class="lg:pl-2 pt-16 min-h-screen">
        @yield('content')
    </main>
</body>

</html>
