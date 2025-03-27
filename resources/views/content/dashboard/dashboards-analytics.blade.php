@extends('layouts/contentNavbarLayout')

@section('title', 'Hlavní panel')


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

    @php
        $teams = Teams::withCount('members')->get();
        $totalTeams = $teams->count();
        $totalMembers = $teams->sum('members_count');
        $upcomingEventsCount = Events::where('start_date', '>', Carbon::now())->count();
    @endphp

    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="mb-0"><i class="ri-dashboard-line me-2 text-primary"></i>Přehled družin</h4>
                <p class="text-muted mb-0">Správa a přehled všech družin</p>
            </div>
            <button type="button" class="btn btn-primary mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#basicModal">
                <i class="ri-add-line me-1"></i> Přidat družinu
            </button>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="rounded-circle bg-warning p-3 bg-opacity-10 me-3">
                        <i class="ri-team-line text-warning fs-4"></i>
                    </div>
                    <div>
                        <h6 class="card-subtitle mb-1 text-muted">Celkem družin</h6>
                        <h4 class="card-title mb-0">{{ $totalTeams }}</h4>
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
                        <h4 class="card-title mb-0">{{ $totalMembers }}</h4>
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
                        <h4 class="card-title mb-0">{{ $upcomingEventsCount }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="ri-team-line me-2 text-primary"></i>Seznam družin
                <span class="badge bg-primary ms-2">{{ $totalTeams }}</span>
            </h5>
        </div>

        <div class="card-body">
            @if ($totalTeams > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    @foreach ($teams as $team)
                        <div class="col">
                            <div class="card h-100 border shadow-sm hover-shadow">
                                <img class="card-img-top p-3 bg-light" style="height: 140px; object-fit: contain;"
                                    src="{{ asset('storage/skaut.jpg') }}" alt="{{ $team->name }}" />
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-3">{{ $team->name }}</h5>
                                    <span class="badge bg-primary rounded-pill">
                                        <i class="ri-user-line me-1"></i>{{ $team->members_count }}
                                    </span>
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
