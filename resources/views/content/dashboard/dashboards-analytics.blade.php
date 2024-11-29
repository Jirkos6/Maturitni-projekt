@extends('layouts/contentNavbarLayout')

@section('title', 'Hlavní panel')

@section('vendor-style')
    @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
    @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
    @vite('resources/assets/js/dashboards-analytics.js')
    @vite(['resources/assets/js/ui-modals.js'])
@endsection

@section('content')
    @use('App\Models\Teams')
    @if (session('success'))
        <br>
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <br>
        <br>
    @endif

    @if (session('error'))
        <br>
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        <br>
        <br>
    @endif

    <div class="card mb-6">
        <h5 class="card-header">Oddíly <span
                class="badge badge-center rounded-pill bg-label-primary">{{ Teams::count() }}</span> </h5>
        <div class="card-body">
            <div class="row gy-3">

                <div class="col-lg-4 col-md-6">
                    <div class="mt-4">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                            Přidat&nbsp;<i class="ri-add-circle-fill"></i>
                        </button>
                        <form method="POST" enctype="multipart/form-data" action="/teams">
                            @csrf
                            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel1">Přidaní oddílu</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col mb-6 mt-2">
                                                    <div class="form-floating form-floating-outline">
                                                        <input type="text" id="name" name="name" required
                                                            class="form-control" placeholder="Zadejte název">
                                                        <label for="name">Název</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Zavřít</button>
                                            <button type="submit" class="btn btn-primary">Přidat</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if (Teams::exists())

                    <div class="row mb-12 g-6">
                        @foreach ($data as $team)
                            <div class="col-md-6 col-xl-2 rounded-2xl">
                                <a href="/teams/{{ $team->id }}" rel="noreferrer">
                                    <div class="card">
                                        <img class="card-img-top rounded-md"
                                            src="{{ asset('https://skaut-kostelec.cz/wp-content/uploads/2020/07/logo-skaut-small.png') }}"
                                            alt="Card image cap" />
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $team->name }}</h5>
                                            <span class="badge rounded-pill bg-label-primary">
                                                <p class="card-text">
                                                    <small class="text-muted"><i class="ri-user-fill"></i></i>
                                                        {{ $team->members->count() }}</small>
                                            </span>
                                            </p>

                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <h5 class="pb-1 mb-6">Ještě si nevytvořil žádné oddíly!</h5>

                @endif


            @endsection
