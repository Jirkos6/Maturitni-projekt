@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
    use Carbon\Carbon;
    use App\Models\Teams;

    Carbon::setLocale('cs');
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Akce - ' . $data->title)

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
        <div class="row">
            <div class="col-12 mb-4">
                <button class="btn btn-outline-primary" onclick="history.back()">
                    <i class="ri-arrow-left-line me-1"></i> Zpět na přehled
                </button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-primary text-white p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold text-white">{{ $data->title }}</h4>

                            @php
                                $now = Carbon::now();
                                $start = Carbon::parse($data->start_date);
                                $end = Carbon::parse($data->end_date);

                                if ($now->lt($start)) {
                                    $statusClass = 'bg-info';
                                    $statusText = 'Nadcházející';
                                } elseif ($now->gt($end)) {
                                    $statusClass = 'bg-secondary';
                                    $statusText = 'Ukončeno';
                                } else {
                                    $statusClass = 'bg-success';
                                    $statusText = 'Probíhá';
                                }
                            @endphp

                            <span class="badge {{ $statusClass }} text-white">{{ $statusText }}</span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-primary-subtle p-5 d-flex align-items-center justify-content-center mx-auto"
                                style="width: 150px; height: 150px;">
                                <i class="ri-calendar-event-fill text-primary" style="font-size: 4rem;"></i>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                        <i class="ri-calendar-check-line text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Začátek</small>
                                        <strong>{{ Carbon::parse($data->start_date)->format('d.m.Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                        <i class="ri-calendar-check-line text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Konec</small>
                                        <strong>{{ Carbon::parse($data->end_date)->format('d.m.Y') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                        <i class="ri-time-line text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Čas začátku</small>
                                        <strong>{{ Carbon::parse($data->start_date)->format('H:i') }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                        <i class="ri-time-line text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Čas konce</small>
                                        <strong>{{ Carbon::parse($data->end_date)->format('H:i') }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if (isset($data->teams) && count($data->teams) > 0)
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                        <i class="ri-team-line text-primary"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block">Týmy</small>
                                        <div class="mt-1">
                                            @foreach ($data->teams as $team)
                                                <a href="/teams/{{ $team->id }}"
                                                    class="badge bg-primary text-white me-1 text-decoration-none">
                                                    {{ $team->name }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (isset($data->description) && !empty($data->description))
                            <div class="mb-4 p-3 bg-light rounded">
                                <h6 class="mb-3 fw-bold text-dark"><i class="ri-file-text-line me-2 text-primary"></i>Popis
                                </h6>
                                <p class="mb-0 text-muted">{{ $data->description }}</p>
                            </div>
                        @endif

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    @if ($now->lt($start))
                                        <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                            <i class="ri-time-line text-info"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Začátek</small>
                                            <strong>{{ $start->diffForHumans($now, ['parts' => 2]) }}</strong>
                                        </div>
                                    @elseif ($now->gt($end))
                                        <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                            <i class="ri-check-double-line text-secondary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Ukončeno</small>
                                            <strong>{{ $end->diffForHumans($now, ['parts' => 2]) }}</strong>
                                        </div>
                                    @else
                                        <div class="rounded-circle bg-primary-subtle p-2 me-3">
                                            <i class="ri-play-circle-line text-success"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Právě probíhá</small>
                                            <strong>Do konce zbývá {{ $end->diff($now)->format('%d dní, %h hodin, %i minut') }}</strong>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (isset($data->attendances) && $data->attendances->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-dark"><i class="ri-user-follow-line me-2 text-primary"></i>Docházka</h5>
                            <span class="badge bg-primary text-white">{{ $data->attendances->count() }} účastníků</span>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Jméno</th>
                                            <th>Status</th>
                                            <th>Potvrzeno</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->attendances as $attendance)
                                            <tr>
                                                <td>
                                                    <a href="/members/{{ $attendance->member->id }}"
                                                        class="text-decoration-none text-dark fw-medium">
                                                        {{ $attendance->member->name }} {{ $attendance->member->surname }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($attendance->status == 'present')
                                                        <span class="badge bg-success">Přítomen</span>
                                                    @elseif ($attendance->status == 'excused')
                                                        <span class="badge bg-warning text-dark">Omluven</span>
                                                    @elseif ($attendance->status == 'unexcused')
                                                        <span class="badge bg-danger">Neomluven</span>
                                                    @else
                                                        <span class="badge bg-secondary">Neurčeno</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($attendance->confirmed_by_parent)
                                                        <span class="badge bg-success">Ano</span>
                                                    @else
                                                        <span class="badge bg-danger">Ne</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
