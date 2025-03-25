import $ from 'jquery';
window.$ = $;
import select2 from 'select2';
select2();
import '/node_modules/select2/dist/css/select2.css';
import '/resources/css/dashboard.css';
$(document).ready(function () {
  const form = document.getElementById('eventForm');
  const repeatCountContainer = document.getElementById('repeatCountContainer');
  const recurrenceEndDateContainer = document.getElementById('recurrenceEndDateContainer');
  const dateOutputContainer = document.getElementById('dateOutputContainer');
  const datesRemovedOutputContainer = document.getElementById('datesRemovedOutputContainer');

  $('.js-example-basic-multiple').select2({
    width: '300px',
    dropdownParent: $('#memberAssignAchievement')
  });
  $('.js-basic-multiple').select2({
    width: '300px',
    dropdownParent: $('#userAssignMember')
  });
  $('.js-multiple').select2({
    width: '300px',
    dropdownParent: $('#eventAssignTeam')
  });
  $('.delete-event-team-select').select2({
    dropdownParent: $('#bulkEditForm'),
    theme: 'bootstrap-5'
  });
  $('.team-select').select2({
    dropdownParent: $('#eventForm'),
    theme: 'bootstrap-5'
  });
  $('#assignAchievementModal').on('show.bs.modal', function (e) {
    let button = $(e.relatedTarget);
    let memberId = button.data('member-id');
    $('#memberId').val(memberId);
  });

  $('#assignMemberModal').on('show.bs.modal', function (e) {
    let button = $(e.relatedTarget);
    let userId = button.data('user-id');
    $('#userId').val(userId);
  });

  $('#reccuringCheckbox').on('change', function (e) {
    if (this.checked) {
      $('#recurrenceEndDate').val('');
    } else {
      $('#recurrenceRepeatCount').val('');
    }
    repeatCountContainer.classList.toggle('d-none');
    recurrenceEndDateContainer.classList.toggle('d-none');
    resetDateDisplays();
  });

  function getInputValue(selector) {
    let value = $(selector).val()?.trim();
    return value === '' || value === undefined ? null : value;
  }

  function setInputValue(selector, inputValue) {
    $(selector).val(inputValue);
  }

  function resetDateDisplays() {
    $('#dateOutput').empty();
    $('#datesRemovedOutput').empty();
    dateOutputContainer.classList.add('d-none');
    datesRemovedOutputContainer.classList.add('d-none');
  }

  $('#recurrenceEndDate, #recurrenceRepeatCount, #recurrenceType, #interval, #startDate').on('change', function () {
    let startDate = getInputValue('#startDate');
    let recurrenceType = getInputValue('#recurrenceType');
    let interval = getInputValue('#interval');
    let endDate = getInputValue('#recurrenceEndDate');
    let repeatCount = getInputValue('#recurrenceRepeatCount');
    if (!startDate || !recurrenceType || !interval) {
      resetDateDisplays();
      return;
    }
    if (endDate || repeatCount) {
      generateRecurrenceDates(
        startDate,
        recurrenceType,
        Number(interval),
        endDate,
        repeatCount ? Number(repeatCount) : null
      );
    } else {
      resetDateDisplays();
    }
  });

  $('#recurrenceType').on('change', function () {
    let recurrenceType = getInputValue('#recurrenceType');
    const recurringOptions = document.getElementById('recurringOptions');
    if (recurrenceType === 'daily' || recurrenceType === 'weekly' || recurrenceType === 'monthly') {
      recurringOptions.style.display = 'block';
    } else {
      recurringOptions.style.display = 'none';
      setInputValue('#interval', '');
      setInputValue('#recurrenceEndDate', '');
      setInputValue('#recurrenceRepeatCount', '');
      $('#reccuringCheckbox').prop('checked', false);
      resetDateDisplays();
    }
  });

  $('#addAchievementForm').on('submit', function (e) {
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
        achievement_id: achievementIds
      },
      headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
      },
      success: function (response) {
        alert('Odborky byly úspěšně přidány.');
        $('#assignAchievementModal').modal('hide');
        $('#addAchievementForm')[0].reset();
        $('.js-example-basic-multiple').val(null).trigger('change');
      },
      error: function (xhr) {
        alert('Došlo k chybě. Zkuste to prosím znovu.');
        console.error(xhr.responseText);
      }
    });
  });

  $('#assignMemberForm').on('submit', function (e) {
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
        member_id: memberIds
      },
      headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
      },
      success: function (response) {
        alert('Členi byly úspěšně přiřazeni.');
        $('#assignMemberModal').modal('hide');
        $('#assignMemberForm')[0].reset();
        $('.js-basic-multiple').val(null).trigger('change');
      },
      error: function (xhr) {
        alert('Došlo k chybě. Zkuste to prosím znovu.');
        console.error(xhr.responseText);
      }
    });
  });

  const liveEditValue = document.getElementById('liveEditValue');
  const memberSearch = document.getElementById('member-search');
  if (memberSearch) {
    memberSearch.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase();
      document.querySelectorAll('.member-item').forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase();
        item.style.display = name.includes(searchTerm) ? '' : 'none';
      });
    });
  }

  const eventSearch = document.getElementById('event-search');
  if (eventSearch) {
    eventSearch.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase();
      document.querySelectorAll('.event-item').forEach(item => {
        const title = item.getAttribute('data-title').toLowerCase();
        const start = item.getAttribute('data-start').toLowerCase();
        const end = item.getAttribute('data-end').toLowerCase();
        item.style.display =
          title.includes(searchTerm) || start.includes(searchTerm) || end.includes(searchTerm) ? '' : 'none';
      });
    });
  }

  const userSearch = document.getElementById('user-search');
  if (userSearch) {
    userSearch.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase();
      document.querySelectorAll('.user-item').forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase();
        item.style.display = name.includes(searchTerm) ? '' : 'none';
      });
    });
  }

  const attendanceSearch = document.getElementById('attendance-search');
  if (attendanceSearch) {
    attendanceSearch.addEventListener('input', function () {
      const searchTerm = this.value.toLowerCase();
      const dateCards = document.querySelectorAll('.attendance-date-card');
      dateCards.forEach(dateCard => {
        const eventItems = (dateCard = document.querySelectorAll('.attendance-event-item'));
        let hasVisibleEvents = false;
        eventItems.forEach(item => {
          const eventTitle = item.getAttribute('data-event-title').toLowerCase();
          const date = dateCard.getAttribute('data-date').toLowerCase();
          const isMatch = eventTitle.includes(searchTerm) || date.includes(searchTerm);
          item.style.display = isMatch ? '' : 'none';
          if (isMatch) hasVisibleEvents = true;
          if (isMatch) {
            const collapseElement = item.closest('.collapse');
            if (collapseElement) {
              new bootstrap.Collapse(collapseElement, { toggle: false }).show();
            }
          }
        });
        dateCard.style.display = hasVisibleEvents ? '' : 'none';
      });
    });
  }

  const addRowButton = document.getElementById('addRowButton');
  if (addRowButton) {
    addRowButton.addEventListener('click', function () {
      const tbody = document.getElementById('membersTableBody');
      const rows = tbody.getElementsByTagName('tr');
      const newIndex = rows.length;

      const newRow = rows[0].cloneNode(true);
      const inputs = newRow.querySelectorAll('input, select');
      inputs.forEach(input => {
        const name = input.getAttribute('name');
        if (name) {
          input.setAttribute('name', name.replace(/\[\d+\]/, `[${newIndex}]`));
          if (input.type !== 'hidden') {
            input.value = '';
          }
        }
      });

      const parentTableBody = document.getElementById('parentTableBody');
      if (parentTableBody) {
        const parentRow = parentTableBody.querySelector('tr').cloneNode(true);
        parentRow.setAttribute('data-index', newIndex);
        parentRow.querySelector('.member-name-display').textContent = `Člen ${newIndex + 1}`;
        const parentInputs = parentRow.querySelectorAll('input');
        parentInputs.forEach(input => {
          const name = input.getAttribute('name');
          if (name) {
            input.setAttribute('name', name.replace(/\[\d+\]/, `[${newIndex}]`));
            input.value = '';
          }
        });
        parentTableBody.appendChild(parentRow);
      }
      tbody.appendChild(newRow);
    });
  }

  document.addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row') || e.target.closest('.remove-row')) {
      const row = e.target.closest('tr');
      const tbody = row.parentNode;
      if (tbody.children.length > 1) {
        const index = Array.from(tbody.children).indexOf(row);
        row.remove();
        const parentTableBody = document.getElementById('parentTableBody');
        if (parentTableBody) {
          const parentRow = parentTableBody.querySelector(`tr[data-index="${index}"]`);
          if (parentRow) parentRow.remove();
        }
      }
    }
  });

  function updateSelectedEvents(modalType) {
    const checkboxSelector =
      modalType === 'edit' ? '#eventsListEdit .event-checkbox' : '#eventsListDelete .event-checkbox';
    const countElement = modalType === 'edit' ? '#selectedEventsCountEdit' : '#selectedEventsCountDelete';
    const formSelector = modalType === 'edit' ? '#bulkEditForm' : '#bulkDeleteForm';
    const selectAllCheckbox = modalType === 'edit' ? '#selectAllEventsEdit' : '#selectAllEventsDelete';

    const checkboxes = document.querySelectorAll(checkboxSelector);
    const selectedIds = Array.from(checkboxes)
      .filter(cb => cb.checked)
      .map(cb => cb.value);

    const form = document.querySelector(formSelector);
    if (form) {
      form.querySelectorAll('input[name="event_ids[]"]').forEach(input => input.remove());
      selectedIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'event_ids[]';
        input.value = id;
        form.appendChild(input);
      });
    } else {
      console.error(`Form ${formSelector} not found`);
    }

    const countEl = document.querySelector(countElement);
    if (countEl) {
      countEl.textContent = `${selectedIds.length} vybraných akcí`;
    } else {
      console.error(`Count element ${countElement} not found`);
    }

    const selectAllEl = document.querySelector(selectAllCheckbox);
    if (selectAllEl) {
      selectAllEl.checked = Array.from(checkboxes).every(cb => cb.checked);
    }
  }

  const editCheckboxes = document.querySelectorAll('#eventsListEdit .event-checkbox');
  if (editCheckboxes.length) {
    editCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', () => updateSelectedEvents('edit'));
    });
  }

  const selectAllEdit = document.querySelector('#selectAllEventsEdit');
  if (selectAllEdit) {
    selectAllEdit.addEventListener('change', function () {
      const isChecked = this.checked;
      document.querySelectorAll('#eventsListEdit .event-checkbox').forEach(cb => {
        cb.checked = isChecked;
      });
      updateSelectedEvents('edit');
    });
  }

  const deleteCheckboxes = document.querySelectorAll('#eventsListDelete .event-checkbox');
  if (deleteCheckboxes.length) {
    deleteCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', () => updateSelectedEvents('delete'));
    });
  }

  const selectAllDelete = document.querySelector('#selectAllEventsDelete');
  if (selectAllDelete) {
    selectAllDelete.addEventListener('change', function () {
      const isChecked = this.checked;
      document.querySelectorAll('#eventsListDelete .event-checkbox').forEach(cb => {
        cb.checked = isChecked;
      });
      updateSelectedEvents('delete');
    });
  }

  const bulkEditForm = document.querySelector('#bulkEditForm');
  if (bulkEditForm) {
    bulkEditForm.addEventListener('submit', function (e) {
      updateSelectedEvents('edit');
      const selectedCount = document.querySelectorAll('#eventsListEdit .event-checkbox:checked').length;
      if (!selectedCount) {
        e.preventDefault();
        alert('Vyberte alespoň jednu akci k úpravě.');
      }
    });
  }

  const bulkDeleteForm = document.querySelector('#bulkDeleteForm');
  if (bulkDeleteForm) {
    bulkDeleteForm.addEventListener('submit', function (e) {
      updateSelectedEvents('delete');
      const selectedCount = document.querySelectorAll('#eventsListDelete .event-checkbox:checked').length;
      if (!selectedCount) {
        e.preventDefault();
        alert('Vyberte alespoň jednu akci k odstranění.');
        return;
      }
      const confirmDelete = document.querySelector('#confirmDelete');
      if (!confirmDelete || !confirmDelete.checked) {
        e.preventDefault();
        alert('Potvrďte prosím odstranění akcí.');
      }
    });
  }

  const editModal = document.querySelector('#multiEventEditModal');
  if (editModal) editModal.addEventListener('shown.bs.modal', () => updateSelectedEvents('edit'));

  const deleteModal = document.querySelector('#multiEventDeleteModal');
  if (deleteModal) deleteModal.addEventListener('shown.bs.modal', () => updateSelectedEvents('delete'));

  if (form) {
    form.addEventListener('submit', function (event) {
      const startDate = document.getElementById('startDate');
      const endDate = document.getElementById('endDate');
      const startTime = document.getElementById('startTime');
      const endTime = document.getElementById('endTime');
      if (startDate && endDate && startTime && endTime) {
        const startDateTime = `${startDate.value} ${startTime.value}`;
        const endDateTime = `${endDate.value} ${endTime.value}`;
        document.getElementById('startDatetime').value = startDateTime;
        document.getElementById('endDatetime').value = endDateTime;
      }
    });
  }

  document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
    item.addEventListener('click', function () {
      document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(i => i.classList.remove('active'));
      this.classList.add('active');
    });
  });

  document.addEventListener('input', event => {
    if (window.location.pathname != '/global-events') {
      const target = event.target;
      if (target.tagName === 'INPUT' || target.tagName === 'SELECT') {
        if (target.tagName === 'SELECT') {
          liveEditValue.textContent =
            'Vybráno: ' + (target.options[target.selectedIndex]?.text || 'Upravovaný text...');
        } else {
          liveEditValue.textContent = 'Text: ' + (target.value || 'Upravovaný text...');
        }
      }
    }
  });
});
function populateEditEventModal(event) {
  document.getElementById('editEventForm').action = `/events/${event.id}`;
  document.getElementById('editEventId').value = event.id;
  document.getElementById('editTitle').value = event.title || '';
  document.getElementById('editDescription').value = event.description || '';
  const start = new Date(event.start);
  const end = new Date(event.end);
  document.getElementById('editStartDate').value = start.toISOString().split('T')[0];
  document.getElementById('editStartTime').value = start.toTimeString().slice(0, 5);
  document.getElementById('editEndDate').value = end.toISOString().split('T')[0];
  document.getElementById('editEndTime').value = end.toTimeString().slice(0, 5);
}
function filterAttendance(filter, event) {
  if (event) event.preventDefault();
  const dateCards = document.querySelectorAll('.attendance-date-card');
  const tableHeaders = document.querySelectorAll('.attendance-table th:not(:first-child)');
  const tableRows = document.querySelectorAll('.attendance-member-row');
  const today = new Date();
  const oneMonthAgo = new Date();
  oneMonthAgo.setMonth(today.getMonth() - 1);

  dateCards.forEach(card => {
    const dateStr = card.getAttribute('data-date');
    const [day, month, year] = dateStr.split('.');
    const cardDate = new Date(year, month - 1, day);

    let shouldShow = false;
    switch (filter) {
      case 'all':
        shouldShow = true;
        break;
      case 'recent':
        shouldShow = cardDate >= oneMonthAgo && cardDate <= today;
        break;
      case 'upcoming':
        shouldShow = cardDate > today;
        break;
    }
    card.classList.toggle('d-none', !shouldShow);
  });

  tableHeaders.forEach((header, index) => {
    const dateStr = header.querySelector('.small.fw-bold').textContent;
    const [day, month, year] = dateStr.split('.');
    const headerDate = new Date(year, month - 1, day);

    let shouldShow = false;
    switch (filter) {
      case 'all':
        shouldShow = true;
        break;
      case 'recent':
        shouldShow = headerDate >= oneMonthAgo && headerDate <= today;
        break;
      case 'upcoming':
        shouldShow = headerDate > today;
        break;
    }
    header.classList.toggle('d-none', !shouldShow);

    tableRows.forEach(row => {
      const cell = row.cells[index + 1];
      if (cell) cell.classList.toggle('d-none', !shouldShow);
    });
  });
}

