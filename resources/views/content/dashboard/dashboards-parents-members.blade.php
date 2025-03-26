@extends('layouts.parent')

@section('content')
    @use ('Carbon\Carbon');
    <div class="container mx-auto px-4 py-10 lg:pl-72 mt-12">
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <i class="ri-time-line text-red-500 text-4xl"></i>
                        <h2 class="text-2xl font-medium text-gray-800 dark:text-white font-sans">Události bez potvrzení
                        </h2>
                    </div>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm leading-relaxed">
                </p>
                <div class="flex flex-col space-y-4">
                    @foreach ($attendances->take(4) as $attendance)
                        <div
                            class="flex flex-col bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $attendance->event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                {{ $attendance->event->description }}
                            </p>
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                <span>
                                    <strong>Začátek:</strong>
                                    {{ Carbon::parse($attendance->event->start_date)->format('d.m.Y H:i') }}
                                </span>
                                <span>
                                    <strong>Konec:</strong>
                                    {{ Carbon::parse($attendance->event->end_date)->format('d.m.Y H:i') }}
                                </span>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="flex justify-between items-center mt-6">

                    <span class="text-3xl font-semibold text-red-500 font-sans">{{ count($attendances) }}</span>
                    <a href="/dashboard/members/attendance/{{ $members->id }}">
                        <button
                            class="px-4 py-2 bg-red-500 text-white rounded-lg text-sm font-medium hover:bg-red-600 transition">
                            Zobrazit více
                        </button>
                    </a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <i class="ri-calendar-event-line text-green-500 text-4xl"></i>
                        <h2 class="text-2xl font-medium text-gray-800 dark:text-white font-sans">
                            Události Družiny
                            <strong class="align-content-center">{{ $teamname->name }}</strong>
                        </h2>
                    </div>
                </div>
                <p class="text-gray-500 dark:text-gray-400 mb-6 text-sm leading-relaxed">
                </p>
                <div class="flex flex-col space-y-4">
                    @foreach ($upcomingevents->take(4) as $event)
                        <div
                            class="flex flex-col bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                {{ $event->title }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                {{ $event->description }}
                            </p>
                            <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                <span>
                                    <strong>Začátek:</strong>
                                    {{ Carbon::parse($event->start)->format('d.m.Y H:i') }}
                                </span>
                                <span>
                                    <strong>Konec:</strong> {{ Carbon::parse($event->end)->format('d.m.Y H:i') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center mt-6">
                    <span class="text-3xl font-semibold text-green-500 font-sans">{{ $upcomingeventcount }}</span>
                    <a href="/dashboard/members/calendar/{{ $members->id }}">
                        <button
                            class="px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-medium hover:bg-green-600 transition">
                            Zobrazit více
                        </button>
                    </a>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
                <div class="mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <i class="ri-award-line text-blue-500 text-4xl"></i>
                        <h2 class="text-2xl font-medium text-gray-800 dark:text-white font-sans"><strong>Odborky</strong>
                        </h2>
                    </div>
                </div>
                <div class="flex flex-col gap-y-4">
                    @foreach ($achievements->take(4) as $item)
                        <div class="flex items-center bg-gray-50 dark:bg-gray-800 rounded-lg p-4 shadow-sm">

                            <img src="{{ asset('storage/achievements/' . $item->image) }}" alt="{{ $item->name }}"
                                class="w-16 h-16 object-cover rounded-md border border-gray-200 dark:border-gray-700">
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $item->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex justify-between items-center mt-6">
                    <span class="text-3xl font-semibold text-blue-500 font-sans">{{ count($achievements) }}</span>
                    <a href="/dashboard/members/achievements/{{ $members->id }}">
                        <button
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg text-sm font-medium hover:bg-blue-600 transition">
                            Zobrazit více
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
