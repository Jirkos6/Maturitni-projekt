@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
    $sectionName = $data->first()->name;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Oddíl ' . $sectionName)
@section('content')
    @vite(['resources/js/app.js'])
    @use('App\Models\Teams')
    @use('App\Models\Achievements')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');
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

            var calendar = new window.Calendar(calendarEl, {
                plugins: [window.interaction, window.dayGridPlugin, window.timeGridPlugin, window
                    .listPlugin, window.multiMonthPlugin, window.rrulePlugin
                ],
                selectable: 'true',
                initialView: 'dayGridMonth',
                locale: l13,
                events: {!! $events !!},
                timeZone: '',
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
                dateClick: function(info) {

                },
                eventClick: function(info) {
                    window.location.href = "/events/" + info.event.id;
                },
                eventMouseEnter: function(info) {
                    info.el.style.cursor =
                        'pointer';
                    info.el.style.backgroundColor = '#28a745';
                    info.el.style.borderColor = '#218838';
                    info.el.style.transform = 'scale(1.01)';
                    info.el.style.boxShadow =
                        '0 0 15px rgba(40, 167, 69, 0.5)';
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
                },
            });

            calendar.render();
        });
    </script>
    <style>
        #calendar {
            max-width: 100%;
            margin: 1px auto;
        }


        .modal-backdrop {
            display: none !important;
        }
    </style>





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
        <div class="col-xl-12 h-100">
            <h3 class="mb-0">Oddíl
                <span class="badge rounded-pill bg-label-primary">{{ $data->first()->name }}</span>
            </h3>

            <div class="nav-align-top mb-6 mt-6 h-100 d-flex flex-column">
                <ul class="nav nav-pills mb-4" role="tablist">
                    <a href="#navs-pills-top-home">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                                aria-selected="true">Kalendář</button>
                        </li>
                    </a>
                    <a href="#navs-pills-top-profile">
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                                aria-selected="false">Přehled</button>
                        </li>
                    </a>
                    <a href="#navs-pills-top-messages">
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                                aria-selected="false">Členové</button>
                        </li>
                    </a>
                    <a href="#navs-pills-top-presence">
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-presence" aria-controls="navs-pills-top-presence"
                                aria-selected="false">Docházka</button>
                        </li>
                    </a>
                    <a href="#navs-pills-top-achievements">
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-achievements" aria-controls="navs-pills-top-achievements"
                                aria-selected="false">Odborky</button>
                        </li>
                    </a>
                </ul>

                <div class="tab-content flex-grow-0.3">
                    <div class="tab-pane fade show active h-100" id="navs-pills-top-home" role="tabpanel">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventModal">
                            Přidání akcí
                        </button>

                        <div id="calendar"></div>
                    </div>














                    <div class="tab-pane fade h-100" id="navs-pills-top-profile" role="tabpanel">
                        <div class="row mb-12 g-6">
                            @if (null !== $nextevent)
                                <div class="col-md-6 col-xl-2 rounded-2xl">
                                    <h3 class="text-center text-primary mb-4">Nejbližší akce:</h3>
                                    <a href="/events/{{ $nextevent->id }}" rel="noreferrer"
                                        class="card text-decoration-none">
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-info mb-3">{{ $nextevent->title }}</h5>
                                            <p class="card-text text-muted">
                                                {{ $nextevent->description }}
                                                <br>
                                                <strong>Začátek:</strong><br>
                                                {{ \Carbon\Carbon::parse($nextevent->start)->format('d.m.Y h:i:s') }}<br>
                                                <strong>Konec:</strong><br>
                                                {{ \Carbon\Carbon::parse($nextevent->end)->format('d.m.Y h:i:s') }}
                                            </p>
                                        </div>
                                        <img class="card-img-bottom img-fluid rounded-3 mb-3"
                                            src="{{ asset('https://img.freepik.com/premium-vector/mentors-little-scouts-tourists-learn-put-up-tent-make-fire-life-nature-skills-kids-expedition-teacher-teaches-children-cook-campfire-splendid-vector-illustration_533410-2617.jpg') }}"
                                            alt="Event Image">
                                    </a>
                                </div>
                            @else
                                <h3 class="text-center text-primary mb-4">Není žádná nadcházející akce!</h3>
                            @endif
                        </div>
                    </div>

























                    <div class="tab-pane fade h-100" id="navs-pills-top-messages" role="tabpanel">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editMemberModal">
                            Přidat člena
                        </button>
                        @if (null !== Teams::count())
                            <h3 class="text-center text-primary mb-10">Počet členů ({{ $memberCount }})</h3>
                            <div class="card">
                                <h5 class="card-header">Členové</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Jméno</th>
                                                <th>Docházka</th>
                                                <th>Akce</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($members as $item)
                                                <tr>

                                                    <td><a href="/members/{{ $item->id }}"><i
                                                                class="ri-user-fill"></i><span>{{ $item->name }}

                                                                {{ $item->surname }}</span></td>
                                                    </a>
                                                    <td>0%</td>


                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="ri-more-2-line"></i>
                                                            </button>
                                                            <div class="dropdown-menu">


                                                                <a class="dropdown-item"
                                                                    href="/members/{{ $item->id }}">
                                                                    <i class="ri-information-line "></i>Zobrazit
                                                                </a>
                                                                <a class="">
                                                                    <form action="/member/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete smazat tohoto člena?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-delete-bin-6-line"></i>Smazat
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </td>


                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <h3 class="text-center text-primary mb-4">Ještě si nepřidal žádného člena!</h3>
                        @endif

                    </div>
                    <div class="tab-pane fade h-100" id="navs-pills-top-presence" role="tabpanel">
                        <div class="row mb-12 g-6">
                            @foreach ($attendance as $event)
                                <div class="col-md-12 mb-4">
                                    <h5>{{ $event->title }}</h5>
                                    <p>{{ $event->start_date }} - {{ $event->end_date }}</p>

                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Docházka</th>
                                                <th>Počet</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Přítomno</td>
                                                <td>{{ $event->present_count }}</td>
                                            </tr>
                                            <tr>
                                                <td>Omluveno</td>
                                                <td>{{ $event->excused_count }}</td>
                                            </tr>
                                            <tr>
                                                <td>Neomluveno</td>
                                                <td>{{ $event->unexcused_count }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>






                    <div class="tab-pane fade h-100" id="navs-pills-top-achievements" role="tabpanel">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addAchievementModal">
                            Přidat Odborku
                        </button>
                        <div class="row mb-12 g-6">

                            @if (null !== Achievements::count())
                                <h3 class="text-center text-primary mb-10">Počet odborek ({{ Achievements::count() }})
                                </h3>



                                @foreach ($achievements as $item1)
                                    <div class="col-md-6 col-xl-3 rounded-2xl">
                                        <div class="card shadow-sm border-0">
                                            <img class="card-img-top rounded-md"
                                                src="{{ asset('storage/achievements/' . $item1->image) }}"
                                                alt="Card image" />

                                            <div class="card-body">
                                                <h5 class="card-title">{{ $item1->name }}</h5>

                                                <p class="card-text">
                                                    @if (null !== $item1->description)
                                                        {{ $item1->description }}
                                                    @else
                                                        <span class="text-muted">Bez popisku</span>
                                                    @endif
                                                </p>

                                                <div class="d-flex justify-content-end">

                                                    <a href="javascript:void(0);" class="me-2 text-primary"
                                                        data-bs-toggle="modal" data-bs-target="#editAchievementModal"
                                                        onclick="editAchievement({{ $item1->id }}, '{{ $item1->name }}', '{{ $item1->description }}', '{{ asset('storage/achievements/' . $item1->image) }}')">
                                                        <i class="ri-pencil-line fs-5"></i>
                                                    </a>

                                                    <form action="/achievement/{{ $item1->id }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="display: none;"></button>
                                                        <div class="text-danger" title="Smazat" style="cursor: pointer;"
                                                            onclick="this.closest('form').submit();">
                                                            <i class="ri-delete-bin-6-line fs-5"></i>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                        </div>
                    </div>
                @else
                    <h3 class="text-center text-primary mb-4">Ještě si nepřidal žádné odborky!</h3>
                    @endif
                </div>
            </div>




        </div>
        <div class="modal fade" id="editMemberModal" tabindex="-1" aria-labelledby="editMemberModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMemberModalLabel">Přidat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('member.store') }}" method="POST" id="createMemberForm">
                            @csrf
                            @method('POST')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Jméno</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="surname" class="form-label">Příjmení</label>
                                    <input type="text" class="form-control" id="surname" name="surname" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="age" class="form-label">Věk</label>
                                    <input type="number" class="form-control" id="age" name="age">
                                </div>
                                <div class="col-md-6">
                                    <label for="shirt_size_id" class="form-label">Velikost trika</label>
                                    <select class="form-select" id="shirt_size_id" name="shirt_size_id">
                                        <option value="">Vyberte velikost</option>
                                        @foreach ($shirt_sizes as $size)
                                            <option value="{{ $size->id }}">{{ $size->size }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nickname" class="form-label">Přezdívka</label>
                                    <input type="text" class="form-control" id="nickname" name="nickname">
                                </div>
                                <div class="col-md-6">
                                    <label for="telephone" class="form-label">Telefon</label>
                                    <input type="text" class="form-control" id="telephone" name="telephone">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>

                            <h6 class="mt-4">Kontakt na matku</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="mother_name" class="form-label">Jméno matky</label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_surname" class="form-label">Příjmení matky</label>
                                    <input type="text" class="form-control" id="mother_surname"
                                        name="mother_surname">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="mother_telephone" class="form-label">Telefon matky</label>
                                    <input type="text" class="form-control" id="mother_telephone"
                                        name="mother_telephone">
                                </div>
                                <div class="col-md-6">
                                    <label for="mother_email" class="form-label">Email matky</label>
                                    <input type="email" class="form-control" id="mother_email" name="mother_email">
                                </div>
                            </div>

                            <h6 class="mt-4">Kontakt na otce</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="father_name" class="form-label">Jméno otce</label>
                                    <input type="text" class="form-control" id="father_name" name="father_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="father_surname" class="form-label">Příjmení otce</label>
                                    <input type="text" class="form-control" id="father_surname"
                                        name="father_surname">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="father_telephone" class="form-label">Telefon otce</label>
                                    <input type="text" class="form-control" id="father_telephone"
                                        name="father_telephone">
                                </div>
                                <div class="col-md-6">
                                    <label for="father_email" class="form-label">Email otce</label>
                                    <input type="email" class="form-control" id="father_email" name="father_email">
                                </div>
                            </div>

                            <input type="text" value="{{ $id1 }}" id="team_id" name="team_id" hidden>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                                <button type="submit" class="btn btn-primary">Uložit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eventModalLabel">Přidat událost</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                    </div>
                    <div class="modal-body">
                        <form id="eventForm" action="{{ route('events.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Název události</label>
                                <input type="text" class="form-control" id="title" name="title" required
                                    placeholder="Zadejte název události" value="{{ old('title') }}"
                                    oninput="this.setCustomValidity('')">
                                <div class="invalid-feedback">Prosím, zadejte název události.</div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Popis</label>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Zadejte popis události" oninput="this.setCustomValidity('')">{{ old('description') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="startDate" class="form-label">Začátek (datum)</label>
                                    <input type="date" class="form-control" id="startDate" name="start_date" required
                                        value="{{ old('start_date') }}" oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Prosím, vyberte platné datum začátku.</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="startTime" class="form-label">Začátek (čas)</label>
                                    <input type="time" class="form-control" id="startTime" name="start_time"
                                        value="12:00" required oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Prosím, vyberte čas začátku.</div>
                                    <input type="text" value="{{ $id1 }}" id="team_id" name="team_id"
                                        hidden>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="endDate" class="form-label">Konec (datum)</label>
                                    <input type="date" class="form-control" id="endDate" name="end_date" required
                                        value="{{ old('end_date') }}" oninput="this.setCustomValidity('')">
                                    <input type="hidden" id="startDatetime" name="start_datetime">
                                    <input type="hidden" id="endDatetime" name="end_datetime">
                                    <input type="hidden" id="isRecurring" name="is_recurring">
                                    <div class="invalid-feedback">Prosím, vyberte platné datum konce.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="endTime" class="form-label">Konec (čas)</label>
                                    <input type="time" class="form-control" id="endTime" name="end_time"
                                        value="12:00" required oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Prosím, vyberte čas konce.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="recurrenceType" class="form-label">Typ opakování</label>
                                <select class="form-select" id="recurrenceType" name="recurrence[frequency]" required
                                    value="none">
                                    <option value="none">Neopakující se</option>
                                    <option value="daily">Denně</option>
                                    <option value="weekly">Týdně</option>
                                </select>
                            </div>

                            <div id="recurringOptions" class="mt-3" style="display: none;">
                                <div class="mb-3">
                                    <label for="interval" class="form-label">Interval opakování (v dnech)</label>
                                    <input type="number" class="form-control" id="interval"
                                        name="recurrence[interval]" min="0" oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Prosím, zadejte platný interval opakování.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="reccuringCheckbox" class="form-label">Použít počet opakování</label>
                                    <input type="checkbox" id="reccuringCheckbox" name="reccuringCheckbox">
                                </div>
                                <div class="mb-3">
                                    <label for="recurrenceEndDate" class="form-label" id="recurrenceEndDateLabel">Konec
                                        opakování (datum)</label>
                                    <input type="date" class="form-control" id="recurrenceEndDate" value=""
                                        name="recurrence[end_date]" oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Prosím, vyberte platné datum pro konec opakování.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="recurrenceRepeatCount" class="form-label"
                                        id="recurrenceRepeatCountLabel">Počet opakování</label>
                                    <input type="number" class="form-control" id="recurrenceRepeatCount"
                                        name="recurrence[repeat_count]" min="1"
                                        oninput="this.setCustomValidity('')">
                                    <div class="invalid-feedback">Prosím, zadejte platný počet opakování.</div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Uložit událost</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const recurringCheckbox = document.getElementById('recurringCheckbox');
                const form = document.getElementById('eventForm');
                const recurrenceType = document.getElementById('recurrenceType');
                const recurringOptions = document.getElementById('recurringOptions');
                const recurrenceEndDate = document.getElementById('recurrenceEndDate');
                const repeatCount = document.getElementById('recurrenceRepeatCount');
                const repeatCountLabel = document.getElementById('recurrenceRepeatCountLabel');
                const reccurenceEndDateLabel = document.getElementById('recurrenceEndDateLabel');
                var recurrence = 0;
                recurrenceType.addEventListener('change', function() {
                    if (recurrenceType.value === 'daily' || recurrenceType.value === 'weekly') {
                        recurringOptions.style.display = 'block';
                        recurrence = 1;
                    } else {
                        recurringOptions.style.display = 'none';
                        recurrence = 0;
                    }
                });
                if (reccuringCheckbox.checked) {
                    recurrenceEndDate.style.display = 'none';
                    recurrenceEndDate.value = '';
                    repeatCount.style.display = 'block';
                    recurrenceEndDateLabel.style.display = 'none';
                    repeatCountLabel.style.display = 'block';

                } else {
                    recurrenceEndDateLabel.style.display = 'block';
                    repeatCount.value = '';
                    repeatCountLabel.style.display = 'none';
                    recurrenceEndDate.style.display = 'block';
                    repeatCount.style.display = 'none';
                }


                reccuringCheckbox.addEventListener('change', function(e) {
                    if (e.target.checked) {
                        recurrenceEndDateLabel.style.display = 'none';
                        repeatCountLabel.style.display = 'block';
                        recurrenceEndDate.style.display = 'none';
                        repeatCount.style.display = 'block';
                    } else {
                        recurrenceEndDateLabel.style.display = 'block';
                        repeatCountLabel.style.display = 'none';
                        recurrenceEndDate.style.display = 'block';
                        repeatCount.style.display = 'none';
                    }
                });

                form.addEventListener('submit', function(event) {
                    let isValid = true;

                    const startDate = document.getElementById('startDate');
                    const endDate = document.getElementById('endDate');
                    const startTime = document.getElementById('startTime');
                    const endTime = document.getElementById('endTime');
                    const startDateTime = `${startDate.value} ${startTime.value}`;
                    const endDateTime = `${endDate.value} ${endTime.value}`;
                    document.getElementById('isRecurring').value = recurrence;
                    document.getElementById('startDatetime').value = startDateTime;
                    document.getElementById('endDatetime').value = endDateTime;

                    endTime.setCustomValidity('');
                    if (endDate.value < startDate.value) {
                        endDate.setCustomValidity('Konec události nemůže být před začátkem.');
                        isValid = false;
                    } else {
                        endDate.setCustomValidity('');
                    }
                    if (endDate.value === startDate.value) {
                        if (startTime.value >= endTime.value) {
                            endTime.setCustomValidity('Konec události nemůže být před začátkem.');
                            isValid = false;
                        } else {
                            endTime.setCustomValidity('');
                        }
                    }
                    if (recurringCheckbox.checked) {
                        if (recurrenceEndDate.value && repeatCount.value) {
                            recurrenceEndDate.setCustomValidity(
                                'Nemůžete nastavit oba - konec opakování a počet opakování.');
                            repeatCount.setCustomValidity(
                                'Nemůžete nastavit oba - konec opakování a počet opakování.');
                            isValid = false;
                        } else {
                            recurrenceEndDate.setCustomValidity('');
                            repeatCount.setCustomValidity('');
                        }
                    }
                    if (!isValid) {
                        event.preventDefault();
                    }
                });
            });


            function editAchievement(id, name, description, image) {
                $('#editAchievementForm').attr('action', '/achievement/' + id);
                $('#name').val(name);
                $('#description').val(description);
            }
        </script>

    @endsection
