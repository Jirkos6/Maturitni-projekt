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
    @use('App\Models\Events')
    @use('\Carbon\Carbon')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex">
                <i class="ri-checkbox-circle-line me-2 fs-5 align-self-center"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex">
                <i class="ri-error-warning-line me-2 fs-5 align-self-center"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0"><i class="ri-dashboard-line me-2 text-primary"></i>Přehled družin</h4>
                    <p class="text-muted mb-0">Správa a přehled všech družin</p>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class="ri-add-line me-1"></i> Přidat družinu
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card  border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning p-3 bg-opacity-10 me-3">
                        <i class="ri-team-line text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Celkem družin</h6>
                        <h4 class="card-title mb-0">{{ Teams::count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-success bg-opacity-25 p-3 me-3">
                        <i class="ri-user-line text-success fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Celkem členů</h6>
                        <h4 class="card-title mb-0">{{ $data->sum(function ($team) {return $team->members->count();}) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-info bg-opacity-25 p-3 me-3">
                        <i class="ri-calendar-event-line text-info fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Nadcházející akce</h6>
                        <h4 class="card-title mb-0">
                            @php
                                $events = Events::All();
                            @endphp
                            {{ $events->filter(function ($event) {
                                    return Carbon::parse($event->start_date)->isFuture();
                                })->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-transparent py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="ri-team-line me-2 text-primary"></i>Seznam družin
                    <span class="badge bg-primary ms-2">{{ Teams::count() }}</span>
                </h5>
            </div>
        </div>

        <div class="card-body">
            @if (Teams::exists())
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-6 g-4">
                    @foreach ($data as $team)
                        <div class="col">
                            <div class="card h-100 border shadow-sm hover-shadow">
                                <div class="position-relative">
                                    <img class="card-img-top"
                                        style="height: 140px; object-fit: contain; padding: 1rem; background-color: #f8f9fa;"
                                        src="{{ asset('https://assets.grok.com/users/1d9ba289-0702-422d-9d57-92fd56372e21/pwomf3DuY0qK9ndW-generated_image.jpg') }}"
                                        alt="{{ $team->name }}" />
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-primary rounded-pill">
                                            <i class="ri-user-line me-1"></i>{{ $team->members->count() }}
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">{{ $team->name }}</h5>
                                </div>
                                <div class="card-footer bg-white border-0 pb-3 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="/teams/{{ $team->id }}" class="btn btn-sm btn-primary">
                                            <i class="ri-eye-line me-1"></i> Zobrazit
                                        </a>
                                        <form action="/team/{{ $team->id }}" method="POST"
                                            onsubmit="return confirm('Opravdu chcete smazat tuto družinu?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-6-line me-1"></i> Smazat
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="ri-team-line text-primary" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="text-primary mb-3">Ještě nebyly vytvořeny žádné družiny!</h3>
                    <p class="text-muted mb-4">Přidejte první družinu pomocí tlačítka níže.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
                        <i class="ri-add-line me-1"></i> Přidat družinu
                    </button>
                </div>
            @endif
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data" action="/teams">
        @csrf
        <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-white">
                        <h5 class="modal-title" id="exampleModalLabel1">
                            <i class="me-2"></i>Přidání družiny
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="name" class="form-label">Název družiny</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="ri-group-line"></i></span>
                                    <input type="text" id="name" name="name" required class="form-control"
                                        placeholder="Zadejte název družiny">
                                </div>
                                <div class="form-text">Zadejte jedinečný název pro novou družinu.</div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i> Zavřít
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i> Přidat družinu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
