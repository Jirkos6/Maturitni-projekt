@extends('layouts/app')
@section('content')
    <div class="p-4 flex flex-col min-h-screen bg-gray-50 items-center">

        <div class="w-full max-w-7xl text-center mt-20">
            <button
                class="px-6 py-2 text-sm font-semibold text-white bg-blue-400 hover:bg-blue-600 rounded-lg transition duration-300 mb-5"
                onClick="history.back()">
                Zpátky
            </button>
        </div>
        <div class="w-full max-w-7xl bg-white shadow-lg rounded-lg px-4 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>
                <x-section-border />
            @endif
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>
                <x-section-border />
            @endif
            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

        </div>
    </div>
@endsection
