@extends('layouts/app')

@section('content')
    <div class="mt-20 px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($data->isNotEmpty())
                @foreach ($data as $item)
                    <div class="rounded-xl bg-white dark:bg-gray-900 shadow-lg overflow-hidden">
                        <div class="flex flex-col items-center p-6">
                            <div
                                class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-500 p-1 shadow-lg">
                                <svg class="w-full h-full rounded-full bg-gray-800 dark:bg-gray-700 p-2"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white">
                                    <path
                                        d="M16 2L21 7V21.0082C21 21.556 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44495 2 3.9934 2H16ZM12 11.5C13.3807 11.5 14.5 10.3807 14.5 9C14.5 7.61929 13.3807 6.5 12 6.5C10.6193 6.5 9.5 7.61929 9.5 9C9.5 10.3807 10.6193 11.5 12 11.5ZM7.52746 17H16.4725C16.2238 14.75 14.3163 13 12 13C9.68372 13 7.77619 14.75 7.52746 17Z">
                                    </path>
                                </svg>
                            </div>
                            <h5 class="mt-4 text-lg font-semibold text-gray-800 dark:text-white text-center">
                                {{ $item->name }} {{ $item->surname }}
                            </h5>
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                <strong>Oddíl:</strong> {{ $item->teams_name }}
                            </span>
                            <div class="mt-4">
                                <a href="/dashboard/members/{{ $item->id }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-md hover:bg-blue-600 focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-500">
                                    Zobrazit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <h1 class="mt-10 text-4xl font-semibold text-gray-800 dark:text-white text-center">
                    Nebyli vám přiřazeni žádní členové!
                </h1>
            @endif
        </div>
    </div>
@endsection
