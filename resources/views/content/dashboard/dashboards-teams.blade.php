@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
    $team = $data->first();
    $teamId = $team->id;
    $sectionName = $team->name;
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', 'Družina ' . $sectionName)
@section('content')
    @use('App\Models\Teams')
    @use('App\Models\User')
    @use('App\Models\Achievements')
    @use('App\Models\Members')
    @use('\Carbon\Carbon')
    @php
        Carbon::setLocale('cs');
    @endphp
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <meta name="_token" content="{{ csrf_token() }}">
    <style>
        #calendar {
            min-height: 600px;
            height: 100%;
        }

        .fc .fc-view-harness {
            min-height: 500px;
        }
    </style>
    <script>
        let calendar;

        document.addEventListener("DOMContentLoaded", function() {
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) return;

            var l13 = {
                code: 'cs',
                week: {
                    dow: 1,
                    doy: 4
                },
                buttonText: {
                    prev: 'Dříve',
                    next: 'Později',
                    today: 'Nyní',
                    year: 'Rok',
                    month: 'Měsíc',
                    week: 'Týden',
                    day: 'Den',
                    multiMonthYear: 'Rok',
                    list: 'List'
                },
                weekText: 'Týd',
                allDayText: 'Celý den',
                moreLinkText: n => '+další: ' + n,
                noEventsText: 'Žádné akce k zobrazení',
            };

            calendar = new window.Calendar(calendarEl, {
                plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window
                    .listPlugin, window.multiMonthPlugin
                ],
                selectable: 'true',
                initialView: 'dayGridMonth',
                locale: l13,
                events: {!! $events !!},
                timeZone: '',
                height: 850,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,multiMonthYear,listYear'
                },
                views: {
                    dayGridMonth: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long'
                        }
                    },
                    timeGridWeek: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        }
                    },
                    timeGridDay: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        }
                    },
                    listWeek: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        }
                    },
                    listYear: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        }
                    },
                    multiMonthYear: {
                        type: 'multiMonth',
                        duration: {
                            months: 12
                        }
                    }
                },
                eventClick: function(info) {
                    window.location.href = "/events/" + info.event.id;
                },
                eventMouseEnter: function(info) {
                    info.el.style.cursor = 'pointer';
                    info.el.style.backgroundColor = '#28a745';
                    info.el.style.borderColor = '#218838';
                    info.el.style.transform = 'scale(1.01)';
                    info.el.style.boxShadow = '0 0 15px rgba(40, 167, 69, 0.5)';
                    info.el.style.transition = 'all 0.2s ease-in-out';
                },
                eventMouseLeave: function(info) {
                    info.el.style.cursor = 'default';
                    info.el.style.backgroundColor = '';
                    info.el.style.borderColor = '';
                    info.el.style.color = '';
                    info.el.style.transform = '';
                    info.el.style.boxShadow = '';
                    info.el.style.transition = '';
                }
            });

            calendar.render();
        });
        document.addEventListener('DOMContentLoaded', function() {
            const calendarButton = document.getElementById('calendarButton');

            if (calendarButton) {
                calendarButton.addEventListener('shown.bs.tab', function() {
                    if (calendar) {
                        setTimeout(function() {
                            calendar.updateSize();
                        }, 10);
                    }
                });
            }
        });

    </script>
    <div class="row gy-6 h-100">
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
        <h3 class="mb-0 d-flex flex-wrap align-items-center gap-2">
            Družina
            <span class="badge rounded-pill bg-label-primary fs-6">{{ $team->name }}</span>
        </h3>
        <div class="nav-align-top mb-6 mt-6 h-100 d-flex flex-column">
            <ul class="nav nav-pills mb-4 flex-column flex-md-row gap-2" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true"
                        id="calendarButton">
                        Kalendář
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-events" aria-controls="navs-pills-events" aria-selected="false">
                        Akce
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                        aria-selected="false">
                        Přehled
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                        aria-selected="false">
                        Členové
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-parents" aria-controls="navs-pills-top-parents"
                        aria-selected="false">
                        Uživatelé
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#navs-pills-top-presence" aria-controls="navs-pills-top-presence"
                        aria-selected="false">
                        Docházka
                    </button>
                </li>
            </ul>

            <div class="tab-content h-100">
                <div class="tab-pane fade show active h-100" id="navs-pills-top-home" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0"><i class="ri-calendar-line me-2 text-primary"></i>Kalendář</h4>
                                    <p class="text-muted mb-0">Přehled všech akcí</p>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#eventModal">
                                        <i class="ri-add-line me-1"></i> Přidat akci
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-0 p-md-3">
                            <div id="calendar" class="fc-theme-standard"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade h-100" id="navs-pills-events" role="tabpanel">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0"><i class="ri-calendar-event-line me-2 text-primary"></i>Akce
                                    </h4>
                                    <p class="text-muted mb-0">Správa akcí družiny</p>
                                </div>
                                <div class="col-md-6 d-flex justify-content-md-end gap-2 overflow-auto">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#eventModal">
                                        <i class="ri-add-line me-1"></i> Přidat akci
                                    </button>
                                    @if ($eventsCollection->count() !== 0)
                                        <button type="button" class="btn btn-outline-primary" id="bulkEditButton"
                                            data-bs-toggle="modal" data-bs-target="#multiEventEditModal">
                                            <i class="ri-edit-2-line me-1"></i> Hromadná úprava
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" id="bulkDeleteButton"
                                            data-bs-toggle="modal" data-bs-target="#multiEventDeleteModal">
                                            <i class="ri-delete-bin-line me-1"></i> Hromadné mazání
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($eventsCollection->count() !== 0)
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card border-0 shadow-sm h-100 bg-gradient-light">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle bg-warning p-3 bg-opacity-10  me-3">
                                            <i class="ri-calendar-event-line text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted">Počet akcí</h6>
                                            <h4 class="card-title mb-0">{{ $eventsCollection->count() }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card border-0 shadow-sm h-100 bg-gradient-light">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                            <i class="ri-calendar-check-line text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted">Nadcházející akce</h6>
                                            <h4 class="card-title mb-0">
                                                {{ $eventsCollection->filter(function ($event) {
                                                        return Carbon::parse($event->start_date)->isFuture();
                                                    })->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card border-0 shadow-sm h-100 bg-gradient-light">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                            <i class="ri-time-line text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted">Tento měsíc</h6>
                                            <h4 class="card-title mb-0">
                                                {{ $eventsCollection->filter(function ($event) {
                                                        return Carbon::parse($event->start_date)->month === Carbon::now()->month;
                                                    })->count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="ri-search-line"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="event-search"
                                                placeholder="Hledat akce...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="btn-group w-100">
                                            <button type="button" class="btn btn-outline-primary" id="view-toggle-btn"
                                                onclick="toggleEventsView()">
                                                <i class="ri-layout-grid-line me-1"></i> Přepnout zobrazení
                                            </button>
                                            <button class="btn btn-outline-primary dropdown-toggle" type="button"
                                                id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-filter-line me-1"></i> Filtrovat
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterEvents('all')">Všechny akce</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterEvents('upcoming')">Nadcházející</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterEvents('past')">Proběhlé</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterEvents('thisMonth')">Tento měsíc</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterEvents('nextMonth')">Příští měsíc</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0" id="events-table-view">
                            <div class="card-header bg-transparent py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Seznam akcí</h5>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Název</th>
                                            <th>Začátek</th>
                                            <th>Konec</th>
                                            <th>Konání</th>
                                            <th>Popis</th>
                                            <th class="text-end pe-4">Akce</th>
                                        </tr>
                                    </thead>
                                    <tbody class="event-list">
                                        @foreach ($eventsCollection as $event)
                                            @php
                                                $startDate = Carbon::parse($event->start_date);
                                                $endDate = Carbon::parse($event->end_date);
                                                $isUpcoming = $startDate->isFuture();
                                                $isPast = $startDate->isPast();
                                                $statusClass = $isUpcoming
                                                    ? 'bg-success-subtle'
                                                    : ($isPast
                                                        ? 'bg-white'
                                                        : 'bg-warning-subtle');
                                            @endphp
                                            <tr class="event-item {{ $statusClass }}" data-title="{{ $event->title }}"
                                                data-start="{{ $event->start_date }}" data-end="{{ $event->end_date }}"
                                                data-id="{{ $event->id }}">
                                                <td class="ps-4">
                                                    <a href="/events/{{ $event->id }}"
                                                        class="text-body fw-semibold text-decoration-none">
                                                        {{ $event->title }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-calendar-check-line text-success me-2"></i>
                                                        <span>{{ $startDate->format('d.m.Y H:i') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="ri-calendar-close-line text-danger me-2"></i>
                                                        <span>{{ $endDate->format('d.m.Y H:i') }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if ($isUpcoming)
                                                        <span class="badge bg-success">
                                                            <i class="ri-time-line me-1"></i>
                                                            {{ $startDate->diffForHumans() }}
                                                        </span>
                                                    @elseif($isPast)
                                                        <span class="badge bg-secondary">
                                                            <i class="ri-time-line me-1"></i>
                                                            {{ $startDate->diffForHumans() }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="ri-alarm-line me-1"></i>
                                                            Právě probíhá
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                                        title="{{ $event->description ?? 'Bez popisu' }}">
                                                        {{ $event->description ?? 'Bez popisu' }}
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-outline-secondary rounded-pill dropdown-toggle hide-arrow"
                                                            data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="/events/{{ $event->id }}">
                                                                <i class="ri-information-line me-2"></i> Zobrazit
                                                            </a>
                                                            <button class="dropdown-item" data-bs-toggle="modal"
                                                                data-bs-target="#editEventModal"
                                                                onclick="populateEditEventModal({{ json_encode($event) }})">
                                                                <i class="ri-pencil-line me-2"></i> Upravit
                                                            </button>
                                                            <div class="dropdown-divider"></div>
                                                            <form action="/event/{{ $event->id }}" method="POST"
                                                                onsubmit="return confirm('Opravdu chcete smazat tuto událost?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="ri-delete-bin-6-line me-2"></i> Smazat
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="events-card-view" class="d-none">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 event-cards">
                                @foreach ($eventsCollection as $event)
                                    @php
                                        $startDate = Carbon::parse($event->start_date);
                                        $endDate = Carbon::parse($event->end_date);
                                        $isUpcoming = $startDate->isFuture();
                                        $isPast = $startDate->isPast();
                                    @endphp
                                    <div class="col event-item" data-title="{{ $event->title }}"
                                        data-start="{{ $event->start_date }}" data-end="{{ $event->end_date }}"
                                        data-id="{{ $event->id }}">
                                        <div class="card h-100 border-0 shadow-sm hover-shadow">
                                            <div class="card-header bg-white text-white">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-0">{{ $event->title }}</h5>
                                                    <div class="dropdown">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-light rounded-circle"
                                                            data-bs-toggle="dropdown">
                                                            <i class="ri-more-2-fill"></i>
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="/events/{{ $event->id }}">
                                                                <i class="ri-information-line me-2"></i> Zobrazit
                                                            </a>
                                                            <a class="dropdown-item" href="#"
                                                                onclick="editEvent({{ $event->id }})">
                                                                <i class="ri-pencil-line me-2"></i> Upravit
                                                            </a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item text-danger" href="#"
                                                                onclick="confirmDelete({{ $event->id }})">
                                                                <i class="ri-delete-bin-6-line me-2"></i> Smazat
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar avatar-xs me-2 bg-success bg-opacity-25">
                                                            <i class="ri-calendar-check-line text-success"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Začátek:</small>
                                                            <span
                                                                class="ms-1">{{ $startDate->format('d.m.Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center mb-2">
                                                        <div class="avatar avatar-xs me-2 bg-danger bg-opacity-25">
                                                            <i class="ri-calendar-close-line text-danger"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Konec:</small>
                                                            <span
                                                                class="ms-1">{{ $endDate->format('d.m.Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-xs me-2 bg-info bg-opacity-25">
                                                            <i class="ri-time-line text-info"></i>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">Zbývá:</small>
                                                            <span class="ms-1">{{ $startDate->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if ($event->description)
                                                    <div class="mb-3">
                                                        <h6 class="text-muted mb-1">Popis:</h6>
                                                        <p class="card-text">{{ Str::limit($event->description, 100) }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <p class="text-muted fst-italic">Bez popisu</p>
                                                    </div>
                                                @endif

                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    @if ($isUpcoming)
                                                        <span class="badge bg-success">
                                                            <i class="ri-time-line me-1"></i>
                                                            {{ $startDate->diffForHumans() }}
                                                        </span>
                                                    @elseif($isPast)
                                                        <span class="badge bg-secondary">
                                                            <i class="ri-time-line me-1"></i>
                                                            {{ $startDate->diffForHumans() }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning">
                                                            <i class="ri-alarm-line me-1"></i>
                                                            Právě probíhá
                                                        </span>
                                                    @endif
                                                    <a href="/events/{{ $event->id }}" class="btn btn-sm btn-primary">
                                                        <i class="ri-eye-line me-1"></i> Zobrazit
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="ri-calendar-event-line text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-primary mb-3">Družina nemá žádné akce!</h3>
                            <p class="text-muted mb-4">Zatím nejsou naplánovány žádné akce. Přidejte
                                novou akci pomocí
                                tlačítka níže.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#eventModal">
                                <i class="ri-add-line me-1"></i> Přidat akci
                            </button>
                        </div>
                    @endif
                </div>





                <div class="tab-pane fade h-100" id="navs-pills-top-profile" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="mb-0"><i class="ri-dashboard-line me-2 text-primary"></i>Přehled</h4>
                                    <p class="text-muted mb-0">Rychlý přehled</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (null !== $nextEvent)
                        <div class="row">
                            <div class="col-lg-8 mx-auto">
                                <div class="card shadow-sm border-0 overflow-hidden mb-4">
                                    <div class="card-header text-white">
                                        <h5 class="mb-0 text-primary"><i class="ri-calendar-event-fill me-2"></i>Nejbližší
                                            akce
                                        </h5>
                                    </div>
                                    <div class="row g-0">
                                        <div class="col-md-5">
                                            <img class="img-fluid h-100 object-fit-cover"
                                                src="{{ asset('storage/skaut.jpg') }}" alt="Event Image">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="card-body">
                                                <h4 class="card-title mb-3">
                                                    <a href="/events/{{ $nextEvent->id }}"
                                                        class="text-decoration-none text-primary stretched-link">
                                                        {{ $nextEvent->title }}
                                                    </a>
                                                </h4>
                                                <div class="mb-3">
                                                    <p class="card-text">{{ $nextEvent->description }}</p>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <div>
                                                                <small class="text-muted d-block">Datum</small>
                                                                <strong>{{ Carbon::parse($nextEvent->start)->format('d.m.Y') }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center mb-2">

                                                            <div>
                                                                <small class="text-muted d-block">Čas</small>
                                                                <strong>{{ Carbon::parse($nextEvent->start)->format('H:i') }}
                                                                    -
                                                                    {{ Carbon::parse($nextEvent->end)->format('H:i') }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="small text-muted">
                                                        <i class="ri-time-line me-1"></i>

                                                        {{ Carbon::parse($nextEvent->start)->diffForHumans() }}

                                                    </div>
                                                    <a href="/events/{{ $nextEvent->id }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="ri-eye-line me-1"></i>Zobrazit akci
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
                            <div class="col">
                                <div class="card h-100 border-0">
                                    <div class="card-body text-center">
                                        <div class="rounded-circle bg-info p-3 bg-opacity-10 mx-auto"
                                            style="width: fit-content;">
                                            <i class="ri-calendar-line text-info fs-3"></i>
                                        </div>
                                        <h5 class="card-title">Nadcházející akce</h5>
                                        <p class="card-text fs-4 fw-bold text-info">
                                            {{ $eventsCollection->filter(function ($event) {
                                                    return Carbon::parse($event->start_date)->isFuture();
                                                })->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0">
                                    <div class="card-body text-center">
                                        <div class="rounded-circle bg-success bg-opacity-10 p-3 mx-auto mb-3"
                                            style="width: fit-content;">
                                            <i class="ri-user-line text-success fs-3"></i>
                                        </div>
                                        <h5 class="card-title">Celkový počet členů</h5>
                                        <p class="card-text fs-4 fw-bold text-success">
                                            {{ isset($memberCount) ? $memberCount : '0' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0">
                                    <div class="card-body text-center">
                                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 mx-auto mb-3"
                                            style="width: fit-content;">
                                            <i class="ri-award-line text-warning fs-3"></i>
                                        </div>
                                        <h5 class="card-title">Odborky</h5>
                                        <p class="card-text fs-4 fw-bold text-warning">
                                            {{ isset($achievementsCount) ? $achievementsCount : Achievements::count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="ri-calendar-event-line text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-primary mb-3">Není žádná nadcházející akce!</h3>
                            <p class="text-muted mb-4">Zatím nejsou naplánovány žádné akce, které jsou v budoucnu. Přidejte
                                novou akci pomocí
                                tlačítka níže.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#eventModal">
                                <i class="ri-add-line me-1"></i> Přidat akci
                            </button>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade h-100" id="navs-pills-top-messages" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0"><i class="ri-team-line me-2 text-primary"></i>Členové</h4>
                                    <p class="text-muted mb-0">Správa členů a jejich docházky</p>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editMemberModal">
                                            <i class="ri-user-add-line me-1"></i> Přidat člena
                                        </button>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addMembersModal">
                                            <i class="ri-group-line me-1"></i> Přidat více členů
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (0 !== $memberCount)
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle bg-warning p-3 bg-opacity-10  me-3">
                                            <i class="ri-user-line text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted">Celkem členů</h6>
                                            <h4 class="card-title mb-0">{{ $memberCount }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="ri-search-line"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="member-search"
                                                placeholder="Hledat členy...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Seznam členů</h5>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" id="view-toggle-btn"
                                            onclick="toggleMembersView()">
                                            <i class="ri-layout-grid-line me-1"></i> Přepnout zobrazení
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="members-table-view">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Jméno</th>

                                                <th>Docházka</th>
                                                <th class="text-end pe-4">Akce</th>
                                            </tr>
                                        </thead>
                                        <tbody class="member-list">
                                            @foreach ($members as $item)
                                                <tr class="member-item"
                                                    data-name="{{ $item->name }} {{ $item->surname }}">
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm me-3">
                                                                <div
                                                                    class="avatar-initial rounded-circle bg-label-primary">
                                                                    {{ substr($item->name, 0, 1) }}{{ substr($item->surname, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a href="/members/{{ $item->id }}"
                                                                    class="text-body fw-semibold text-decoration-none">
                                                                    {{ $item->name }} {{ $item->surname }}
                                                                </a>
                                                                @if ($item->nickname)
                                                                    <small
                                                                        class="text-muted d-block">"{{ $item->nickname }}"</small>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $item->attendance_percentage >= 75 ? 'success' : ($item->attendance_percentage >= 50 ? 'warning' : 'danger') }}"
                                                                    role="progressbar"
                                                                    style="width: {{ $item->attendance_percentage }}%"
                                                                    aria-valuenow="{{ $item->attendance_percentage }}"
                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                            <span
                                                                class="fw-semibold">{{ $item->attendance_percentage }}%</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-outline-secondary rounded-pill dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="ri-more-2-fill"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item"
                                                                    href="/members/{{ $item->id }}">
                                                                    <i class="ri-information-line me-2"></i> Zobrazit
                                                                </a>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#assignAchievementModal"
                                                                    data-member-id="{{ $item->id }}">
                                                                    <i class="ri-award-line me-2"></i> Přidělit odborky
                                                                </a>
                                                                <div class="dropdown-divider"></div>
                                                                <form action="/member/{{ $item->id }}" method="POST"
                                                                    onsubmit="return confirm('Opravdu chcete smazat tohoto člena?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i class="ri-delete-bin-6-line me-2"></i>
                                                                        Smazat
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="members-card-view" class="d-none">
                                <div class="card-body">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 member-cards">
                                        @foreach ($members as $item)
                                            <div class="col member-item"
                                                data-name="{{ $item->name }} {{ $item->surname }}">
                                                <div class="card h-100 border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-md me-3">
                                                                <div
                                                                    class="avatar-initial rounded-circle bg-label-primary">
                                                                    {{ substr($item->name, 0, 1) }}{{ substr($item->surname, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h5 class="card-title mb-0">{{ $item->name }}
                                                                    {{ $item->surname }}</h5>
                                                                @if ($item->nickname)
                                                                    <small
                                                                        class="text-muted">"{{ $item->nickname }}"</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label d-flex justify-content-between">
                                                                <span>Docházka</span>
                                                                <span
                                                                    class="fw-semibold">{{ $item->attendance_percentage }}%</span>
                                                            </label>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-{{ $item->attendance_percentage >= 75 ? 'success' : ($item->attendance_percentage >= 50 ? 'warning' : 'danger') }}"
                                                                    role="progressbar"
                                                                    style="width: {{ $item->attendance_percentage }}%"
                                                                    aria-valuenow="{{ $item->attendance_percentage }}"
                                                                    aria-valuemin="0" aria-valuemax="100">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="/members/{{ $item->id }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="ri-eye-line me-1"></i> Zobrazit
                                                            </a>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-settings-3-line me-1"></i> Akce
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#assignAchievementModal"
                                                                        data-member-id="{{ $item->id }}">
                                                                        <i class="ri-award-line me-2"></i> Přidělit
                                                                        odborky
                                                                    </a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="/member/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete smazat tohoto člena?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger">
                                                                            <i class="ri-delete-bin-6-line me-2"></i>
                                                                            Smazat
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="ri-user-add-line text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-primary mb-3">Tato družina nemá žádné členy!</h3>
                            <p class="text-muted mb-4">Přidejte členy pomocí tlačítka níže.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editMemberModal">
                                <i class="ri-user-add-line me-1"></i> Přidat člena
                            </button>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade h-100" id="navs-pills-top-parents" role="tabpanel">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0"><i class="ri-parent-line me-2 text-primary"></i>Uživatelé</h4>
                                    <p class="text-muted mb-0">Správa rodičů a jejich přiřazení k dětem</p>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editParentModal">
                                        <i class="ri-user-add-line me-1"></i> Přidat rodiče
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (0 !== User::count())
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="rounded-circle bg-warning p-3 bg-opacity-10 me-3">
                                            <i class="ri-parent-line text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <h6 class="card-subtitle mb-1 text-muted">Celkem uživatelů</h6>
                                            <h4 class="card-title mb-0">{{ User::count() }}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-0">
                                    <div class="card-body">
                                        <div class="input-group">
                                            <span class="input-group-text bg-transparent border-end-0">
                                                <i class="ri-search-line"></i>
                                            </span>
                                            <input type="text" class="form-control border-start-0" id="user-search"
                                                placeholder="Hledat uživatele...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-transparent py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Seznam uživatelů</h5>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-primary" id="users-view-toggle-btn"
                                            onclick="toggleUsersView()">
                                            <i class="ri-layout-grid-line me-1"></i> Přepnout zobrazení
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div id="users-table-view">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Jméno</th>
                                                <th>Role</th>
                                                <th>Děti</th>
                                                <th>Email</th>
                                                <th class="text-end pe-4">Akce</th>
                                            </tr>
                                        </thead>
                                        <tbody class="user-list">
                                            @foreach ($parents as $item)
                                                <tr class="user-item"
                                                    data-name="{{ $item->parent_name }} {{ $item->parent_surname }}">
                                                    <td class="ps-4">
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar avatar-sm me-3">
                                                                <div
                                                                    class="avatar-initial rounded-circle {{ Auth::user()->email != null && Auth::user()->email == $item->email ? 'bg-success' : 'bg-label-primary' }}">
                                                                    {{ substr($item->parent_name, 0, 1) }}{{ substr($item->parent_surname, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <a href="/user/{{ $item->id }}"
                                                                    class="text-body fw-semibold text-decoration-none">
                                                                    {{ $item->parent_name }}
                                                                    {{ $item->parent_surname }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-label-{{ $item->role == 'admin' ? 'danger' : 'info' }}">
                                                            {{ $item->role == 'parent' ? 'Rodič' : 'Administrátor' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if (null !== $item->member_names)
                                                            <span class="text-truncate d-inline-block"
                                                                style="max-width: 150px;"
                                                                title="{{ $item->member_names }}">
                                                                {{ $item->member_names }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">Žádné</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span class="text-truncate d-inline-block"
                                                            style="max-width: 150px;" title="{{ $item->email }}">
                                                            {{ $item->email }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-outline-secondary rounded-pill dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="ri-more-2-fill"></i>
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item"
                                                                    href="/user/{{ $item->id }}">
                                                                    <i class="ri-information-line me-2"></i> Zobrazit
                                                                </a>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#assignMemberModal"
                                                                    data-user-id="{{ $item->id }}">
                                                                    <i class="ri-user-add-line me-2"></i> Přidělit děti
                                                                </a>
                                                                <form action="/users-role/{{ $item->id }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Opravdu chcete změnit roli?');">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <button type="submit" class="dropdown-item">
                                                                        <i class="ri-user-settings-line me-2"></i>
                                                                        @if (null != $item->role && $item->role == 'parent')
                                                                            Nastavit roli Administrátor
                                                                        @elseif (null != $item->role && $item->role == 'admin')
                                                                            Nastavit roli rodič
                                                                        @endif
                                                                    </button>
                                                                </form>
                                                                <div class="dropdown-divider"></div>
                                                                <form action="/user/{{ $item->id }}" method="POST"
                                                                    onsubmit="return confirm('Opravdu chcete smazat tohoto uživatele?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="dropdown-item text-danger">
                                                                        <i class="ri-delete-bin-6-line me-2"></i>
                                                                        Smazat
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div id="users-card-view" class="d-none">
                                <div class="card-body">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 user-cards">
                                        @foreach ($parents as $item)
                                            <div class="col user-item"
                                                data-name="{{ $item->parent_name }} {{ $item->parent_surname }}">
                                                <div class="card h-100 border shadow-sm">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div class="avatar avatar-md me-3 img-fluid">
                                                                <div
                                                                    class="avatar-initial rounded-circle {{ Auth::user()->email != null && Auth::user()->email == $item->email ? 'bg-success' : 'bg-label-primary' }}">
                                                                    {{ substr($item->parent_name, 0, 1) }}{{ substr($item->parent_surname, 0, 1) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h5 class="card-title mb-0">
                                                                    {{ $item->parent_name }}
                                                                    {{ $item->parent_surname }}
                                                                </h5>
                                                                <span
                                                                    class="badge bg-label-{{ $item->role == 'admin' ? 'danger' : 'info' }}">
                                                                    {{ $item->role == 'parent' ? 'Rodič' : 'Administrátor' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="ri-mail-line text-muted me-2"></i>
                                                                <span class="text-truncate"
                                                                    title="{{ $item->email }}">{{ $item->email }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="ri-user-follow-line text-muted me-2"></i>
                                                                <span>
                                                                    @if (null !== $item->member_names)
                                                                        <span class="text-truncate d-inline-block"
                                                                            style="max-width: 200px;"
                                                                            title="{{ $item->member_names }}">
                                                                            {{ $item->member_names }}
                                                                        </span>
                                                                    @else
                                                                        <span class="text-muted">Žádné děti</span>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="/user/{{ $item->id }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="ri-eye-line me-1"></i> Zobrazit
                                                            </a>
                                                            <div class="dropdown">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                    data-bs-toggle="dropdown">
                                                                    <i class="ri-settings-3-line me-1"></i> Akce
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-end">
                                                                    <a class="dropdown-item" href="#"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#assignMemberModal"
                                                                        data-user-id="{{ $item->id }}">
                                                                        <i class="ri-user-add-line me-2"></i> Přidělit
                                                                        děti
                                                                    </a>
                                                                    <form action="/users-role/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete změnit roli?');">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-user-settings-line me-2"></i>
                                                                            @if (null != $item->role && $item->role == 'parent')
                                                                                Nastavit roli Administrátor
                                                                            @elseif (null != $item->role && $item->role == 'admin')
                                                                                Nastavit roli rodič
                                                                            @endif
                                                                        </button>
                                                                    </form>
                                                                    <div class="dropdown-divider"></div>
                                                                    <form action="/user/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete smazat tohoto uživatele?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="dropdown-item text-danger">
                                                                            <i class="ri-delete-bin-6-line me-2"></i>
                                                                            Smazat
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-4 mx-auto"
                                    style="width: fit-content;">
                                    <i class="ri-parent-line text-primary" style="font-size: 4rem;"></i>
                                </div>
                            </div>
                            <h3 class="text-primary mb-3">Ještě si nepřidal žádného uživatele!</h3>
                            <p class="text-muted mb-4">Přidejte rodiče pomocí tlačítka níže.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editParentModal">
                                <i class="ri-user-add-line me-1"></i> Přidat rodiče
                            </button>
                        </div>
                    @endif
                </div>
                <div class="tab-pane fade h-100" id="navs-pills-top-presence" role="tabpanel">
                    @if ($attendance->first())
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h4 class="mb-0"><i
                                                class="ri-calendar-check-line me-2 text-primary"></i>Docházka</h4>
                                        <p class="text-muted mb-0">Správa docházky členů na akce</p>
                                    </div>
                                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                        <div class="btn-group" role="group">
                                            <button id="view-toggle-btn" class="btn btn-primary"
                                                onclick="toggleAttendanceView()">
                                                <i class="ri-table-line me-1"></i> Přepnout zobrazení
                                            </button>
                                            <button class="btn btn-outline-primary" id="filter-btn"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-filter-line me-1"></i> Filtrovat
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filter-btn">
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterAttendance('all')">Všechny akce</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterAttendance('recent')">Poslední měsíc</a></li>
                                                <li><a class="dropdown-item" href="#"
                                                        onclick="filterAttendance('upcoming')">Nadcházející</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4" id="attendance-input-group">
                            <div class="card-body">
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent border-end-0">
                                        <i class="ri-search-line"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0" id="attendance-search"
                                        placeholder="Hledat podle názvu akce nebo data...">
                                </div>
                            </div>
                        </div>
                        <div id="attendance-cards-view">
                            @php
                                $groupedEvents = $attendance->groupBy(function ($event) {
                                    return Carbon::parse($event->start_date)->format('d.m.Y');
                                });
                            @endphp

                            @foreach ($groupedEvents as $date => $events)
                                <div class="card mb-4 attendance-date-card" data-date="{{ $date }}">
                                    <div class="card-header bg-transparent py-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                <i class="ri-calendar-event-fill text-primary me-2"></i>
                                                {{ $date }}
                                            </h5>
                                            <button class="btn btn-sm btn-outline-primary rounded-pill toggle-events-btn"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#events-{{ Str::slug($date) }}">
                                                <i class="ri-arrow-down-s-line"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div id="events-{{ Str::slug($date) }}" class="collapse">
                                        @foreach ($events as $event)
                                            <div class="card-body border-bottom attendance-event-item"
                                                data-event-title="{{ $event->title }}">
                                                <div class="row align-items-center">
                                                    <div class="col-md-6">
                                                        <h5 class="mb-1">
                                                            <a href="/events/{{ $event->id }}"
                                                                class="text-decoration-none">
                                                                {{ $event->title }}
                                                            </a>
                                                        </h5>
                                                        <p class="text-muted mb-0 small">
                                                            <i class="ri-time-line me-1"></i>
                                                            {{ Carbon::parse($event->start_date)->format('H:i') }} -
                                                            {{ Carbon::parse($event->end_date)->format('H:i') }}
                                                            @if ($event->description)
                                                                <span class="ms-2">|</span>
                                                                <span
                                                                    class="ms-2">{{ Str::limit($event->description, 50) }}</span>
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="d-flex justify-content-md-center gap-3 mt-2 mt-md-0">
                                                            <div class="d-flex align-items-center" title="Přítomno">
                                                                <span
                                                                    class="badge bg-success rounded-pill me-1">{{ $event->present_count }}</span>
                                                                <i class="ri-user-follow-line text-success"></i>
                                                            </div>
                                                            <div class="d-flex align-items-center" title="Omluveno">
                                                                <span
                                                                    class="badge bg-warning rounded-pill me-1">{{ $event->excused_count }}</span>
                                                                <i class="ri-user-unfollow-line text-warning"></i>
                                                            </div>
                                                            <div class="d-flex align-items-center" title="Neomluveno">
                                                                <span
                                                                    class="badge bg-danger rounded-pill me-1">{{ $event->unexcused_count }}</span>
                                                                <i class="ri-user-forbid-line text-danger"></i>
                                                            </div>
                                                            <div class="d-flex align-items-center"
                                                                title="Potvrzeno rodiči">
                                                                <span
                                                                    class="badge bg-info rounded-pill me-1">{{ $event->confirmed_count ?? 0 }}</span>
                                                                <i class="ri-check-double-line text-info"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2 text-md-end mt-2 mt-md-0">
                                                        <button class="btn btn-sm btn-primary edit-attendance-btn"
                                                            onclick="showAttendanceEditor('{{ $event->id }}')">
                                                            <i class="ri-edit-line me-1"></i>Upravit
                                                        </button>
                                                    </div>
                                                </div>
                                                <div id="attendance-editor-{{ $event->id }}"
                                                    class="attendance-editor mt-3 pt-3 border-top d-none">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0">Úprava docházky - {{ $event->title }}</h6>
                                                        <button type="button" class="btn-close"
                                                            onclick="hideAttendanceEditor('{{ $event->id }}')"></button>
                                                    </div>

                                                    <div
                                                        class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3 member-attendance-list">
                                                        @foreach ($members as $member)
                                                            <div class="col">
                                                                <div class="card h-100 border attendance-member-card">
                                                                    <div class="card-body p-3">
                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center mb-2">
                                                                            <div class="d-flex align-items-center">

                                                                                <div>
                                                                                    <h6 class="mb-0">
                                                                                        {{ $member->name }}
                                                                                        {{ $member->surname }}</h6>
                                                                                </div>
                                                                            </div>

                                                                            <select
                                                                                class="form-select form-select-sm attendance-status"
                                                                                data-member-id="{{ $member->id }}"
                                                                                data-event-id="{{ $event->id }}"
                                                                                onchange="updateAttendance(this)">
                                                                                @php
                                                                                    $status = isset(
                                                                                        $attendanceData[$event->id][
                                                                                            $member->id
                                                                                        ],
                                                                                    )
                                                                                        ? $attendanceData[$event->id][
                                                                                            $member->id
                                                                                        ][0]->status
                                                                                        : null;
                                                                                    $confirmed = isset(
                                                                                        $attendanceData[$event->id][
                                                                                            $member->id
                                                                                        ],
                                                                                    )
                                                                                        ? $attendanceData[$event->id][
                                                                                            $member->id
                                                                                        ][0]->confirmed_by_parent
                                                                                        : null;
                                                                                @endphp
                                                                                <option value="present"
                                                                                    {{ $status == 'present' ? 'selected' : '' }}>
                                                                                    <i class="ri-user-follow-line"></i>
                                                                                    Přítomen
                                                                                </option>
                                                                                <option value="excused"
                                                                                    {{ $status == 'excused' ? 'selected' : '' }}>
                                                                                    <i class="ri-user-unfollow-line"></i>
                                                                                    Omluven
                                                                                </option>
                                                                                <option value="unexcused"
                                                                                    {{ $status == 'unexcused' ? 'selected' : '' }}>
                                                                                    <i class="ri-user-forbid-line"></i>
                                                                                    Neomluven
                                                                                </option>
                                                                            </select>

                                                                            @if ($confirmed)
                                                                                <span
                                                                                    class="badge bg-success attendance-confirmed-badge"
                                                                                    title="Potvrzeno rodičem">
                                                                                    <i class="ri-check-double-line"></i>
                                                                                    Potvrzeno
                                                                                </span>
                                                                            @else
                                                                                <span
                                                                                    class="badge bg-danger attendance-unconfirmed-badge"
                                                                                    title="Nepotvrzeno rodičem">
                                                                                    <i class="ri-time-line"></i>
                                                                                    Nepotvrzeno
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="attendance-table-view" class="d-none">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover attendance-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="border-0 py-3 ps-4" style="min-width: 200px;">Člen</th>
                                                    @foreach ($events1 as $event)
                                                        <th class="border-0 py-3 text-center" style="min-width: 150px;">
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="small fw-bold">{{ Carbon::parse($event->start_date)->format('d.m.Y') }}</span>
                                                                <span
                                                                    class="small text-muted">{{ Str::limit($event->title, 15) }}</span>
                                                            </div>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($members as $member)
                                                    <tr class="attendance-member-row">
                                                        <td class="py-3 ps-4">
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm me-2">
                                                                    <div
                                                                        class="avatar-initial rounded-circle bg-label-primary">
                                                                        {{ substr($member->name, 0, 1) }}{{ substr($member->surname, 0, 1) }}
                                                                    </div>
                                                                </div>
                                                                <a href="/members/{{ $member->id }}"
                                                                    class="text-body fw-semibold">
                                                                    {{ $member->name }} {{ $member->surname }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                        @foreach ($events1 as $event)
                                                            <td class="text-center py-2">
                                                                <div class="attendance-status-wrapper">
                                                                    <div class="d-flex flex-column gap-1">
                                                                        <select
                                                                            class="form-select form-select-sm attendance-status"
                                                                            data-member-id="{{ $member->id }}"
                                                                            data-event-id="{{ $event->id }}"
                                                                            onchange="updateAttendance(this)">
                                                                            @php
                                                                                $status = isset(
                                                                                    $attendanceData[$event->id][
                                                                                        $member->id
                                                                                    ],
                                                                                )
                                                                                    ? $attendanceData[$event->id][
                                                                                        $member->id
                                                                                    ][0]->status
                                                                                    : null;
                                                                                $confirmed = isset(
                                                                                    $attendanceData[$event->id][
                                                                                        $member->id
                                                                                    ],
                                                                                )
                                                                                    ? $attendanceData[$event->id][
                                                                                        $member->id
                                                                                    ][0]->confirmed_by_parent
                                                                                    : null;
                                                                            @endphp
                                                                            <option value="present"
                                                                                {{ $status == 'present' ? 'selected' : '' }}>
                                                                                <i class="ri-user-follow-line"></i>
                                                                                Přítomen
                                                                            </option>
                                                                            <option value="excused"
                                                                                {{ $status == 'excused' ? 'selected' : '' }}>
                                                                                <i class="ri-user-unfollow-line"></i>
                                                                                Omluven
                                                                            </option>
                                                                            <option value="unexcused"
                                                                                {{ $status == 'unexcused' ? 'selected' : '' }}>
                                                                                <i class="ri-user-forbid-line"></i>
                                                                                Neomluven
                                                                            </option>
                                                                        </select>

                                                                        @if ($confirmed)
                                                                            <span
                                                                                class="badge bg-success attendance-confirmed-badge"
                                                                                title="Potvrzeno rodičem">
                                                                                <i class="ri-check-double-line"></i>
                                                                                Potvrzeno
                                                                            </span>
                                                                        @else
                                                                            <span
                                                                                class="badge bg-danger attendance-unconfirmed-badge"
                                                                                title="Nepotvrzeno rodičem">
                                                                                <i class="ri-time-line"></i>
                                                                                Nepotvrzeno
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="ri-calendar-event-line text-primary" style="font-size: 4rem;"></i>
                            </div>
                            <h3 class="text-primary mb-2">Žádné akce k zobrazení</h3>
                            <p class="text-muted">Přidejte akce a členy pro zobrazení docházky</p>
                            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                                data-bs-target="#eventModal">
                                <i class="ri-add-line me-1"></i> Přidat akci
                            </button>
                        </div>
                    @endif
                </div>
                <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="editMemberModalLabel">
                                    <i class="ri-user-add-line me-2"></i>Přidat člena
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('member.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="team_id" value="{{ $id1 }}">
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-user-line me-2 text-primary"></i>Osobní údaje
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">Jméno <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="surname" class="form-label">Příjmení <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="surname"
                                                            name="surname">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="nickname" class="form-label">Přezdívka</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-user-smile-line"></i></span>
                                                        <input type="text" class="form-control" id="nickname"
                                                            name="nickname">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="age" class="form-label">Věk</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="number" class="form-control" id="age"
                                                            name="age" min="0" max="100">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="shirt_size_id" class="form-label">Velikost trika</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-t-shirt-line"></i></span>
                                                        <select class="form-select" id="shirt_size_id"
                                                            name="shirt_size_id">
                                                            <option selected disabled>Vyberte velikost
                                                            </option>
                                                            @foreach ($shirt_sizes as $size)
                                                                <option value="{{ $size->id }}">
                                                                    {{ $size->size }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-contacts-line me-2 text-primary"></i>Kontaktní údaje
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="telephone" class="form-label">Telefon</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-phone-line"></i></span>
                                                        <input type="text" class="form-control" id="telephone"
                                                            name="telephone" placeholder="+420 123 456 789">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                                        <input type="email" class="form-control" id="email"
                                                            name="email" placeholder="Zadejte email.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-parent-line me-2 text-primary"></i>Kontakt na matku
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="mother_name" class="form-label">Jméno matky</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="mother_name"
                                                            name="mother_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="mother_surname" class="form-label">Příjmení
                                                        matky</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="mother_surname"
                                                            name="mother_surname">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="mother_telephone" class="form-label">Telefon
                                                        matky</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-phone-line"></i></span>
                                                        <input type="text" class="form-control"
                                                            id="mother_telephone" name="mother_telephone"
                                                            placeholder="+420 123 456 789">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="mother_email" class="form-label">Email matky</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-mail-line"></i></span>
                                                        <input type="email" class="form-control" id="mother_email"
                                                            name="mother_email" placeholder="Zadejte email.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-parent-line me-2 text-primary"></i>Kontakt na otce
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="father_name" class="form-label">Jméno otce</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="father_name"
                                                            name="father_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="father_surname" class="form-label">Příjmení otce</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="father_surname"
                                                            name="father_surname">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="father_telephone" class="form-label">Telefon
                                                        otce</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-phone-line"></i></span>
                                                        <input type="text" class="form-control"
                                                            id="father_telephone" name="father_telephone"
                                                            placeholder="+420 123 456 789">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="father_email" class="form-label">Email otce</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-mail-line"></i></span>
                                                        <input type="email" class="form-control" id="father_email"
                                                            name="father_email" placeholder="Zadejte email.">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">
                                            <i class="ri-close-line me-1"></i>Zavřít
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Uložit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="eventModalLabel">
                                    <i class="ri-calendar-event-line me-2"></i>Přidat akci
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Zavřít"></button>
                            </div>
                            <div class="modal-body">
                                <form id="eventForm" action="{{ route('events.store') }}" method="POST">
                                    @csrf
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-information-line me-2 text-primary"></i>Základní informace
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Název akce <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="ri-calendar-event-line"></i></span>
                                                    <input type="text" class="form-control" id="title"
                                                        name="title" required placeholder="Zadejte název akce"
                                                        value="{{ old('title') }}"
                                                        oninput="this.setCustomValidity('')">
                                                </div>
                                                <div class="invalid-feedback">Prosím, zadejte název akce.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Popis</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="ri-file-text-line"></i></span>
                                                    <textarea class="form-control" id="description" name="description" rows="3"
                                                        placeholder="Zadejte popis akce" oninput="this.setCustomValidity('')">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-time-line me-2 text-primary"></i>Datum a čas
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="startDate" class="form-label">Začátek (datum) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control" id="startDate"
                                                            name="start_date" required
                                                            value="{{ old('start_date', Carbon::now()->toDateString()) }}"
                                                            oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="invalid-feedback">Prosím, vyberte platné datum začátku.
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="startTime" class="form-label">Začátek (čas) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-time-line"></i></span>
                                                        <input type="time" class="form-control" id="startTime"
                                                            name="start_time" value="16:00" required
                                                            oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="invalid-feedback">Prosím, vyberte čas začátku.</div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="endDate" class="form-label">Konec (datum) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control" id="endDate"
                                                            name="end_date" required
                                                            value="{{ old('end_date', Carbon::now()->toDateString()) }}"
                                                            oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="invalid-feedback">Prosím, vyberte platné datum konce.
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="endTime" class="form-label">Konec (čas) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-time-line"></i></span>
                                                        <input type="time" class="form-control" id="endTime"
                                                            name="end_time" value="18:00" required
                                                            oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="invalid-feedback">Prosím, vyberte čas konce.</div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="startDatetime" name="start_datetime">
                                            <input type="hidden" id="endDatetime" name="end_datetime">
                                            <input type="text" value="{{ $teamId }}" id="team_id"
                                                name="team_id" hidden>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-repeat-line me-2 text-primary"></i>Opakování
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="recurrenceType" class="form-label">Typ opakování</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-repeat-line"></i></span>
                                                    <select class="form-select" id="recurrenceType" name="recurrence"
                                                        value="none">
                                                        <option value="">Neopakovat</option>
                                                        <option value="daily">Denně</option>
                                                        <option value="weekly">Týdně</option>
                                                        <option value="monthly">Měsíčně</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="recurringOptions" class="mt-3" style="display: none;">
                                                <div class="mb-3">
                                                    <label for="interval" class="form-label">Každých x
                                                        (dní,týdnů,měsíců)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="number" class="form-control" id="interval"
                                                            value="" min="1" name="recurrenceInterval"
                                                            oninput="this.setCustomValidity('')">
                                                    </div>
                                                    <div class="invalid-feedback">Prosím, zadejte platný interval
                                                        opakování.</div>
                                                </div>
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="reccuringCheckbox" name="recurrenceCheckbox">
                                                    <label class="form-check-label" for="reccuringCheckbox">Použít počet
                                                        opakování</label>
                                                </div>

                                                <div class="mb-3" id="recurrenceEndDateContainer"
                                                    style="display: none;">
                                                    <label for="recurrenceEndDate" class="form-label"
                                                        id="recurrenceEndDateLabel">Konec opakování (datum)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control"
                                                            id="recurrenceEndDate"
                                                            value="{{ old('recurrenceEndDate') }}"
                                                            name="recurrenceEndDate"
                                                            placeholder="Datum posledního opakování">
                                                    </div>
                                                    <small class="text-muted">Celkový počet generovaných akcí nesmí
                                                        překročit 50.</small>
                                                </div>

                                                <div class="mb-3" id="repeatCountContainer" style="display: none;">
                                                    <label for="recurrenceRepeatCount" class="form-label"
                                                        id="recurrenceRepeatCountLabel">Počet opakování</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-repeat-line"></i></span>
                                                        <input type="number" class="form-control"
                                                            id="recurrenceRepeatCount" name="recurrenceRepeatCount"
                                                            min="1" max="50"
                                                            placeholder="Kolikrát se má akce opakovat">
                                                    </div>
                                                    <small class="text-muted">Maximální počet opakování je 50
                                                        akcí.</small>
                                                </div>
                                                <div class="row gy-4">
                                                    <div class="col-12">
                                                        <div class="mb-3 d-none" id="dateOutputContainer">
                                                            <h6 class="mb-2 text-primary">
                                                                <i class="ri-calendar-event-line me-2"></i>Náhled akce
                                                            </h6>
                                                            <div class="card shadow-sm">
                                                                <div class="card-body p-3">
                                                                    <ul id="dateOutput"
                                                                        class="list-group list-group-flush rounded"></ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-team-line me-2 text-primary"></i>Družiny a notifikace
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="sendMailCheckbox"
                                                    name="sendMailCheckbox">
                                                <label class="form-check-label" for="sendMailCheckbox">Zaslat e-mail
                                                    všem
                                                    rodičům? (Použijí se e-maily definované u členů družin: Email otce,
                                                    Email matky)</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2"
                                            data-bs-dismiss="modal">
                                            <i class="ri-close-line me-1"></i>Zavřít
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Uložit akci
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="addMembersModal" tabindex="-1" aria-labelledby="addMembersModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMembersModalLabel">Vytvořit více členů</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Zavřít"></button>
                            </div>
                            <div class="modal-body">
                                <h5 id="liveEditValue" class="text-center mb-4"></h5>
                                <div class="alert alert-info d-flex align-items-center mb-4">
                                    <i class="ri-information-line me-2 fs-5"></i>
                                    <div>
                                        Přidejte více členů najednou. Povinná pole jsou označena hvězdičkou (*).
                                    </div>
                                </div>
                                <form id="addMembersForm" action="{{ route('member.store.multiple') }}"
                                    method="POST">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Jméno <span class="text-danger">*</span></th>
                                                    <th>Příjmení <span class="text-danger">*</span></th>
                                                    <th>Přezdívka</th>
                                                    <th>Věk</th>
                                                    <th>Telefon</th>
                                                    <th>Email</th>
                                                    <th>Velikost trika</th>
                                                    <th>Matka > Jméno</th>
                                                    <th>Matka > Příjmení</th>
                                                    <th>Matka > Telefon</th>
                                                    <th>Matka > Email</th>
                                                    <th>Otec > Jméno</th>
                                                    <th>Otec > Příjmení</th>
                                                    <th>Otec > Telefon</th>
                                                    <th>Otec > Email</th>
                                                    <th>Akce</th>
                                                </tr>
                                            </thead>
                                            <tbody id="membersTableBody">
                                                @for ($i = 0; $i < 1; $i++)
                                                    <tr>
                                                        <input type="text" value="{{ $teamId }}"
                                                            id="team_id" name="team_id" hidden>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][name]"
                                                                class="form-control" required></td>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][surname]"
                                                                class="form-control"></td>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][nickname]"
                                                                class="form-control"></td>
                                                        <td><input type="number"
                                                                name="members[{{ $i }}][age]"
                                                                class="form-control"></td>
                                                        <td><input type="number"
                                                                name="members[{{ $i }}][telephone]"
                                                                class="form-control"></td>
                                                        <td><input type="email"
                                                                name="members[{{ $i }}][email]"
                                                                class="form-control"></td>

                                                        <td>
                                                            <select class="form-select"
                                                                name="members[{{ $i }}][shirt_size_id]">
                                                                <option value="">Vyberte velikost</option>
                                                                @foreach ($shirt_sizes as $size)
                                                                    <option value="{{ $size->id }}">
                                                                        {{ $size->size }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][mother_name]"
                                                                class="form-control"></td>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][mother_surname]"
                                                                class="form-control"></td>
                                                        <td><input type="number"
                                                                name="members[{{ $i }}][mother_telephone]"
                                                                class="form-control"></td>
                                                        <td><input type="email"
                                                                name="members[{{ $i }}][mother_email]"
                                                                class="form-control"></td>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][father_name]"
                                                                class="form-control"></td>
                                                        <td><input type="text"
                                                                name="members[{{ $i }}][father_surname]"
                                                                class="form-control"></td>
                                                        <td><input type="number"
                                                                name="members[{{ $i }}][father_telephone]"
                                                                class="form-control"></td>
                                                        <td><input type="email"
                                                                name="members[{{ $i }}][father_email]"
                                                                class="form-control"></td>
                                                        <td><button type="button"
                                                                class="btn btn-danger remove-row">Odstranit
                                                                řádek</button></td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="button" id="addRowButton" class="btn btn-success mt-3">Přidat další
                                        řádek</button>
                                    <div class="modal-footer mt-3">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Zavřít</button>
                                        <button type="submit" class="btn btn-primary">Vytvořit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="assignAchievementModal" tabindex="-1"
                    aria-labelledby="assignAchievementModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="assignAchievementModal">
                                    <i class="ri-award-line me-2"></i>Přidělit odborky
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addAchievementForm">
                                    <div class="mb-4">
                                        <label for="achievementSelect" class="form-label">Vyberte odborky <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group" id="memberAssignAchievement">
                                            <span class="input-group-text"><i class="ri-award-line"></i></span>
                                            <select class="js-example-basic-multiple form-select" id="achievementSelect"
                                                name="achievement_id[]" multiple="multiple" required>
                                                @foreach ($achievements as $achievement)
                                                    <option value="{{ $achievement->id }}">{{ $achievement->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-text">Vyberte jednu nebo více odborek, které chcete přidělit.
                                        </div>
                                    </div>
                                    <input type="hidden" id="memberId" name="member_id" value="">

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2"
                                            data-bs-dismiss="modal">
                                            <i class="ri-close-line me-1"></i>Zavřít
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-check-line me-1"></i>Přidělit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="assignMemberModal" tabindex="-1" aria-labelledby="assignMemberModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="assignMemberTitle">
                                    <i class="ri-user-add-line me-2"></i>Přidělit členy
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="assignMemberForm">
                                    <div class="mb-4">
                                        <label for="memberSelect" class="form-label">Vyberte členy <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group" id="userAssignMember">
                                            <span class="input-group-text"><i class="ri-user-line"></i></span>
                                            <select class="js-basic-multiple form-select" id="memberSelect"
                                                name="member_id[]" multiple="multiple" required>
                                                @foreach ($children as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                        {{ $item->surname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-text">Vyberte jednoho nebo více členů, které chcete přidělit.
                                        </div>
                                    </div>

                                    <input type="hidden" id="userId" name="user_id" value="">

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2"
                                            data-bs-dismiss="modal">
                                            <i class="ri-close-line me-1"></i>Zavřít
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-check-line me-1"></i>Přidělit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="editParentModalLabel">
                                    <i class="ri-parent-line me-2"></i>Přidat rodiče
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.store') }}" method="POST" id="createParentForm">
                                    @csrf
                                    @method('POST')

                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-user-line me-2 text-primary"></i>Osobní údaje
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="name" class="form-label">Jméno <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" required placeholder="Zadejte jméno">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="surname" class="form-label">Příjmení</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-user-line"></i></span>
                                                        <input type="text" class="form-control" id="surname"
                                                            name="surname" placeholder="Zadejte příjmení">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-mail-line"></i></span>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder="Zadejte email" required>
                                                </div>
                                                <div class="form-text">Email bude použit pro přihlášení do systému.</div>
                                            </div>

                                            <div class="form-check mb-3">
                                                <input type="checkbox" class="form-check-input" id="emailCheckbox"
                                                    name="emailCheckbox">
                                                <label class="form-check-label" for="emailCheckbox">Zaslat email s
                                                    heslem?</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-outline-secondary me-2"
                                            data-bs-dismiss="modal">
                                            <i class="ri-close-line me-1"></i>Zavřít
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Uložit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="multiEventEditModal" tabindex="-1"
                    aria-labelledby="multiEventEditModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="multiEventEditModalLabel">
                                    <i class="ri-edit-2-line me-2"></i>Hromadná úprava akcí
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Zavřít"></button>
                            </div>
                            <div class="modal-body">
                                <form id="bulkEditForm" action="{{ route('events.update.multiple') }}"
                                    method="POST">
                                    @csrf
                                    <input type="hidden" name="event_ids[]" id="eventIdsEdit">

                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">Vybrané akce</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="table-light sticky-top">
                                                        <tr>
                                                            <th>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="selectAllEventsEdit">
                                                            </th>
                                                            <th>Název</th>
                                                            <th>Začátek</th>
                                                            <th>Konec</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="eventsListEdit">
                                                        @foreach ($eventsCollection as $e)
                                                            <tr data-id="{{ $e->id }}">
                                                                <td>
                                                                    <input class="form-check-input event-checkbox"
                                                                        type="checkbox" value="{{ $e->id }}">
                                                                </td>
                                                                <td>{{ $e->title }}</td>
                                                                <td>{{ Carbon::parse($e->start_date)->format('d.m.Y H:i') }}
                                                                </td>
                                                                <td>{{ Carbon::parse($e->end_date)->format('d.m.Y H:i') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="p-3 border-top">
                                                <span class="badge bg-primary" id="selectedEventsCountEdit">0
                                                    vybraných
                                                    akcí</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0"><i
                                                    class="ri-information-line me-2 text-primary"></i>Základní
                                                informace</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="bulkTitle" class="form-label">Název akce</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-event-line"></i></span>
                                                        <input type="text" class="form-control" id="bulkTitle"
                                                            name="title" placeholder="Ponechat původní">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="bulkTeamSelect" class="form-label">Družiny</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-group-line"></i></span>
                                                        <select class="delete-event-team-select" id="bulkTeamSelect"
                                                            name="team_ids[]" multiple="multiple">
                                                            @foreach (Teams::all() as $team)
                                                                <option value="{{ $team->id }}">
                                                                    {{ $team->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bulkDescription" class="form-label">Popis</label>
                                                <div class="input-group" id="selectContainer">
                                                    <span class="input-group-text"><i
                                                            class="ri-file-text-line"></i></span>
                                                    <textarea class="form-control" id="bulkDescription" name="description" rows="3"
                                                        placeholder="Ponechat původní"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0"><i class="ri-time-line me-2 text-primary"></i>Datum a
                                                čas</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="bulkStartDate" class="form-label">Začátek
                                                        (datum)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control" id="bulkStartDate"
                                                            name="start_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="bulkStartTime" class="form-label">Začátek
                                                        (čas)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-time-line"></i></span>
                                                        <input type="time" class="form-control" id="bulkStartTime"
                                                            name="start_time">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="bulkEndDate" class="form-label">Konec
                                                        (datum)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control" id="bulkEndDate"
                                                            name="end_date">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="bulkEndTime" class="form-label">Konec (čas)</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-time-line"></i></span>
                                                        <input type="time" class="form-control" id="bulkEndTime"
                                                            name="end_time">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="alert alert-warning">
                                        <div class="d-flex">
                                            <i class="ri-information-line me-2 fs-5 align-self-center"></i>
                                            <div><strong>Upozornění:</strong> Prázdná pole nebudou změněna a původní
                                                hodnoty
                                                zůstanou zachovány.</div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1"></i>Zavřít</button>
                                        <button type="submit" class="btn btn-primary" id="bulkEditSubmit"><i
                                                class="ri-save-line me-1"></i>Uložit změny</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="multiEventDeleteModal" tabindex="-1"
                    aria-labelledby="multiEventDeleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="multiEventDeleteModalLabel">
                                    <i class="ri-delete-bin-line me-2"></i>Hromadné mazání akcí
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Zavřít"></button>
                            </div>
                            <div class="modal-body">
                                <form id="bulkDeleteForm" action="{{ route('events.delete.multiple') }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="event_ids[]" id="eventIdsDelete">

                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">Vybrané akce k odstranění</h6>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="table-light sticky-top">
                                                        <tr>
                                                            <th>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="selectAllEventsDelete">
                                                            </th>
                                                            <th>Název</th>
                                                            <th>Začátek</th>
                                                            <th>Konec</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="eventsListDelete">
                                                        @foreach ($eventsCollection as $e)
                                                            <tr data-id="{{ $e->id }}">
                                                                <td>
                                                                    <input class="form-check-input event-checkbox"
                                                                        type="checkbox" value="{{ $e->id }}">
                                                                </td>
                                                                <td>{{ $e->title }}</td>
                                                                <td>{{ Carbon::parse($e->start_date)->format('d.m.Y H:i') }}
                                                                </td>
                                                                <td>{{ Carbon::parse($e->end_date)->format('d.m.Y H:i') }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="p-3 border-top">
                                                <span class="badge bg-danger" id="selectedEventsCountDelete">0
                                                    vybraných
                                                    akcí</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-danger">
                                        <div class="d-flex">
                                            <i class="ri-alert-line me-2 fs-5 align-self-center"></i>
                                            <div><strong>Varování:</strong> Chystáte se smazat vybrané akce. Tato akce
                                                je
                                                nevratná.</div>
                                        </div>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                                        <label class="form-check-label" for="confirmDelete">Potvrzuji, že chci
                                            trvale
                                            odstranit vybrané akce</label>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal"><i class="ri-close-line me-1"></i>Zavřít</button>
                                        <button type="submit" class="btn btn-danger" id="bulkDeleteSubmit"><i
                                                class="ri-delete-bin-line me-1"></i>Smazat vybrané</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header text-white">
                                <h5 class="modal-title" id="editEventModalLabel">
                                    <i class="ri-edit-2-line me-2"></i>Upravit akci
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Zavřít"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editEventForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="editEventId" name="event_id">

                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-information-line me-2 text-primary"></i>Základní informace
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="editTitle" class="form-label">Název akce <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="ri-calendar-event-line"></i></span>
                                                    <input type="text" class="form-control" id="editTitle"
                                                        name="title" required placeholder="Zadejte název akce">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="editDescription" class="form-label">Popis</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="ri-file-text-line"></i></span>
                                                    <textarea class="form-control" id="editDescription" name="description" rows="3"
                                                        placeholder="Zadejte popis akce"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">
                                                <i class="ri-time-line me-2 text-primary"></i>Datum a čas
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="editStartDate" class="form-label">Začátek (datum) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control" id="editStartDate"
                                                            name="start_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="editStartTime" class="form-label">Začátek (čas) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-time-line"></i></span>
                                                        <input type="time" class="form-control" id="editStartTime"
                                                            name="start_time" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="editEndDate" class="form-label">Konec (datum) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-calendar-line"></i></span>
                                                        <input type="date" class="form-control" id="editEndDate"
                                                            name="end_date" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="editEndTime" class="form-label">Konec (čas) <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="ri-time-line"></i></span>
                                                        <input type="time" class="form-control" id="editEndTime"
                                                            name="end_time" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" id="editTeamId" name="team_id"
                                                value="{{ $teamId }}">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">
                                            <i class="ri-close-line me-1"></i>Zavřít
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Uložit změny
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @endsection
