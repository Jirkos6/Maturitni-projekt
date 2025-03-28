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
  if (repeatCountContainer) {
    repeatCountContainer.style.display = 'none';
  }
  if (recurrenceEndDateContainer) {
    recurrenceEndDateContainer.style.display = 'block';
  }

  $('.js-example-basic-multiple').select2({
    width: '300px',
    dropdownParent: $('#memberAssignAchievement'),
    theme: 'bootstrap-5',
    language: 'cs'
  });
  $('.js-basic-multiple').select2({
    width: '300px',
    dropdownParent: $('#userAssignMember'),
    theme: 'bootstrap-5',
    language: 'cs'
  });
  $('.js-multiple').select2({
    width: '300px',
    dropdownParent: $('#eventAssignTeam'),
    theme: 'bootstrap-5',
    language: 'cs'
  });
  $('.delete-event-team-select').select2({
    dropdownParent: $('#bulkEditForm'),
    theme: 'bootstrap-5',
    language: 'cs'
  });
  $('.team-select').select2({
    dropdownParent: $('#eventForm'),
    theme: 'bootstrap-5',
    language: 'cs'
  });
  $('#assignAchievementModal').on('show.bs.modal', function (e) {
    let button = $(e.relatedTarget);
    let memberId = button.data('member-id');
    $('#memberId').val(memberId);
    $.ajax({
      url: `/member-achievements/${memberId}`,
      method: 'GET',
      success: function (data) {
        $('#achievementSelect').val(data).trigger('change');
      },
      error: function (xhr) {
        console.error('Error fetching achievements:', xhr.responseText);
      }
    });
  });

  $('#assignMemberModal').on('show.bs.modal', function (e) {
    let button = $(e.relatedTarget);
    let userId = button.data('user-id');
    $('#userId').val(userId);
    $.ajax({
      url: `/user-members/${userId}`,
      method: 'GET',
      success: function (data) {
        $('#memberSelect').val(data).trigger('change');
      },
      error: function (xhr) {
        console.error('Error fetching members:', xhr.responseText);
      }
    });
  });

  $('#reccuringCheckbox').on('change', function (e) {
    if (this.checked) {
      $('#recurrenceEndDate').val('');
      $('#recurrenceRepeatCount').prop('disabled', false);
      $('#recurrenceEndDate').prop('disabled', true);

      if (document.getElementById('repeatCountContainer')) {
        document.getElementById('repeatCountContainer').style.display = 'block';
      }
      if (document.getElementById('recurrenceEndDateContainer')) {
        document.getElementById('recurrenceEndDateContainer').style.display = 'none';
      }
    } else {
      $('#recurrenceRepeatCount').val('');
      $('#recurrenceRepeatCount').prop('disabled', true);
      $('#recurrenceEndDate').prop('disabled', false);

      if (document.getElementById('repeatCountContainer')) {
        document.getElementById('repeatCountContainer').style.display = 'none';
      }
      if (document.getElementById('recurrenceEndDateContainer')) {
        document.getElementById('recurrenceEndDateContainer').style.display = 'block';
      }
    }
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
    dateOutputContainer.classList.add('d-none');
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
      if (document.getElementById('recurrenceEndDateContainer')) {
        document.getElementById('recurrenceEndDateContainer').style.display = 'block';
      }
      if (document.getElementById('repeatCountContainer')) {
        document.getElementById('repeatCountContainer').style.display = 'none';
      }
      $('#reccuringCheckbox').prop('checked', false);
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
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        alert(response.message || 'Odborky byly úspěšně přidány.');
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
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        alert(response.message || 'Členové byli úspěšně přiřazeni.');
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
  const startDate = event.start_date.split(' ')[0];
  const startTime = event.start_date.split(' ')[1].substring(0, 5);
  document.getElementById('editStartDate').value = startDate;
  document.getElementById('editStartTime').value = startTime;
  const endDate = event.end_date.split(' ')[0];
  const endTime = event.end_date.split(' ')[1].substring(0, 5);
  document.getElementById('editEndDate').value = endDate;
  document.getElementById('editEndTime').value = endTime;
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
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