function showAttendanceEditor(eventId) {
  const editor = document.getElementById(`attendance-editor-${eventId}`);
  if (editor) {
    editor.classList.remove('d-none');
    const currentFilter =
      document
        .querySelector('.dropdown-item.active')
        ?.getAttribute('onclick')
        ?.match(/'([^']+)'/)?.[1] || 'all';
    filterAttendance(currentFilter);
  }
}

function hideAttendanceEditor(eventId) {
  const editor = document.getElementById(`attendance-editor-${eventId}`);
  if (editor) editor.classList.add('d-none');
}

function toggleMembersView() {
  const tableView = document.getElementById('members-table-view');
  const cardView = document.getElementById('members-card-view');
  tableView.classList.toggle('d-none');
  cardView.classList.toggle('d-none');
}

function toggleUsersView() {
  const tableView = document.getElementById('users-table-view');
  const cardView = document.getElementById('users-card-view');
  tableView.classList.toggle('d-none');
  cardView.classList.toggle('d-none');
}

function toggleAttendanceView() {
  const cardsView = document.getElementById('attendance-cards-view');
  const tableView = document.getElementById('attendance-table-view');
  const inputGroup = document.getElementById('attendance-input-group');
  cardsView.classList.toggle('d-none');
  tableView.classList.toggle('d-none');
  inputGroup.classList.toggle('d-none');
}

