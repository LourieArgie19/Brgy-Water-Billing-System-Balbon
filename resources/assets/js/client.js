$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  function fetchClients() {
    $.ajax({
      type: 'GET',
      url: '/fetch-client',
      dataType: 'json',
      success: function (response) {
        // Clear the existing table data
        $('tbody').empty();

        // Iterate over each user in the response and append it to the table
        $.each(response.client, function (key, client) {
          var actions =
            '<div class="dropdown">' +
            '<button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>' +
            '<div class="dropdown-menu">' +
            '<a class="dropdown-item edit-client" data-id="' +
            client.id +
            '"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>' +
            '<a class="dropdown-item delete-client" data-id="' +
            client.id +
            '"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a>' +
            '</div>' +
            '</div>';

          $('tbody').append(
            '<tr data-id="' +
              client.id +
              '">' +
              '<td>' +
              client.user.name +
              '</td>' +
              '<td>' +
              client.user.email +
              '</td>' +
              '<td>' +
              client.date +
              '</td>' +
              '<td>' +
              client.purok +
              '</td>' +
              '<td>' +
              client.meter_number +
              '</td>' +
              '<td>' +
              actions +
              '</td>' +
              '</tr>'
          );
        });
      }
    });
  }

  // Call fetchClients function after it's defined
  fetchClients();

  // Submit registration form
  $('#clientForm').submit(function (e) {
    e.preventDefault(); // Prevent the form from submitting in the traditional way

    var formData = $(this).serialize(); // Serialize the form data

    $('body').addClass('swal2-backdrop-show'); // Show the backdrop with custom class

    $.ajax({
      url: '/store-client', // Corrected route for user registration
      type: 'POST',
      data: formData,
      success: function (response) {
        // Handle success response
        console.log(response);
        if (response.success) {
          $('#basicModal').modal('hide'); // Close the modal on successful registration
          fetchClients(); // Update user list
          Swal.fire({
            // Show success message
            icon: 'success',
            title: 'Success!',
            text: response.message,
            onClose: function () {
              $('body').removeClass('swal2-backdrop-show'); // Remove backdrop class
            }
          });
        }
      },
      error: function (xhr) {
        // Handle error response
        console.error(xhr.responseText);
        $('#basicModal').modal('hide');
        var errorMessage = xhr.responseJSON.errors
          ? Object.values(xhr.responseJSON.errors)[0][0]
          : 'An error occurred. Please try again later.';
        Swal.fire({
          // Show error message
          icon: 'error',
          title: 'Oops...',
          text: errorMessage,
          onClose: function () {
            $('body').removeClass('swal2-backdrop-show'); // Remove backdrop class
          }
        });
      }
    });
  });

  // Update user data
  $('#updateForm').submit(function (e) {
    e.preventDefault();
    var user_id = $('#user_id').val();
    var formData = $(this).serialize();

    $.ajax({
      url: '/update-client/' + user_id,
      type: 'PUT',
      data: formData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        console.log(response);
        if (response.success) {
          $('#updateModal').modal('hide');
          fetchClients();
          Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: response.message
          });
        }
      },
      error: function (xhr) {
        $('#updateModal').modal('hide');
        var errorMessage = xhr.responseJSON.errors
          ? Object.values(xhr.responseJSON.errors)[0][0]
          : 'An error occurred. Please try again later.';
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: errorMessage
        });
      }
    });
  });

  // Edit user
  $(document).on('click', '.edit-client', function (e) {
    e.preventDefault();
    var user_id = $(this).data('id');

    $('#updateModal').modal('show');

    $.ajax({
      type: 'GET',
      url: '/edit-client/' + user_id,
      success: function (response) {
        if (response.status == 404) {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: response.message
          });
        } else {
          var data = response.user;
          $('#user_id').val(data.id);
          $('#updateName').val(data.user.name);
          $('#updateEmail').val(data.user.email);
          $('#updatePurok').val(data.purok);
          $('#updateMetersNumber').val(data.meter_number);

          if (data.hasOwnProperty('password')) {
            $('#updatePassword').val(data.password);
          }
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });

  $(document).on('click', '.delete-client', function () {
    var user_id = $(this).data('id');

    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      customClass: {
        confirmButton: 'btn btn-primary me-4 waves-effect waves-light',
        cancelButton: 'btn btn-outline-secondary waves-effect'
      },
      buttonsStyling: false
    }).then(function (result) {
      if (result.isConfirmed) {
        $.ajax({
          url: '/delete-client/' + user_id,
          type: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            console.log(response);
            // Assuming fetchClients() is defined and updates the UI accordingly
            fetchClients();
          },
          error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'An error occurred. Please try again later.'
            });
          }
        });
      }
    });
  });

  // Search functionality
  $('#searchInput').on('input', function () {
    var searchText = $(this).val().toLowerCase();

    $('#DataTables_Table_0 tbody tr').each(function () {
      var rowData = $(this).text().toLowerCase();

      if (rowData.includes(searchText)) {
        $(this).show();
      } else {
        $(this).hide();
      }
    });
  });
});
