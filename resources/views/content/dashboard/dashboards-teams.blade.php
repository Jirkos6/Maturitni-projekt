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
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home"
                            aria-selected="true">Kalendář</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                            aria-selected="false">Přehled</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-messages" aria-controls="navs-pills-top-messages"
                            aria-selected="false">Členové</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-presence" aria-controls="navs-pills-top-presence"
                            aria-selected="false">Docházka</button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-achievements" aria-controls="navs-pills-top-achievements"
                            aria-selected="false">Odborky</button>
                    </li>
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
                                                                data-bs-toggle="dropdown"><i
                                                                    class="ri-more-2-line"></i></button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href=""><i
                                                                        class="ri-pencil-line me-1"></i>Editovat</a>
                                                                <a class="dropdown-item"
                                                                    href="/member/{{ $item->id }}"><i
                                                                        class="ri-delete-bin-6-line me-1"></i>Smazat</a>
                                                                <a class="dropdown-item"
                                                                    href="/members/{{ $item->id }}"><i
                                                                        class="ri-information-line me-1"></i>Zobrazit</a>
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
        <div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Přidání akce</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zavřít"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Title -->
                        <form action="{{ route('events.store') }}" method="POST" id="eventForm">
                            @csrf
                            <div class="row">
                                <div class="col mb-6 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="titleInput" name="title" class="form-control"
                                            placeholder="Napište název akce" required
                                            oninvalid="this.setCustomValidity('Prosím, zadejte název akce!')"
                                            oninput="this.setCustomValidity('')">
                                        <label for="titleInput">Název akce</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="row">
                                <div class="col mb-6 mt-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" id="descriptionInput" name="description"
                                            class="form-control" placeholder="Napište popis akce" required
                                            oninvalid="this.setCustomValidity('Prosím, zadejte popis akce!')"
                                            oninput="this.setCustomValidity('')">
                                        <label for="descriptionInput">Popis akce</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Start date and time -->
                            <div class="row g-4">
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" name="start_date" id="startDateInput"
                                            required
                                            oninvalid="this.setCustomValidity('Prosím, vyberte datum začátku akce!')"
                                            oninput="this.setCustomValidity('')">
                                        <label for="startDateInput">Začátek</label>
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="time" class="form-control" name="start_time" id="startTimeInput"
                                            required
                                            oninvalid="this.setCustomValidity('Prosím, vyberte čas začátku akce!')"
                                            oninput="this.setCustomValidity('')">
                                        <label for="startTimeInput">*Čas</label>
                                    </div>
                                </div>
                            </div>

                            <!-- End date and time -->
                            <div class="row g-4">
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="date" class="form-control" name="end_date" id="endDateInput"
                                            required
                                            oninvalid="this.setCustomValidity('Prosím, vyberte datum konce akce!')"
                                            oninput="this.setCustomValidity('')">
                                        <label for="endDateInput">Konec</label>
                                    </div>
                                </div>
                                <div class="col mb-2">
                                    <div class="form-floating form-floating-outline">
                                        <input type="time" class="form-control" name="end_time" id="endTimeInput"
                                            required oninvalid="this.setCustomValidity('Prosím, vyberte čas konce akce!')"
                                            oninput="this.setCustomValidity('')">
                                        <label for="endTimeInput">*Čas</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Recurring dropdown -->
                            <div class="mb-3">
                                <label for="recurringSelect" class="form-label">Opakování události</label>
                                <select class="form-select" name="recurrence" id="recurringSelect" required>
                                    <option value="none" selected>Neopakuje se</option>
                                    <option value="daily">Denně</option>
                                    <option value="weekly">Týdně</option>
                                </select>
                            </div>

                            <div id="repeatOptions" class="d-none">
                                <div class="row g-4">
                                    <div class="col mb-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" name="interval"
                                                id="repeatInterval" min="1"
                                                placeholder="Počet vynechaných dnů/týdnů mezi opakováním"
                                                oninvalid="this.setCustomValidity('Prosím, zadejte interval opakování!')"
                                                oninput="this.setCustomValidity('')">
                                            <label for="repeatInterval">Interval</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col mb-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="number" class="form-control" name="repeat_count"
                                                id="repeatCount" min="1" placeholder="Počet opakování"
                                                oninvalid="this.setCustomValidity('Prosím, zadejte počet opakování!')"
                                                oninput="this.setCustomValidity('')">
                                            <label for="repeatCount">Počet opakování</label>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="form-floating form-floating-outline">
                                            <input type="date" class="form-control" name="repeat_end_date"
                                                id="repeatEndDate"
                                                oninvalid="this.setCustomValidity('Prosím, zadejte konec opakování!')"
                                                oninput="this.setCustomValidity('')">
                                            <label for="repeatEndDate">Konec opakování</label>
                                            <input type="text" hidden name="team_id" id="team_id"
                                                value="{{ $id1 }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="previewResult" class="d-none">
                                <h5>Událost bude probíhat na těchto datech:</h5>
                                <ul id="previewDates"></ul>
                                <p id="otherDatesText"></p>
                            </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zavřít</button>
                        <button class="btn btn-primary" id="saveEventButton" onclick="submitForm()"
                            type="submit">Uložit akci</button>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <script>
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
