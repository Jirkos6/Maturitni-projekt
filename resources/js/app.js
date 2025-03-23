import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import multiMonthPlugin from '@fullcalendar/multimonth';
import rrulePlugin from '@fullcalendar/rrule';
window.Calendar = Calendar;
window.multiMonthPlugin = multiMonthPlugin;
window.rrulePlugin = rrulePlugin;

import interaction from '@fullcalendar/interaction';
window.interaction = interaction;

import dayGridPlugin from '@fullcalendar/daygrid';
window.dayGridPlugin = dayGridPlugin;

import timeGridPlugin from '@fullcalendar/timegrid';
window.timeGridPlugin = timeGridPlugin;

import listPlugin from '@fullcalendar/list';
window.listPlugin = listPlugin;
import 'flowbite';
import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);
