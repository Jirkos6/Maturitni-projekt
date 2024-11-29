@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
    $sectionName = $data->first()->name;
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Oddíl ' . $sectionName)
<style>
    .modal-backdrop {
        display: none !important;
    }
</style>
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tippy.js/6.3.7/tippy.umd.min.js"></script>
    <link href="https://unpkg.com/tippy.js@6.3.7/dist/tippy.css" rel="stylesheet">
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
                eventMouseEnter: function(info) {
                    var startDate = new Date(info.event.start);
                    var endDate = info.event.end ? new Date(info.event.end) : null;
                    startDate.setHours(startDate.getHours() - 1);
                    if (endDate) endDate.setHours(endDate.getHours() - 1);

                    var formatTime = date => date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    var tooltipContent = `
                <strong>${info.event.title}</strong><br>
                Začátek: ${formatTime(startDate)}<br>
                Konec: ${endDate ? formatTime(endDate) : ''}<br>
                Popis: ${info.event.extendedProps.description || ''}
            `;
                    tippy(info.el, {
                        content: tooltipContent,
                        allowHTML: true,
                        placement: 'top',
                        trigger: 'mouseenter',
                        hideOnClick: false,
                        arrow: true,
                    });
                },
                eventMouseLeave: function(info) {
                    if (info.el._tooltipInstance) {
                        info.el._tooltipInstance.destroy();
                        delete info.el._tooltipInstance;
                    }
                },
            });

            calendar.render();
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

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#smallModal">
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

                                        <!-- Image Section below title -->
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
                                    <p>{{ $event->start_date }}</p>

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
                                                <td>{{ $event->attendances_count }}</td>
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
                                <div class="modal fade" id="editAchievementModal" tabindex="-1"
                                    aria-labelledby="editAchievementModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editAchievementModalLabel">Upravit odborku
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="editAchievementForm" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Název odborky</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" required placeholder="">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Popis odborky</label>
                                                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Obrázek odborky</label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image">

                                                    </div>

                                                    <div class="mb-3">
                                                        <button type="submit" class="btn btn-primary">Upravit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="addAchievementModal" tabindex="-1"
                                    aria-labelledby="addAchievementModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addAchievementModalLabel">Přidat Odborku</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Zavřít"></button>
                                            </div>
                                            <form action="{{ route('achievements.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">Název Odborky</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" required>
                                                    </div>


                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Popis Odborky</label>
                                                        <textarea class="form-control" id="description" name="description"></textarea>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Obrázek</label>
                                                        <input type="file" class="form-control" id="image"
                                                            name="image" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Zavřít</button>
                                                    <button type="submit" class="btn btn-primary">Přidat Odborku</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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

                            <div class="mb-3">
                                <label for="name" class="form-label">Jméno</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="mb-3">
                                <label for="surname" class="form-label">Příjmení</label>
                                <input type="text" class="form-control" id="surname" name="surname" required>
                            </div>

                            <div class="mb-3">
                                <label for="age" class="form-label">Věk</label>
                                <input type="number" class="form-control" id="age" name="age">
                            </div>

                            <div class="mb-3">
                                <label for="shirt_size_id" class="form-label">Velikost trika</label>
                                <select class="form-select" id="shirt_size_id" name="shirt_size_id">
                                    <option value="">Vyberte velikost</option>
                                    @foreach ($shirt_sizes as $size)
                                        <option value="{{ $size->id }}">{{ $size->size }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="nickname" class="form-label">Přezdívka</label>
                                <input type="text" class="form-control" id="nickname" name="nickname">
                            </div>

                            <div class="mb-3">
                                <label for="telephone" class="form-label">Telefon</label>
                                <input type="text" class="form-control" id="telephone" name="telephone">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>

                            <div class="mb-3">
                                <label for="mother_name" class="form-label">Jméno matky</label>
                                <input type="text" class="form-control" id="mother_name" name="mother_name">
                            </div>

                            <div class="mb-3">
                                <label for="mother_surname" class="form-label">Příjmení matky</label>
                                <input type="text" class="form-control" id="mother_surname" name="mother_surname">
                            </div>

                            <div class="mb-3">
                                <label for="mother_telephone" class="form-label">Telefon matky</label>
                                <input type="text" class="form-control" id="mother_telephone"
                                    name="mother_telephone">
                            </div>

                            <div class="mb-3">
                                <label for="mother_email" class="form-label">Email matky</label>
                                <input type="email" class="form-control" id="mother_email" name="mother_email">
                            </div>

                            <div class="mb-3">
                                <label for="father_name" class="form-label">Jméno otce</label>
                                <input type="text" class="form-control" id="father_name" name="father_name">
                            </div>

                            <div class="mb-3">
                                <label for="father_surname" class="form-label">Příjmení otce</label>
                                <input type="text" class="form-control" id="father_surname" name="father_surname">
                            </div>

                            <div class="mb-3">
                                <label for="father_telephone" class="form-label">Telefon otce</label>
                                <input type="text" class="form-control" id="father_telephone"
                                    name="father_telephone">
                            </div>

                            <div class="mb-3">
                                <label for="father_email" class="form-label">Email otce</label>
                                <input type="email" class="form-control" id="father_email" name="father_email">
                                <input type="text" value="{{ $id1 }}" id="team_id" name="team_id" hidden>
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
                const hash = window.location.hash;
                if (hash) {
                    const targetTab = document.querySelector(`button[data-bs-target="${hash}"]`);
                    if (targetTab) {
                        const tab = new bootstrap.Tab(targetTab);
                        tab.show();
                    }
                }
            });
            const recurringSelect = document.getElementById('recurringSelect');
            const repeatOptions = document.getElementById('repeatOptions');
            const repeatCount = document.getElementById('repeatCount');
            const repeatEndDate = document.getElementById('repeatEndDate');
            const dateList = document.getElementById('previewDates');
            const startDateInput = document.getElementById('startDateInput');
            const endDateInput = document.getElementById('endDateInput');
            const startTimeInput = document.getElementById('startTimeInput');
            const endTimeInput = document.getElementById('endTimeInput');
            const repeatInterval = document.getElementById('repeatInterval');
            const repeatCheckbox = document.getElementById('repeatCheckbox');


            function validateDates() {
                const startDate = new Date(startDateInput.value);
                const endDate = new Date(endDateInput.value);
                const startTime = new Date('1970-01-01T' + startTimeInput.value);
                const endTime = new Date('1970-01-01T' + endTimeInput.value);

                if (endDate < startDate) {
                    alert('Konec události nemůže být před začátkem.');
                    endDateInput.value = '';
                }

                if (endDate.getTime() === startDate.getTime() && startTime > endTime) {
                    alert('Konec události nemůže být před začátkem.');
                    endTimeInput.value = '';
                }
            }

            function calculateRecurrence() {
                const startDate = new Date(startDateInput.value);
                const intervalValue = parseInt(repeatInterval.value);
                const repeatTimes = parseInt(repeatCount.value);
                const endRecurrence = new Date(repeatEndDate.value);

                let recurrenceDates = [];
                let currentDate = new Date(startDate);
                for (let i = 0; i < repeatTimes; i++) {
                    recurrenceDates.push(new Date(currentDate));
                    currentDate.setDate(currentDate.getDate() + intervalValue);
                }
                dateList.innerHTML = recurrenceDates.slice(0, 6).map(date => `<li>${date.toDateString()}</li>`).join('');
            }
            recurringSelect.addEventListener('change', function() {
                repeatOptions.classList.add('d-none');
                if (this.value === 'none') {
                    return;
                }
                repeatOptions.classList.remove('d-none');
            });

            repeatCount.addEventListener('input', calculateRecurrence);
            repeatEndDate.addEventListener('input', calculateRecurrence);
            startDateInput.addEventListener('input', validateDates);
            endDateInput.addEventListener('input', validateDates);
            startTimeInput.addEventListener('input', validateDates);
            endTimeInput.addEventListener('input', validateDates);
            repeatInterval.addEventListener('input', calculateRecurrence);

            function editAchievement(id, name, description, image) {
                $('#editAchievementForm').attr('action', '/achievement/' + id);
                $('#name').val(name);
                $('#description').val(description);


            }
        </script>

    @endsection