function toggleEventsView() {
  const tableView = document.getElementById('events-table-view');
  const cardView = document.getElementById('events-card-view');
  const toggleBtn = document.getElementById('view-toggle-btn');

  if (tableView.classList.contains('d-none')) {
    tableView.classList.remove('d-none');
    cardView.classList.add('d-none');
    toggleBtn.innerHTML = '<i class="ri-layout-grid-line me-1"></i> Přepnout zobrazení';
  } else {
    tableView.classList.add('d-none');
    cardView.classList.remove('d-none');
    toggleBtn.innerHTML = '<i class="ri-table-line me-1"></i> Přepnout zobrazení';
  }
}

function filterEvents(filter) {
  const now = new Date();
  const currentMonth = now.getMonth();
  const nextMonth = (currentMonth + 1) % 12;

  document.querySelectorAll('.event-item').forEach(item => {
    const startDate = new Date(item.getAttribute('data-start'));
    const eventMonth = startDate.getMonth();

    switch (filter) {
      case 'all':
        item.style.display = '';
        break;
      case 'upcoming':
        if (startDate > now) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
        break;
      case 'past':
        if (startDate < now) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
        break;
      case 'thisMonth':
        if (eventMonth === currentMonth) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
        break;
      case 'nextMonth':
        if (eventMonth === nextMonth) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
        break;
    }
  });
}

