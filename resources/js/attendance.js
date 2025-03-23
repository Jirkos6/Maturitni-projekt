import $ from 'jquery';
window.$ = $;

document.addEventListener('DOMContentLoaded', event => {
  function showSuccessNotification(message) {
    const notification = $(
      '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg opacity-0 transition-opacity duration-500 mt-5" role="alert">' +
        message +
        '</div>'
    );

    $('#notification-container').prepend(notification);

    setTimeout(() => notification.addClass('opacity-100'), 100);
    setTimeout(() => {
      notification.removeClass('opacity-100').addClass('opacity-0');
      setTimeout(() => notification.remove(), 500);
    }, 3000);
  }

  $('.ajax-confirm-btn').on('click', function () {
    var button = $(this);
    var url = button.data('url');
    var attendanceId = button.data('attendance-id');
    var originalText = button.text();

    button.prop('disabled', true).text('Potvrzování...');

    $.ajax({
      url: url,
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (data) {
        if (data.success) {
          var row = $('#row-' + attendanceId);
          row.fadeOut(300, function () {
            $(this).remove();
            if ($('table tbody tr').length === 0) {
              $('#attendance-container').html(
                '<div class="text-center mt-16">' +
                  '<h2 class="font-medium text-green-600 dark:text-green-400 text-2xl">' +
                  'Žádné akce nepotřebují potvrzení!' +
                  '</h2></div>'
              );
            }
          });
          showSuccessNotification(data.message);
        } else {
          alert(data.message);
        }
      },
      error: function (xhr) {
        let errorMsg = 'Nepodařilo se kontaktovat server. Zkuste to znovu později.';
        if (xhr.responseJSON && xhr.responseJSON.message) {
          errorMsg = xhr.responseJSON.message;
        }
        alert(errorMsg);
        console.error('Error:', xhr.responseText);
      },
      complete: function () {
        button.prop('disabled', false).text(originalText);
      }
    });
  });
});
