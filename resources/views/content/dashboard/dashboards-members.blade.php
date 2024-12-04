@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Člen - ' . $data->name . ' ' . $data->surname)

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm rounded-3">
                    <img class="card-img-top rounded-top" src="https://www.w3schools.com/w3images/avatar2.png"
                        alt="Profile Image" />
                    <div class="card-body">
                        <h5 class="card-title text-center">{{ $data->name }} {{ $data->surname }}</h5>
                        <p class="text-center text-muted">Age: {{ $data->age }}</p>

                        <div class="mb-3">
                            <p><strong>Přezdívka:</strong> {{ $data->nickname ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $data->email ?? '' }}</p>
                            <p><strong>Telefon:</strong> {{ $data->telephone ?? '' }}</p>
                        </div>

                        <div class="mb-3">
                            <p><strong>Velikost trička:</strong> {{ $data->size ? '' . $data->size : '' }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-muted">Kontakt na matku</h5>
                            <p><strong>Jméno:</strong> {{ $data->mother_name ?? '' }} {{ $data->mother_surname ?? '' }}</p>
                            <p><strong>Telefon:</strong> {{ $data->mother_telephone ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $data->mother_email ?? '' }}</p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-muted">Kontakt na otce</h5>
                            <p><strong>Jméno:</strong> {{ $data->father_name ?? '' }} {{ $data->father_surname ?? '' }}
                            </p>
                            <p><strong>Telefon:</strong> {{ $data->father_telephone ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $data->father_email ?? '' }}</p>
                        </div>

                        <div class="d-flex justify-content-center mt-3">
                            <a href="#" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal"
                                data-bs-target="#editMemberModal">
                                <i class="ri-pencil-line"></i> Změnit
                            </a>
                            <form action="/member/{{ $data->members_id }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="ri-delete-bin-6-line"></i> Smazat
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($achievements->count() > 0)
            <div class="col-12 mt-5">
                <h3 class="text-center mb-4">Odborky ({{ $achievements->count() }})</h3>
                <div class="row">
                    @foreach ($achievements as $achievement)
                        <div class="col-md-3 col-sm-4 col-6 mb-4">
                            <div class="card shadow-sm rounded-3">
                                <img class="card-img-top rounded-3"
                                    src="{{ asset('storage/achievements/' . $achievement->image) }}"
                                    alt="Achievement Image" style="height: auto; object-fit: cover;" />
                                <div class="card-body p-3">
                                    <h5 class="card-title text-center" style="font-size: 1rem;">{{ $achievement->name }}
                                    </h5>
                                    <p class="text-muted" style="font-size: 0.875rem;">
                                        {{ Str::limit($achievement->description, 60) }}</p>

                                    @if ($achievement->achieved_at)
                                        <small class="text-muted d-block mt-2" style="font-size: 0.75rem;">
                                            Dosáhnuto:
                                            {{ \Carbon\Carbon::parse($achievement->achieved_at)->format('d.m.Y') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="col-12 mt-5">
                <p class="text-center">Pro tohoto člena nebyli nalezeny žádné odborky.</p>
            </div>
        @endif
    </div>

    <!-- Edit Member Modal -->
    <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMemberModalLabel">Upravit člena</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('member.update', $data->id) }}" method="POST" id="editMemberForm">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Jméno</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $data->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surname" class="form-label">Příjmení</label>
                                <input type="text" class="form-control" id="surname" name="surname"
                                    value="{{ old('surname', $data->surname) }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="age" class="form-label">Věk</label>
                                <input type="number" class="form-control" id="age" name="age"
                                    value="{{ old('age', $data->age) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="shirt_size_id" class="form-label">Velikost trika</label>
                                <select class="form-select" id="shirt_size_id" name="shirt_size_id">
                                    <option value="">Vyberte velikost</option>
                                    @foreach ($shirt_sizes as $size)
                                        <option value="{{ $size->id }}"
                                            {{ $size->id == old('shirt_size_id', $data->shirt_size_id) ? 'selected' : '' }}>
                                            {{ $size->size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nickname" class="form-label">Přezdívka</label>
                                <input type="text" class="form-control" id="nickname" name="nickname"
                                    value="{{ old('nickname', $data->nickname) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="telephone" name="telephone"
                                    value="{{ old('telephone', $data->telephone) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $data->email) }}">
                            </div>
                        </div>

                        <h6 class="mt-4">Kontakt na matku</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mother_name" class="form-label">Jméno matky</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name"
                                    value="{{ old('mother_name', $data->mother_name) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mother_surname" class="form-label">Příjmení matky</label>
                                <input type="text" class="form-control" id="mother_surname" name="mother_surname"
                                    value="{{ old('mother_surname', $data->mother_surname) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mother_telephone" class="form-label">Telefon matky</label>
                                <input type="text" class="form-control" id="mother_telephone" name="mother_telephone"
                                    value="{{ old('mother_telephone', $data->mother_telephone) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="mother_email" class="form-label">Email matky</label>
                                <input type="email" class="form-control" id="mother_email" name="mother_email"
                                    value="{{ old('mother_email', $data->mother_email) }}">
                            </div>
                        </div>

                        <h6 class="mt-4">Kontakt na otce</h6>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="father_name" class="form-label">Jméno otce</label>
                                <input type="text" class="form-control" id="father_name" name="father_name"
                                    value="{{ old('father_name', $data->father_name) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="father_surname" class="form-label">Příjmení otce</label>
                                <input type="text" class="form-control" id="father_surname" name="father_surname"
                                    value="{{ old('father_surname', $data->father_surname) }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="father_telephone" class="form-label">Telefon otce</label>
                                <input type="text" class="form-control" id="father_telephone" name="father_telephone"
                                    value="{{ old('father_telephone', $data->father_telephone) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="father_email" class="form-label">Email otce</label>
                                <input type="email" class="form-control" id="father_email" name="father_email"
                                    value="{{ old('father_email', $data->father_email) }}">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" class="btn btn-primary">Upravit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