function updateAttendance(selectElement) {
  const memberId = $(selectElement).data('member-id');
  const eventId = $(selectElement).data('event-id');
  const status = $(selectElement).val();
  $.ajax({
    url: '/update-attendance',
    type: 'POST',
    data: {
      member_id: memberId,
      event_id: eventId,
      status: status
    },
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    },
    success: function (response) {
      if (response.success) {
        $(selectElement).addClass('success-feedback');
        setTimeout(() => $(selectElement).removeClass('success-feedback'), 1000);
      } else {
        $(selectElement).addClass('error-feedback');
        setTimeout(() => $(selectElement).removeClass('error-feedback'), 1000);
      }
    },
    error: function (xhr, status, error) {
      console.error('Error:', error);
      $(selectElement).addClass('error-feedback');
      setTimeout(() => $(selectElement).removeClass('error-feedback'), 1000);
    }
  });
}

function generateRecurrenceDates(startDate, recurrenceType, interval, endDate = null, repeatCount = null) {
  const dateOutputContainer = document.getElementById('dateOutputContainer');
  const datesRemovedOutputContainer = document.getElementById('datesRemovedOutputContainer');
  const filterOutHolidays = $('#filterOutHolidayDates').is(':checked');

  $('#dateOutput').empty();
  $('#datesRemovedOutput').empty();
  dateOutputContainer.classList.add('d-none');
  datesRemovedOutputContainer.classList.add('d-none');

  let dates = [];
  let currentDate = new Date(startDate);
  let maxDate = endDate ? new Date(endDate) : null;
  let maxOccurrences = repeatCount ? Math.max(1, repeatCount) : 50;

  if (isNaN(currentDate.getTime())) {
    console.error('Neplatné datum začátku:', startDate);
    return;
  }

  const MAX_EVENTS = 50;

  while (dates.length < maxOccurrences && (!maxDate || currentDate <= maxDate) && dates.length < MAX_EVENTS) {
    dates.push(new Date(currentDate));
    if (recurrenceType === 'daily') {
      currentDate.setDate(currentDate.getDate() + interval);
    } else if (recurrenceType === 'weekly') {
      currentDate.setDate(currentDate.getDate() + interval * 7);
    } else if (recurrenceType === 'monthly') {
      currentDate.setMonth(currentDate.getMonth() + interval);
    }
  }

  let dateList = dates
    .filter(date => date instanceof Date && !isNaN(date.getTime()))
    .map(date => date.toISOString().split('T')[0]);

  if (dateList.length === 0) {
    console.error('Špatný vstup.');
    return;
  }

  if (dates.length >= MAX_EVENTS && (!maxDate || currentDate <= maxDate) && maxOccurrences > MAX_EVENTS) {
    const warningEl = document.createElement('div');
    warningEl.className = 'alert alert-warning mt-3';
    warningEl.innerHTML = '<i class="ri-error-warning-line me-2"></i>Počet opakování byl omezen na maximálně 50 akcí.';
    dateOutputContainer.parentNode.insertBefore(warningEl, dateOutputContainer);
  }

  function displayDates(finalDates) {
    if (finalDates.length > 0) {
      dateOutputContainer.classList.remove('d-none');
      const maxDisplay = Math.min(finalDates.length, 6);
      for (let i = 0; i < maxDisplay; i++) {
        $('#dateOutput').append(
          `<li class="list-group-item bg-light text-dark border-0 py-2">
            <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
              <span class="text-wrap">${returnDay(new Date(finalDates[i]).getDay())} ${formatDate(finalDates[i])}</span>
            </div>
          </li>`
        );
      }
      if (finalDates.length > 6) {
        $('#dateOutput').append(
          `<li class="list-group-item text-muted bg-light border-0 py-2 fst-italic">
            A ${finalDates.length - 6} dalších...
          </li>`
        );
      }
    }
  }
  if (!filterOutHolidays) {
    displayDates(dateList);
    return;
  }
  let last = dateList[dateList.length - 1];
  let difference = Math.max(0, Math.floor((new Date(last) - new Date(startDate)) / (1000 * 60 * 60 * 24)));

  $.ajax({
    dataType: 'json',
    url: `https://svatkyapi.cz/api/day/${startDate}/interval/${difference}`,
    type: 'GET',
    success: function (response) {
      let removedDates = new Map();

      if (response && Array.isArray(response)) {
        response.forEach(item => {
          if (item.holidayName && dateList.includes(item.date)) {
            removedDates.set(item.date, item.holidayName);
          }
        });
      }

      let finalDates = dateList.filter(date => !removedDates.has(date));
      displayDates(finalDates);
      if (removedDates.size > 0) {
        datesRemovedOutputContainer.classList.remove('d-none');
        removedDates.forEach((holidayName, date) => {
          $('#datesRemovedOutput').append(
            `<li class="list-group-item bg-warning-subtle text-dark border-0 py-2">
              <div class="d-flex flex-column flex-md-row align-items-md-center gap-2">
                <span class="text-wrap">${returnDay(new Date(date).getDay())} ${formatDate(date)}</span>
                <span class="badge bg-warning text-dark text-wrap mt-1 mt-md-0">${holidayName}</span>
              </div>
            </li>`
          );
        });
      }
    },
    error: function (xhr, status, error) {
      console.error('Error:', error);
      displayDates(dateList);
    }
  });
}

