@extends('layouts.parent')

@section('content')
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
                    right: 'dayGridMonth,multiMonthYear,listYear'
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


            });

            calendar.render();
        });
    </script>

    <div class="container mx-auto px-4 py-10 lg:pl-72 mt-20">
        <div id="calendar"></div>
    </div>
@endsection
