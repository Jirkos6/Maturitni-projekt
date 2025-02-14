@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
    $sectionName = $data->first()->name;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Oddíl ' . $sectionName)
@section('content')
    @vite('resources/js/app.js')
    @use('App\Models\Teams')
    @use('App\Models\User')
    @use('App\Models\Achievements')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>


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
                    <a href="#navs-pills-top-parents">
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-pills-top-parents" aria-controls="navs-pills-top-parents"
                                aria-selected="false">Uživatelé</button>
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
                                            <h5 class="card-title text-primary mb-3">{{ $nextevent->title }}</h5>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addMembersModal">
                            Přidat více členů
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
                                                    <td>{{ $item->attendance_percentage }}%</td>


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
                                                                    <i class="ri-information-line "></i> Zobrazit
                                                                </a>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#assignAchievementModal"
                                                                    data-member-id="{{ $item->id }}">
                                                                    <i class="ri-edit-line"></i> Přidělit odborky
                                                                </a>
                                                                <a class="">
                                                                    <form action="/member/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete smazat tohoto člena?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-delete-bin-6-line"></i> Smazat
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
                    <div class="tab-pane fade h-100" id="navs-pills-top-parents" role="tabpanel">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editParentModal">
                            Přidat řodiče
                        </button>
                        @if (null !== User::where('role', 'parent')->count())
                            <h3 class="text-center text-primary mb-10">Počet uživatelů
                                ({{ User::where('role', 'parent')->count() }})</h3>
                            <div class="card">
                                <h5 class="card-header">Uživatelé</h5>
                                <div class="table-responsive text-nowrap">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Jméno</th>
                                                <th>Role</th>
                                                <th>Děti</th>
                                                <th>Email</th>
                                                <th>Akce</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($parents as $item)
                                                <tr>

                                                    <td><a href="/parents/{{ $item->id }}">
                                                            @if (Auth::user()->email != null && Auth::user()->email == $item->email)
                                                                Vy -> <i style="color: #099E09;"
                                                                    class="ri-shield-user-fill"></i><span>
                                                                    {{ $item->parent_name }}
                                                                    {{ $item->parent_surname }}
                                                                </span>
                                                            @else
                                                                <i class="ri-user-fill"></i><span>
                                                                    {{ $item->parent_name }}
                                                                    {{ $item->parent_surname }}
                                                                </span>
                                                            @endif


                                                    </td>
                                                    </a>
                                                    <td>
                                                        @if (null != $item->role && $item->role == 'parent')
                                                            Rodič
                                                        @elseif (null != $item->role && $item->role == 'admin')
                                                            Administrátor
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (null !== $item->member_names)
                                                            {{ $item->member_names }}
                                                        @else
                                                            Žádné
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->email }}</td>


                                                    <td>
                                                        <div class="dropdown">
                                                            <button type="button"
                                                                class="btn p-0 dropdown-toggle hide-arrow"
                                                                data-bs-toggle="dropdown">
                                                                <i class="ri-more-2-line"></i>
                                                            </button>
                                                            <div class="dropdown-menu">


                                                                <a class="dropdown-item"
                                                                    href="/users/{{ $item->id }}">
                                                                    <i class="ri-information-line "></i> Zobrazit
                                                                </a>
                                                                <a class="dropdown-item" href="#"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#assignMemberModal"
                                                                    data-user-id="{{ $item->id }}">
                                                                    <i class="ri-edit-line"></i> Přidělit děti
                                                                </a>
                                                                <a class="">
                                                                    <form action="/user/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete smazat tohoto uživatele?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-delete-bin-6-line"></i> Smazat
                                                                        </button>
                                                                    </form>
                                                                </a>
                                                                <a class="">
                                                                    <form action="/users-role/{{ $item->id }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('Opravdu chcete změnit roli?');">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="ri-user-settings-line"></i>
                                                                            @if (null != $item->role && $item->role == 'parent')
                                                                                Nastavit roli Administrátor
                                                                            @elseif (null != $item->role && $item->role == 'admin')
                                                                                Nastavit roli rodič
                                                                            @endif
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
                            <h3 class="text-center text-primary mb-4">Ještě si nepřidal žádného uživatele!</h3>
                        @endif

                    </div>
                    <div class="tab-pane fade h-100 overflow-x-scroll" id="navs-pills-top-presence" role="tabpanel">
                        @if ($attendance->first())
                            <button class="btn btn-outline-primary toggle-table mb-3" onclick="toggleTable()">
                                <i class="ri-arrow-down-s-line"></i> Úprava docházky
                            </button>

                            <div class="presence-cards row mb-4" id="presence-cards">

                                @php
                                    $groupedEvents = $attendance->groupBy(function ($event) {
                                        return \Carbon\Carbon::parse($event->start_date)->format('d.m.Y');
                                    });
                                @endphp
                                @foreach ($groupedEvents as $date => $events)
                                    <div class="col-md-12 mb-4">
                                        <div class="card shadow-sm">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <span class="fw-bold">{{ $date }}</span>
                                                <button class="btn btn-outline-primary toggle-events"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#events-{{ Str::slug($date) }}" aria-expanded="false"
                                                    aria-controls="events-{{ Str::slug($date) }}">
                                                    <i class="ri-arrow-down-s-line"></i>
                                                </button>
                                            </div>
                                            <div id="events-{{ Str::slug($date) }}" class="collapse">
                                                <div class="card-body">
                                                    @foreach ($events as $event)
                                                        <div class="event-card mb-3 p-3 border rounded">
                                                            <a href="/events/{{ $event->id }}">
                                                                <h5 class="card-title">{{ $event->title }}</h5>
                                                            </a>
                                                            <p class="card-text text-muted">
                                                                {{ $event->description }} </br>
                                                                <i class="ri-time-line"></i>
                                                                {{ \Carbon\Carbon::parse($event->start_date)->format('H:i') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($event->end_date)->format('H:i') }}
                                                            </p>
                                                            <table
                                                                class="table table-responsive table-bordered table-sm presence-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Stav</th>
                                                                        <th>Počet</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="text-success"> Přítomno
                                                                        </td>
                                                                        <td>{{ $event->present_count }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-warning"> Omluveno
                                                                        </td>
                                                                        <td>{{ $event->excused_count }}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-danger"> Neomluveno
                                                                        </td>
                                                                        <td>{{ $event->unexcused_count }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm d-none" id="attendance-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                @foreach ($events1 as $event)
                                                    <th class="small">
                                                        {{ \Carbon\Carbon::parse($event->start_date)->format('d.m.Y') }}
                                                    </th>
                                                @endforeach

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($members as $member)
                                                <tr>
                                                    <td><a href="/members/{{ $member->id }}">{{ $member->name }}
                                                            {{ $member->surname }}</a></td>
                                                    @foreach ($events1 as $event)
                                                        <td>
                                                            <select class="form-select attendance-status"
                                                                data-member-id="{{ $member->id }}"
                                                                data-event-id="{{ $event->id }}"
                                                                style="font-size: 12px; padding: 0.2rem 0.4rem;">
                                                                <option value="present"
                                                                    {{ $member->getAttendanceStatus($event->id) == 'present' ? 'selected' : '' }}>
                                                                    <i class="ri-checkbox-circle-line"
                                                                        style="color: green;"></i> Přítomen
                                                                </option>
                                                                <option value="excused"
                                                                    {{ $member->getAttendanceStatus($event->id) == 'excused' ? 'selected' : '' }}>
                                                                    <i class="ri-checkbox-circle-fill"
                                                                        style="color: orange;"></i> Omlouven
                                                                </option>
                                                                <option value="unexcused"
                                                                    {{ $member->getAttendanceStatus($event->id) == 'unexcused' ? 'selected' : '' }}>
                                                                    <i class="ri-close-circle-line"
                                                                        style="color: red;"></i>
                                                                    Neomluven
                                                                </option>
                                                            </select>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h3 class="text-center text-primary mb-4">Ještě si nepřidal žádné akce/členy!</h3>
                        @endif
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
                                        <img class="rounded-md w-full h-auto object-fill"
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
        <div class="modal-dialog modal-xl">
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
                                    <option value="" disabled>Vyberte velikost</option>
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
                                <input type="text" class="form-control" id="mother_surname" name="mother_surname">
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
                                <input type="text" class="form-control" id="father_surname" name="father_surname">
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
                                <input type="text" value="{{ $id1 }}" id="team_id" name="team_id" hidden>
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
                            <select class="form-select" id="recurrenceType" name="recurrence[frequency]" value="none">
                                <option value="">Neopakující se</option>
                                <option value="daily">Denně</option>
                                <option value="weekly">Týdně</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="teamSelect" class="form-label">Vyberte týmy (volitelné)</label>
                            <select class="js-multiple form-select" id="teamSelect" name="team_ids[]" multiple>
                                @foreach ($teams as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="sendMailCheckbox" class="checkbox">Zaslat email všem rodičům?</label>
                            <input type="checkbox" id="sendMailCheckbox" name="sendMailCheckbox"></input>
                        </div>

                        <div id="recurringOptions" class="mt-3" style="display: none;">
                            <div class="mb-3">
                                <label for="interval" class="form-label">Interval opakování (v dnech)</label>
                                <input type="number" class="form-control" id="interval" name="recurrence[interval]"
                                    min="0" oninput="this.setCustomValidity('')">
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
                                <div class="invalid-feedback">Prosím, vyberte platné datum pro konec opakování.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="recurrenceRepeatCount" class="form-label"
                                    id="recurrenceRepeatCountLabel">Počet opakování</label>
                                <input type="number" class="form-control" id="recurrenceRepeatCount"
                                    name="recurrence[repeat_count]" min="1" oninput="this.setCustomValidity('')">
                                <div class="invalid-feedback">Prosím, zadejte platný počet opakování.</div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">Uložit událost</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <div class="modal-body">
                    <h5 id="liveEditValue" class="text-center mb-4"></h5>
                    <form id="addMembersForm" action="{{ route('member.store.multiple') }}" method="POST">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Jméno</th>
                                        <th>Příjmení</th>
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
                                            <input type="text" value="{{ $id1 }}" id="team_id"
                                                name="team_id" hidden>
                                            <td><input type="text" name="members[{{ $i }}][name]"
                                                    class="form-control" required></td>
                                            <td><input type="text" name="members[{{ $i }}][surname]"
                                                    class="form-control" required></td>
                                            <td><input type="text" name="members[{{ $i }}][nickname]"
                                                    class="form-control"></td>
                                            <td><input type="number" name="members[{{ $i }}][age]"
                                                    class="form-control"></td>
                                            <td><input type="number" name="members[{{ $i }}][telephone]"
                                                    class="form-control"></td>
                                            <td><input type="email" name="members[{{ $i }}][email]"
                                                    class="form-control"></td>

                                            <td>
                                                <select class="form-select"
                                                    name="members[{{ $i }}][shirt_size_id]">
                                                    <option value="">Vyberte velikost</option>
                                                    @foreach ($shirt_sizes as $size)
                                                        <option value="{{ $size->id }}">{{ $size->size }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="text" name="members[{{ $i }}][mother_name]"
                                                    class="form-control"></td>
                                            <td><input type="text" name="members[{{ $i }}][mother_surname]"
                                                    class="form-control"></td>
                                            <td><input type="number"
                                                    name="members[{{ $i }}][mother_telephone]"
                                                    class="form-control"></td>
                                            <td><input type="email" name="members[{{ $i }}][mother_email]"
                                                    class="form-control"></td>
                                            <td><input type="text" name="members[{{ $i }}][father_name]"
                                                    class="form-control"></td>
                                            <td><input type="text" name="members[{{ $i }}][father_surname]"
                                                    class="form-control"></td>
                                            <td><input type="number"
                                                    name="members[{{ $i }}][father_telephone]"
                                                    class="form-control"></td>
                                            <td><input type="email" name="members[{{ $i }}][father_email]"
                                                    class="form-control"></td>
                                            <td><button type="button" class="btn btn-danger remove-row">Odstranit
                                                    řádek</button></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        <button type="button" id="addRowButton" class="btn btn-success mt-3">Přidat další
                            řádek</button>
                        <div class="modal-footer mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" class="btn btn-primary">Vytvořit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAchievementModalLabel">Upravit odborku
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAchievementForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Název odborky</label>
                            <input type="text" class="form-control" id="Lpname" name="name" value=""
                                required placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Popis odborky</label>
                            <textarea class="form-control" id="Lpdescription" name="description" value="" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Obrázek odborky</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <image id="Lpimage" src="" class="image-responsive">
                            <div class="mt-5">
                                <button type="submit" class="btn btn-primary">Upravit</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAchievementModal">Přidat Odborky</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                </div>
                <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Název Odborky</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Popis Odborky</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Obrázek</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                        <button type="submit" class="btn btn-primary">Přidat Odborku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="assignAchievementModal" tabindex="-1" aria-labelledby="assignAchievementModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignAchievementModal">Přidat odborky</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAchievementForm">
                        <div class="mb-3">
                            <label for="achievementSelect" class="form-label">Vyberte odborky</label>
                            <select class="js-example-basic-multiple" id="achievementSelect" name="achievement_id[]"
                                multiple="multiple" required>
                                @foreach ($achievements as $achievement)
                                    <option value="{{ $achievement->id }}">{{ $achievement->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="memberId" name="member_id" value="">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Přidat</button>
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
                <div class="modal-header">
                    <h5 class="modal-title" id="assignMemberTitle">Přidělit členy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignMemberForm">
                        <div class="mb-3">
                            <label for="memberSelect" class="form-label">Vyberte členy</label>
                            <select class="js-basic-multiple" id="memberSelect" name="member_id[]" multiple="multiple"
                                required>
                                @foreach ($children as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} {{ $item->surname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" id="userId" name="user_id" value="">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Přidat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editParentModal" tabindex="-1" aria-labelledby="editParentModal" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editParentModalLabel">Přidat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.store') }}" method="POST" id="createParentForm">
                        @csrf
                        @method('POST')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Jméno</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="surname" class="form-label">Příjmení</label>
                                <input type="text" class="form-control" id="surname" name="surname">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="emailCheckbox" class="form-label">Zaslat email s heslem? </label>
                                <input type="checkbox" id="emailCheckbox" name="emailCheckbox">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                            <button type="submit" class="btn btn-primary">Uložit</button>
                        </div>
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
            const hash = window.location.hash;
            if (hash) {
                const targetTab = document.querySelector(`button[data-bs-target="${hash}"]`);
                if (targetTab) {
                    const tab = new bootstrap.Tab(targetTab);
                    tab.show();
                }
            }


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
            let memberIndex = 1;
            const membersTableBody = document.getElementById("membersTableBody");
            const addRowButton = document.getElementById("addRowButton");
            const liveEditValue = document.getElementById("liveEditValue");
            addRowButton.addEventListener("click", () => {
                const newRow = document.createElement("tr");
                newRow.innerHTML = `
        <td><input type="text" name="members[${memberIndex}][name]" class="form-control editable" required></td>
        <td><input type="text" name="members[${memberIndex}][surname]" class="form-control editable" required></td>
        <td><input type="text" name="members[${memberIndex}][nickname]" class="form-control editable"></td>
                                   <td><input type="number" name="members[${memberIndex}][age]"
                                                            class="form-control"></td>
        <td><input type="number" name="members[${memberIndex}][telephone]" class="form-control editable"></td>
        <td><input type="email" name="members[${memberIndex}][email]" class="form-control editable"></td>
        <td>
            <select class="form-select editable" name="members[${memberIndex}][shirt_size_id]">
                <option value="">Vyberte velikost</option>
                @foreach ($shirt_sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->size }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="text" name="members[${memberIndex}][mother_name]" class="form-control editable"></td>
        <td><input type="text" name="members[${memberIndex}][mother_surname]" class="form-control editable"></td>
        <td><input type="number" name="members[${memberIndex}][mother_telephone]" class="form-control editable"></td>
        <td><input type="email" name="members[${memberIndex}][mother_email]" class="form-control editable"></td>
        <td><input type="text" name="members[${memberIndex}][father_name]" class="form-control editable"></td>
        <td><input type="text" name="members[${memberIndex}][father_surname]" class="form-control editable"></td>
        <td><input type="number" name="members[${memberIndex}][father_telephone]" class="form-control editable"></td>
        <td><input type="email" name="members[${memberIndex}][father_email]" class="form-control editable"></td>
                                <td><button type="button" class="btn btn-danger remove-row">Odstranit
                                                        řádek</button></td>
    `;
                membersTableBody.appendChild(newRow);
                memberIndex++;
            });
            membersTableBody.addEventListener("click", (event) => {
                if (event.target.classList.contains("remove-row")) {
                    const row = event.target.closest("tr");
                    row.remove();
                }
            });
            document.addEventListener("input", (event) => {
                const target = event.target;
                if (target.tagName === "INPUT" || target.tagName === "SELECT") {
                    if (target.tagName === "SELECT") {
                        liveEditValue.textContent = "Vybráno: " + target.options[target.selectedIndex]
                            .text || "Upravovaný text...";
                    } else {
                        liveEditValue.textContent = "Text: " + target.value || "Upravovaný text...";
                    }
                }
            });
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2({
                    width: '300px',
                    dropdownParent: $("#assignAchievementModal")
                });
                $('.js-basic-multiple').select2({
                    width: '300px',
                    dropdownParent: $("#assignMemberModal")
                });
                $('.js-multiple').select2({
                    width: '300px',
                    dropdownParent: $("#eventModal")
                });
                $('#assignAchievementModal').on('show.bs.modal', function(e) {
                    let button = $(e.relatedTarget);
                    let memberId = button.data('member-id');
                    $('#memberId').val(memberId);
                });

                $('#assignMemberModal').on('show.bs.modal', function(e) {
                    let button = $(e.relatedTarget);
                    let userId = button.data('user-id');
                    $('#userId').val(userId);
                });
                $('#addAchievementForm').on('submit', function(e) {
                    e.preventDefault();

                    let memberId = $('#memberId').val();
                    let achievementIds = $('#achievementSelect').val();

                    if (!achievementIds || achievementIds.length === 0) {
                        alert('Vyberte alespoň jednu odborku.');
                        return;
                    }

                    $.ajax({
                        url: '/member-achievements',
                        method: 'POST',
                        data: {
                            member_id: memberId,
                            achievement_id: achievementIds,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Odborky byly úspěšně přidány.');
                            $('#assignAchievementModal').modal('hide');
                            $('#addAchievementForm')[0].reset();
                            $('.js-example-basic-multiple').val(null).trigger('change');
                        },
                        error: function(xhr) {
                            alert('Došlo k chybě. Zkuste to prosím znovu.');
                            console.error(xhr.responseText);
                        }
                    });
                });
                $('#assignMemberForm').on('submit', function(e) {
                    e.preventDefault();

                    let userId = $('#userId').val();
                    let memberIds = $('#memberSelect').val();

                    if (!memberIds || memberIds.length === 0) {
                        alert('Vyberte alespoň jednoho člena.');
                        return;
                    }

                    $.ajax({
                        url: '/user-members',
                        method: 'POST',
                        data: {
                            user_id: userId,
                            member_id: memberIds,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            alert('Členi byly úspěšně přiřazeni.');
                            $('#assignMemberModal').modal('hide');
                            $('#assignMemberForm')[0].reset();
                            $('.js-basic-multiple').val(null).trigger('change');
                        },
                        error: function(xhr) {
                            alert('Došlo k chybě. Zkuste to prosím znovu.');
                            console.error(xhr.responseText);
                        }
                    });
                });
            });


        });






        document.querySelectorAll('.toggle-events').forEach(button => {
            button.addEventListener('click', function() {
                const eventId = this.getAttribute('data-event-id');
                const eventDetails = document.getElementById('event-' + eventId);
                if (eventDetails.style.display === 'none') {
                    eventDetails.style.display = 'block';
                    this.textContent = '↑';
                } else {
                    eventDetails.style.display = 'none';
                    this.textContent = '↓';
                }
            });
        });

        function editAchievement(id, name, description, image) {
            $('#editAchievementForm').attr('action', '/achievement/' + id);

            $('#Lpname').val(name);
            $('#Lpdescription').val(description);
            $('#Lpimage').attr('src', image);


        }

        function toggleTable() {

            const table = document.getElementById('attendance-table');
            table.classList.toggle('d-none');
            const presenceCards = $('#presence-cards');
            if (presenceCards.css('display') === 'none') {
                presenceCards.css('display', 'block');
            } else {
                presenceCards.css('display', 'none');
            }
        }
        document.querySelectorAll('.attendance-status').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const memberId = this.getAttribute('data-member-id');
                const eventId = this.getAttribute('data-event-id');
                const status = this.value;
                fetch('/update-attendance', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({
                            member_id: memberId,
                            event_id: eventId,
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Úspěšně změněno');
                        } else {
                            console.error('Nastala chyba při aktualizaci');
                        }
                    })
                    .catch(error => {
                        console.error('Chyba:', error);
                    });
            });
        });
    </script>

@endsection
