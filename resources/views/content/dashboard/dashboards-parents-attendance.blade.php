@extends('layouts.parent')

@section('content')
    @use('\Carbon\Carbon')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:pl-64 pt-20">
        <div id="notification-container" class="mb-6"></div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div id="attendance-container">
            @if ($attendances->isNotEmpty())
                <div
                    class="overflow-x-auto rounded-xl shadow-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full text-sm text-gray-800 dark:text-gray-300">
                        <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="py-4 px-6 text-left font-medium">Akce</th>
                                <th class="py-4 px-6 text-left font-medium">Popis</th>
                                <th class="py-4 px-6 text-left font-medium">Začátek</th>
                                <th class="py-4 px-6 text-left font-medium">Konec</th>
                                <th class="py-4 px-6 text-center font-medium">Potvrzení</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                                    id="row-{{ $attendance->id }}">
                                    <td class="py-4 px-6">
                                        <p class="font-semibold text-gray-800 dark:text-white">
                                            {{ $attendance->event->title }}
                                        </p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="text-gray-600 dark:text-gray-400 truncate max-w-sm">
                                            {{ $attendance->event->description }}
                                        </p>
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ Carbon::parse($attendance->event->start_date)->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        {{ Carbon::parse($attendance->event->end_date)->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if ($attendance->confirmed_by_parent)
                                            <span class="text-green-500 font-medium">Potvrzeno</span>
                                        @else
                                            <button
                                                class="ajax-confirm-btn px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg shadow-md hover:bg-green-600 focus:ring-2 focus:ring-green-300 dark:focus:ring-green-700 focus:outline-none transition"
                                                data-url="{{ route('attendance.confirm', ['id' => $members->id, 'attendanceid' => $attendance->id]) }}"
                                                data-attendance-id="{{ $attendance->id }}">
                                                Potvrdit účast
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center mt-16">
                    <h2 class="font-medium text-green-600 dark:text-green-400 text-2xl">
                        Žádné akce nepotřebují potvrzení!
                    </h2>
                </div>
            @endif
        </div>
    </div>
@endsection
