@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')
@section('title', 'Uživatel - ' . $user->parent_name . ' ' . $user->parent_surname)


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
                        <h5 class="card-title text-center">{{ $user->parent_name }} {{ $user->parent_surname }}</h5>
                        <div class="mb-3">
                            <p><strong>Email:</strong> {{ $user->email ?? '' }}</p>
                            <p><strong>Děti:</strong> {{ $user->member_names ?? 'Žadné' }}</p>
                            <p><strong>Role:</strong>
                                {{ $user->role === 'parent' ? 'Rodič' : ($user->role === 'admin' ? 'Administrátor' : 'Neznámá role') }}
                            </p>
                        </div>
                        <button class="btn btn-primary" onClick="history.back()"><i class="ri-arrow-go-back-fill"></i>
                            Zpátky</button>
                    </div>
                </div>
            </div>
        </div>



    @endsection