function formatDate(dateStr) {
  const date = new Date(dateStr);
  return date
    .toLocaleDateString('cs-CZ', {
      day: '2-digit',
      month: '2-digit',
      year: 'numeric'
    })
    .replace(/\s/g, '');
}

function returnDay(dateInt) {
  switch (dateInt) {
    case 0:
      return 'Neděle';
    case 1:
      return 'Pondělí';
    case 2:
      return 'Úterý';
    case 3:
      return 'Středa';
    case 4:
      return 'Čtvrtek';
    case 5:
      return 'Pátek';
    case 6:
      return 'Sobota';
  }
}

window.filterEvents = filterEvents;
window.toggleEventsView = toggleEventsView;
window.filterAttendance = filterAttendance;
window.showAttendanceEditor = showAttendanceEditor;
window.hideAttendanceEditor = hideAttendanceEditor;
window.toggleMembersView = toggleMembersView;
window.toggleUsersView = toggleUsersView;
window.toggleAttendanceView = toggleAttendanceView;
window.updateAttendance = updateAttendance;
window.populateEditEventModal = populateEditEventModal;

document.addEventListener('DOMContentLoaded', event => {
  const hash = window.location.hash;
  if (hash) {
    const targetTab = document.querySelector(`button[data-bs-target="${hash}"]`);
    if (targetTab) {
      const tab = new bootstrap.Tab(targetTab);
      tab.show();
    }
  }
});
