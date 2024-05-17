
$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  function fetchBillings() {
    $.ajax({
      type: 'GET',
      url: '/fetch-billings',
      dataType: 'json',
      success: function (response) {
        // Clear the existing table data
        $('tbody').empty();

        // Iterate over each billing record in the response and append it to the table
        $.each(response.billings, function (key, billing) {
          addTableEntry(billing)
        });
      }
    });
  }

  function fetchClients() {
    $.ajax({
      type: 'GET',
      url: '/fetch-client',
      dataType: 'json',
      success: function (response) {
        $('.client-dropdown').find('option')
            .remove()
            .end()
            .append('<option value="">Select One</option>')
            .val()

        $.each(response.client, function (key, client) {
          addSelectEntry(client)
        });
      }
    })
  }

  function fetchLatestClientBill() {
    const client_id = $('.client-dropdown').val()
    $.ajax({
      type: 'GET',
      url: `/billings/${client_id}/latest`,
      dataType: 'json',
      success: function (response) {
        $('#previous_reading').empty()
        $('#previous_reading').val(response.bill?.current_reading ?? 0)
      },
      error: function (jqXHR, textStatus, errorThrown) {
        $('#previous_reading').val(0)
      }
    })
  }

  function addTableEntry(record) {
    const actions = record.is_paid ? `` : `
      <div class="action-buttons">
       <!--- Dili ika recommend kay ma osab ang bayronun labaw na kung previous nya nabayaran na
        <button type="button" class="btn btn-sm btn-primary edit-billing" data-id="${record.id}">
        <i class="mdi mdi-pencil-outline me-1"></i> Edit
        </button>
        ---->
        <button type="button" class="btn btn-sm btn-info mark-as-done-billing"" data-id="${record.id}">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
          <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
        </svg>
        Mark as Paid
        </button>
      </div>
    `
    $('tbody').append(
      `
        <tr data-id="${record.id}">
          <td>${record.date_issued}</td>
          <td>${record.bill_owner.user.name}</td>
          <td>${record.bill_owner.meter_number}</td>
          <td>${record.current_reading}</td>
          <td>${record.price}</td>
          <td>${record.is_paid ? 'Paid' : 'Pending'}</td>
          <td>${actions}</td>
        </tr>
      `
    )
  }

  function addSelectEntry(entry) {
    $('.client-dropdown').append( `
      <option value="${entry.id}">${entry.user.name}</option>
    `)
  }

  function validateNewBillForm() {
    const fields = ['date_issued', 'previous_reading', 'current_reading', 'client_id']
    let hasNoError = true
    for(let field of fields) {
      const fieldTag = $(`#${field}`)
      if(!fieldTag.val() || fieldTag.val() == '') {
        $(`#${field}_error`).attr('hidden', false)
        hasNoError = false
      } else {
        $(`#${field}_error`).attr('hidden', true)
      }
    }

    return hasNoError
  }

  // Call fetchBillings function after it's defined
  fetchBillings();

  $( "#createBillModal" ).on('shown.bs.modal', function () {
    fetchClients()
  });

  $('.client-dropdown').change(() => {
    fetchLatestClientBill()
  })

  $('#current_reading').keyup(() => {
    const previous = $('#previous_reading').val()
    const current = $('#current_reading').val()
    const price = (current - previous) * water_rate
    $('#price').val(price)
  })

  $('#addBillBtn').click((e) => {
    if(!validateNewBillForm()) return

    const formData = {}
    const fields = ['date_issued', 'previous_reading', 'current_reading', 'client_id']
    fields.forEach(field => {
      formData[field] = $(`#${field}`).val()
    })

    $.ajax({
      type: 'POST',
      url: '/billing',
      data: formData,
      dataType: 'json',
      encode: true,
      success: function(response) {
          // Handle the response from the server
          $( "#createBillModal" ).modal('hide')
          Swal.fire({ // Show success message
              icon: 'success',
              title: 'Success!',
              text: response.message,
          })
          fetchBillings();
      },
      error: function(xhr, status, error) {
          // Handle errors
          console.error(error);
          $('#response').html('<p>An error occurred. Please try again.</p>');
          Swal.fire({ // Show success message
              icon: 'error',
              title: 'Something went wrong!',
              text: 'An error occurred. Please try again.',
          })
      }
    });
  })
  // Other code for form submission, updating data, etc. remains the same as before
});
