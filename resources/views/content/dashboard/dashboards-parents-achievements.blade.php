@extends('layouts.parent')

@section('content')
    <div class="container mx-auto px-4 py-10 lg:pl-72">
        <div class="grid grid-cols-1 xl:grid-cols-1 gap-12 mt-10">
            <div class="bg-white dark:bg-gray-900 rounded-3xl shadow-2xl p-12 border border-gray-300 dark:border-gray-700">
                <div class="mb-10 pb-6 border-b border-gray-300 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <span class="text-4xl font-bold text-blue-500 font-sans">{{ count($achievements) }}</span>
                        <i class="ri-award-line text-blue-500 text-5xl"></i>
                        <h2 class="text-3xl font-bold text-gray-800 dark:text-white font-sans">
                            <strong>Získané Odborky</strong>
                        </h2>
                    </div>
                </div>
                <div class="flex flex-col gap-y-8">
                    @foreach ($achievements as $item)
                        <div class="flex items-center bg-gray-50 dark:bg-gray-800 rounded-lg p-6 shadow-lg">
                            <img src="{{ asset('storage/achievements/' . $item->image) }}" alt="{{ $item->name }}"
                                class="w-20 h-20 object-cover rounded-lg border border-gray-300 dark:border-gray-700">
                            <div class="ml-6">
                                <h3 class="text-xl font-bold text-gray-800 dark:text-white">{{ $item->name }}</h3>
                                <p class="text-base text-gray-600 dark:text-gray-400">{{ $item->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
@endsection
