@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')
@section('title', 'Člen - ' . $data->name . ' ' . $data->surname)

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex">
                <i class="ri-checkbox-circle-line me-2 fs-5 align-self-center"></i>
                <div>{!! \Session::get('success') !!}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (\Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex">
                <i class="ri-error-warning-line me-2 fs-5 align-self-center"></i>
                <div>{!! \Session::get('error') !!}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid py-4">
        <div class="mb-4">
            <button class="btn btn-outline-primary" onclick="history.back()">
                <i class="ri-arrow-left-line me-1"></i> Zpět na seznam
            </button>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white p-4 position-relative">
                        <div class="text-center">
                            <div class="avatar avatar-xl bg-white text-primary mx-auto mb-3">
                                {{ substr($data->name, 0, 1) }}{{ substr($data->surname, 0, 1) }}
                            </div>
                            <h4 class="mb-1">{{ $data->name }} {{ $data->surname }}</h4>
                            @if ($data->nickname)
                                <p class="mb-0 text-white opacity-75">"{{ $data->nickname }}"</p>
                            @endif
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="mt-3 text-center">
                            @if ($data->age)
                                <span class="badge bg-primary text-white">{{ $data->age }} let</span>
                            @endif
                            @if ($data->size)
                                <span class="badge bg-info text-white ms-2">Velikost trička: {{ $data->size }}</span>
                            @endif
                        </div>

                        <div class="list-group list-group-flush mt-4">
                            @if ($data->email)
                                <div class="list-group-item px-0 py-2 d-flex border-top-0">
                                    <div class="avatar avatar-sm bg-primary text-primary me-3">
                                        <i class="ri-mail-line"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Email</small>
                                        <span>{{ $data->email }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($data->telephone)
                                <div class="list-group-item px-0 py-2 d-flex">
                                    <div class="avatar avatar-sm bg-primary text-primary me-3">
                                        <i class="ri-phone-line"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Telefon</small>
                                        <span>{{ $data->telephone }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-dark">Kontaktní informace</h5>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            @if ($data->mother_name || $data->mother_surname || $data->mother_telephone || $data->mother_email)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 bg-light border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar avatar-sm bg-primary-subtle text-primary me-3">
                                                    <i class="ri-user-3-line"></i>
                                                </div>
                                                <h6 class="mb-0 text-dark">Kontakt na matku</h6>
                                            </div>

                                            <div class="list-group list-group-flush">
                                                @if ($data->mother_name || $data->mother_surname)
                                                    <div class="list-group-item px-0 py-2 border-0 bg-transparent">
                                                        <small class="text-muted d-block">Jméno</small>
                                                        <span>{{ $data->mother_name ?? '' }}
                                                            {{ $data->mother_surname ?? '' }}</span>
                                                    </div>
                                                @endif

                                                @if ($data->mother_telephone)
                                                    <div class="list-group-item px-0 py-2 border-0 bg-transparent">
                                                        <small class="text-muted d-block">Telefon</small>
                                                        <span>{{ $data->mother_telephone }}</span>
                                                    </div>
                                                @endif

                                                @if ($data->mother_email)
                                                    <div class="list-group-item px-0 py-2 border-0 bg-transparent">
                                                        <small class="text-muted d-block">Email</small>
                                                        <span>{{ $data->mother_email }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($data->father_name || $data->father_surname || $data->father_telephone || $data->father_email)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 bg-light border-0">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="avatar avatar-sm bg-primary-subtle text-primary me-3">
                                                    <i class="ri-user-3-line"></i>
                                                </div>
                                                <h6 class="mb-0 text-dark">Kontakt na otce</h6>
                                            </div>

                                            <div class="list-group list-group-flush">
                                                @if ($data->father_name || $data->father_surname)
                                                    <div class="list-group-item px-0 py-2 border-0 bg-transparent">
                                                        <small class="text-muted d-block">Jméno</small>
                                                        <span>{{ $data->father_name ?? '' }}
                                                            {{ $data->father_surname ?? '' }}</span>
                                                    </div>
                                                @endif

                                                @if ($data->father_telephone)
                                                    <div class="list-group-item px-0 py-2 border-0 bg-transparent">
                                                        <small class="text-muted d-block">Telefon</small>
                                                        <span>{{ $data->father_telephone }}</span>
                                                    </div>
                                                @endif

                                                @if ($data->father_email)
                                                    <div class="list-group-item px-0 py-2 border-0 bg-transparent">
                                                        <small class="text-muted d-block">Email</small>
                                                        <span>{{ $data->father_email }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (
                                !($data->father_name || $data->father_surname || $data->father_telephone || $data->father_email) &&
                                    !($data->mother_name || $data->mother_surname || $data->mother_telephone || $data->mother_email))
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="ri-contacts-book-line text-primary" style="font-size: 3rem;"></i>
                                        </div>
                                        <h6 class="text-muted">Žádné kontaktní informace</h6>
                                        <p class="small text-muted">Pro tohoto člena nebyly nalezeny žádné kontaktní
                                            informace rodičů.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="ri-award-line me-2 text-primary"></i>Odborky
                            @if ($achievements->count() > 0)
                                <span class="badge bg-primary text-white ms-2">{{ $achievements->count() }}</span>
                            @endif
                        </h5>
                    </div>

                    <div class="card-body">
                        @if ($achievements->count() > 0)
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                                @foreach ($achievements as $achievement)
                                    <div class="col">
                                        <div class="card h-100 border shadow-sm hover-shadow">
                                            @if (file_exists(public_path('storage/achievements/' . $achievement->image)))
                                                <img class="card-img-top" style="height: 180px; object-fit: cover;"
                                                    src="{{ asset('storage/achievements/' . $achievement->image) }}"
                                                    alt="{{ $achievement->name }}" />
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center"
                                                    style="height: 180px;">
                                                    <i class="ri-award-fill text-primary" style="font-size: 4rem;"></i>
                                                </div>
                                            @endif

                                            <div class="card-body">
                                                <h5 class="card-title text-dark">{{ $achievement->name }}</h5>
                                                <p class="card-text text-muted small">
                                                    {{ Str::limit($achievement->description, 60) }}
                                                </p>
                                            </div>

                                            @if ($achievement->achieved_at)
                                                <div class="card-footer bg-transparent border-top-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-calendar-check-line text-success me-2"></i>
                                                        <small class="text-muted">
                                                            Dosáhnuto:
                                                            {{ \Carbon\Carbon::parse($achievement->achieved_at)->format('d.m.Y') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <div class="rounded-circle bg-primary-subtle p-4 mx-auto" style="width: fit-content;">
                                        <i class="ri-award-line text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-2">Žádné odborky</h5>
                                <p class="text-muted">Pro tohoto člena nebyly nalezeny žádné odborky.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            font-weight: 500;
        }

        .avatar-xl {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            font-size: 0.875rem;
        }
    </style>
@endsection
