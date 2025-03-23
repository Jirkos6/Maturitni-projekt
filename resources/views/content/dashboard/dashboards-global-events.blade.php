@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Akce pro více družin')

@section('content')
    @use('\Carbon\Carbon')
    @php
        Carbon::setLocale('cs');
    @endphp
    @use('App\Models\Teams')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
        @if (Teams::count() >= 2)
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">
                                <i class="ri-calendar-event-line me-2 text-primary"></i>Akce pro více družin
                            </h4>
                            <p class="text-muted mb-0">Správa všech akcí pro více družin</p>
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-end gap-2 overflow-auto">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#eventModal">
                                <i class="ri-add-line me-1"></i> Přidat akci
                            </button>
                            <button type="button" class="btn btn-outline-primary" id="bulkEditButton"
                                data-bs-toggle="modal" data-bs-target="#multiEventEditModal">
                                <i class="ri-edit-2-line me-1"></i> Hromadná úprava
                            </button>
                            <button type="button" class="btn btn-outline-danger" id="bulkDeleteButton"
                                data-bs-toggle="modal" data-bs-target="#multiEventDeleteModal">
                                <i class="ri-delete-bin-line me-1"></i> Hromadné mazání
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 mb-3 mb-md-0">
                    <div class="card border-0 shadow-sm h-100 bg-gradient-light">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning p-3 bg-opacity-10 me-3">
                                <i class="ri-calendar-event-line text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 text-muted">Počet akcí</h6>
                                <h4 class="card-title mb-0">{{ $data->count() }}</h4>
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
                                    {{ $data->filter(function ($event) {
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
                                    {{ $data->filter(function ($event) {
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
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-filter-line me-1"></i> Filtrovat
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item" href="#" onclick="filterEvents('all')">Všechny
                                            akce</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="filterEvents('upcoming')">Nadcházející</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="filterEvents('past')">Proběhlé</a>
                                    </li>
                                    <li><a class="dropdown-item" href="#" onclick="filterEvents('thisMonth')">Tento
                                            měsíc</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            onclick="filterEvents('nextMonth')">Příští
                                            měsíc</a></li>
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
                                <th>Družiny</th>
                                <th>Popis</th>
                                <th class="text-end pe-4">Akce</th>
                            </tr>
                        </thead>
                        <tbody class="event-list">
                            @foreach ($data as $event)
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
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse ($event->teams as $t)
                                                <span class="badge bg-primary bg-opacity-75" title="{{ $t->name }}">
                                                    {{ Str::limit($t->name, 15) }}
                                                </span>
                                            @empty
                                                <span class="text-muted">Žádné družiny</span>
                                            @endforelse
                                        </div>
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
                                                <a class="dropdown-item" href="#"
                                                    onclick="editEvent({{ $event->id }})">
                                                    <i class="ri-pencil-line me-2"></i> Upravit
                                                </a>
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
                    @foreach ($data as $event)
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
                                            <button type="button" class="btn btn-sm btn-icon btn-light rounded-circle"
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
                                                <span class="ms-1">{{ $startDate->format('d.m.Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar avatar-xs me-2 bg-danger bg-opacity-25">
                                                <i class="ri-calendar-close-line text-danger"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Konec:</small>
                                                <span class="ms-1">{{ $endDate->format('d.m.Y H:i') }}</span>
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
                                            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <p class="text-muted fst-italic">Bez popisu</p>
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <h6 class="text-muted mb-1">Družiny:</h6>
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse ($event->teams as $t)
                                                <span class="badge bg-primary bg-opacity-75" title="{{ $t->name }}">
                                                    {{ Str::limit($t->name, 15) }}
                                                </span>
                                            @empty
                                                <span class="text-muted">Žádné družiny</span>
                                            @endforelse
                                        </div>
                                    </div>
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
                                                <input type="text" class="form-control" id="title" name="title"
                                                    required placeholder="Zadejte název akce" value="{{ old('title') }}"
                                                    oninput="this.setCustomValidity('')">
                                            </div>
                                            <div class="invalid-feedback">Prosím, zadejte název akce.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Popis</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Zadejte popis akce"
                                                    oninput="this.setCustomValidity('')">{{ old('description') }}</textarea>
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
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="date" class="form-control" id="startDate"
                                                        name="start_date" required
                                                        value="{{ old('start_date', Carbon::now()->toDateString()) }}"
                                                        oninput="this.setCustomValidity('')">
                                                </div>
                                                <div class="invalid-feedback">Prosím, vyberte platné datum začátku.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="startTime" class="form-label">Začátek (čas) <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
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
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="date" class="form-control" id="endDate"
                                                        name="end_date" required
                                                        value="{{ old('end_date', Carbon::now()->toDateString()) }}"
                                                        oninput="this.setCustomValidity('')">
                                                </div>
                                                <div class="invalid-feedback">Prosím, vyberte platné datum konce.</div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="endTime" class="form-label">Konec (čas) <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                    <input type="time" class="form-control" id="endTime"
                                                        name="end_time" value="18:00" required
                                                        oninput="this.setCustomValidity('')">
                                                </div>
                                                <div class="invalid-feedback">Prosím, vyberte čas konce.</div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="startDatetime" name="start_datetime">
                                        <input type="hidden" id="endDatetime" name="end_datetime">
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
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="number" class="form-control" id="interval"
                                                        value="" min="1" name="recurrenceInterval"
                                                        oninput="this.setCustomValidity('')">
                                                </div>
                                                <div class="invalid-feedback">Prosím, zadejte platný interval opakování.
                                                </div>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="filterOutHolidayDates" name="filterOutHolidayDates">
                                                <label class="form-check-label" for="filterOutHolidayDates">Vynechat
                                                    svátky</label>
                                            </div>
                                            <div class="mb-3 form-check">
                                                <input type="checkbox" class="form-check-input" id="reccuringCheckbox"
                                                    name="recurrenceCheckbox">
                                                <label class="form-check-label" for="reccuringCheckbox">Použít počet
                                                    opakování</label>
                                            </div>
                                            <div class="mb-3" id="recurrenceEndDateContainer">
                                                <label for="recurrenceEndDate" class="form-label"
                                                    id="recurrenceEndDateLabel">Konec opakování (datum)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="date" class="form-control" id="recurrenceEndDate"
                                                        value="{{ old('recurrenceEndDate') }}" name="recurrenceEndDate"
                                                        placeholder="Datum posledního opakování">
                                                </div>
                                                <small class="text-muted">Celkový počet generovaných akcí nesmí překročit
                                                    50.</small>
                                            </div>
                                            <div class="mb-3 d-none" id="repeatCountContainer">
                                                <label for="recurrenceRepeatCount" class="form-label"
                                                    id="recurrenceRepeatCountLabel">Počet opakování</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-repeat-line"></i></span>
                                                    <input type="number" class="form-control" id="recurrenceRepeatCount"
                                                        name="recurrenceRepeatCount" min="1" max="50"
                                                        placeholder="Kolikrát se má akce opakovat">
                                                </div>
                                                <small class="text-muted">Maximální počet opakování je 50 akcí.</small>
                                            </div>
                                            <div class="row gy-4">
                                                <div class="col-12 col-md-6">
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
                                                <div class="col-12 col-md-6">
                                                    <div class="mb-3 d-none" id="datesRemovedOutputContainer">
                                                        <h6 class="mb-2 text-warning">
                                                            <i class="ri-calendar-close-line me-2"></i>Vynechané termíny
                                                        </h6>
                                                        <div class="card shadow-sm">
                                                            <div class="card-body p-3">
                                                                <ul id="datesRemovedOutput"
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
                                        <div class="mb-3">
                                            <label for="teamSelect" class="form-label">Vyberte družiny (V základu pro
                                                vybranou družinu)</label>
                                            <div class="input-group" id="eventAssignTeam">
                                                <span class="input-group-text"><i class="ri-group-line"></i></span>
                                                <select class="team-select" id="teamSelect" name="team_ids[]"
                                                    multiple="multiple">
                                                    @foreach ($teams as $team)
                                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-text">Vyberte družiny, které se zúčastní této akce.</div>
                                            @error('team_ids')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="sendMailCheckbox"
                                                name="sendMailCheckbox">
                                            <label class="form-check-label" for="sendMailCheckbox">Zaslat e-mail všem
                                                rodičům?</label>
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
            <div class="modal fade" id="multiEventEditModal" tabindex="-1" aria-labelledby="multiEventEditModalLabel"
                aria-hidden="true">
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
                            <form id="bulkEditForm" action="{{ route('events.update.multiple') }}" method="POST">
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
                                                        <th>Družiny</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="eventsListEdit">
                                                    @foreach ($data as $event)
                                                        <tr data-id="{{ $event->id }}">
                                                            <td>
                                                                <input class="form-check-input event-checkbox"
                                                                    type="checkbox" value="{{ $event->id }}">
                                                            </td>
                                                            <td>{{ $event->title }}</td>
                                                            <td>{{ Carbon::parse($event->start_date)->format('d.m.Y H:i') }}
                                                            </td>
                                                            <td>{{ Carbon::parse($event->end_date)->format('d.m.Y H:i') }}
                                                            </td>
                                                            <td>{{ $event->teams->pluck('name')->implode(', ') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-3 border-top">
                                            <span class="badge bg-primary" id="selectedEventsCountEdit">0 vybraných
                                                akcí</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-header bg-transparent">
                                        <h6 class="mb-0"><i class="ri-information-line me-2 text-primary"></i>Základní
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
                                                    <span class="input-group-text"><i class="ri-group-line"></i></span>
                                                    <select class="delete-event-team-select" id="bulkTeamSelect"
                                                        name="team_ids[]" multiple="multiple">
                                                        @foreach ($teams as $team)
                                                            <option value="{{ $team->id }}">{{ $team->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bulkDescription" class="form-label">Popis</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                                <textarea class="form-control" id="bulkDescription" name="description" rows="3"
                                                    placeholder="Ponechat původní"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4 border-0 shadow-sm">
                                    <div class="card-header bg-transparent">
                                        <h6 class="mb-0"><i class="ri-time-line me-2 text-primary"></i>Datum a čas</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="bulkStartDate" class="form-label">Začátek (datum)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="date" class="form-control" id="bulkStartDate"
                                                        name="start_date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="bulkStartTime" class="form-label">Začátek (čas)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
                                                    <input type="time" class="form-control" id="bulkStartTime"
                                                        name="start_time">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="bulkEndDate" class="form-label">Konec (datum)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="date" class="form-control" id="bulkEndDate"
                                                        name="end_date">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="bulkEndTime" class="form-label">Konec (čas)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-time-line"></i></span>
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
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i
                                            class="ri-close-line me-1"></i>Zavřít</button>
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
                            <form id="bulkDeleteForm" action="{{ route('events.delete.multiple') }}" method="POST">
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
                                                        <th>Družiny</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="eventsListDelete">
                                                    @foreach ($data as $event)
                                                        <tr data-id="{{ $event->id }}">
                                                            <td>
                                                                <input class="form-check-input event-checkbox"
                                                                    type="checkbox" value="{{ $event->id }}">
                                                            </td>
                                                            <td>{{ $event->title }}</td>
                                                            <td>{{ Carbon::parse($event->start_date)->format('d.m.Y H:i') }}
                                                            </td>
                                                            <td>{{ Carbon::parse($event->end_date)->format('d.m.Y H:i') }}
                                                            </td>
                                                            <td>{{ $event->teams->pluck('name')->implode(', ') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="p-3 border-top">
                                            <span class="badge bg-danger" id="selectedEventsCountDelete">0 vybraných
                                                akcí</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-danger">
                                    <div class="d-flex">
                                        <i class="ri-alert-line me-2 fs-5 align-self-center"></i>
                                        <div><strong>Varování:</strong> Chystáte se smazat vybrané akce. Tato akce je
                                            nevratná.</div>
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                                    <label class="form-check-label" for="confirmDelete">Potvrzuji, že chci trvale
                                        odstranit vybrané akce</label>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><i
                                            class="ri-close-line me-1"></i>Zavřít</button>
                                    <button type="submit" class="btn btn-danger" id="bulkDeleteSubmit"><i
                                            class="ri-delete-bin-line me-1"></i>Smazat vybrané</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-body text-center">
                    <h4 class="mb-3"><i class="ri-information-line me-2 text-warning"></i>Pozor!</h4>
                    <p class="text-muted">Pro vytvoření akce pro více družin je potřeba mít alespoň 2 družiny. Momentálně
                        máte {{ Teams::count() }}.</p>
                </div>
            </div>
        @endif
    </div>



@endsection
