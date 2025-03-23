@extends('layouts/app')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex flex-col items-center pt-12 pb-16 px-4 sm:px-6 lg:px-8 mt-12">
        <header class="text-center mb-12">
            <h1 class="text-4xl font-light text-gray-800 dark:text-gray-100 tracking-wide">
                Vaše děti
            </h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Přehled
            </p>
        </header>
        <div class="w-full max-w-2xl">
            @if ($data->isNotEmpty())
                <ul class="space-y-4">
                    @foreach ($data as $item)
                        <li
                            class="group flex items-center justify-between p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm hover:shadow-lg hover:bg-gradient-to-r hover:from-indigo-50 hover:to-blue-50 dark:hover:from-indigo-900/50 dark:hover:to-blue-900/50">
                            <div class="flex items-center space-x-3">
                                <div class="relative w-10 h-10 flex-shrink-0">
                                    <div
                                        class="absolute inset-0 rounded-full bg-gradient-to-br from-green-400 to-blue-500 p-0.5 ">
                                        <div
                                            class="w-full h-full rounded-full bg-white dark:bg-gray-800 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M4 22C4 17.5817 7.58172 14 12 14C16.4183 14 20 17.5817 20 22H4ZM12 13C8.685 13 6 10.315 6 7C6 3.685 8.685 1 12 1C15.315 1 18 3.685 18 7C18 10.315 15.315 13 12 13Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h2 class="text-base font-medium text-gray-900 dark:text-gray-100">
                                        {{ $item->name }} {{ $item->surname }}
                                    </h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Oddíl: <span
                                            class="font-medium text-green-600 dark:text-green-400">{{ $item->teams_name }}</span>
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('dashboard.members', $item->id) }}"
                                class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30 rounded-full hover:bg-green-200 dark:hover:bg-green-900/50 transition-all duration-200 group-hover:scale-105">
                                Zobrazit
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="text-center py-16">
                    <h2 class="text-xl font-medium text-gray-700 dark:text-gray-200">
                        Nebyli Vám přižazeny žádní skauti. Počkejte než je Vám vedení přidělí.
                    </h2>
                </div>
            @endif
        </div>
    </div>
@endsection
