var timers = {};
$(document).ready(function() {
  $('#formAuthentication').on('submit', function (e){
  e.preventDefault();

  if ($('#formAuthentication')[0].checkValidity()) {
      $.ajax({
          url: '/function',
          method: 'POST',
          data: $('#formAuthentication').serialize(),
          dataType: 'json',
          beforeSend: function () {
              $('#btn').html('Redirecting...');
          },
          success: function (data) {
              $('#btn').html('Submit');
              if (data.success) {
                  window.location.href = '/dashboard';
              } else {
                  $('#error-message')
                      .text('Invalid Credentials. Attempts remaining: ' + data.attemptsLeft)
                      .show();
                      $('#password').val('');
                  if (data.attemptsLeft <= 0 && !isNaN(data.timeLeft)) {
                      startTimer(data.timeLeft, data.gmail);
                  }
              }
          },
          error: function (xhr, status, error) {
              console.error('Error: ' + error);
              console.error( 'Response Text: ' + xhr.responseText);
              alert('Error!');
          },
          complete: function () {
              $('#btn').val('Sign in').prop('disabled', false);
          }
      });
    }
  });
});

function startTimer(timeLeft, email) {
    clearTimers(); // Clear any existing timers and error messages

    // Start timer for this email
    timers[email] = {};
    timers[email].time = timeLeft;
    timers[email].id = setInterval(function() {
        var minutes = Math.floor(timers[email].time / 60);
        var seconds = timers[email].time % 60;
        $('#error-time').text('Try again after ' + minutes + ' minutes and ' + seconds + ' seconds.').show();
        timers[email].time--;
        if (timers[email].time < 0) {
            clearInterval(timers[email].id);
            delete timers[email];
            $('#error-time').hide();
            $('#error-message').hide();
        }
    }, 1000);
}

function clearTimers() {
    // Clear all existing timers and hide error messages
    for (var email in timers) {
        clearInterval(timers[email].id);
        delete timers[email];
    }
    $('#error-time').hide();
    $('#error-message').hide();
}
