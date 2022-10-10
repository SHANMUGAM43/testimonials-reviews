$(document).ready(function () {
  // create post
  $('#create-testimonial-btn').click(function() {
      $('.error').remove();
      $('#testimonialId').remove();
      $('#testimonialModal #modalTitle').text('Create Testimonial');
      $('#testimonialForm')[0].reset();
      $('#testimonialModal').modal('toggle');
  });

   // form validate and submit
    $('#testimonialForm').validate({
        rules: {
            name: 'required',
            email: 'required',
            rating: 'required',
            status: 'required',
            message: 'required',
        },
        messages: {
            name: 'Please enter the Name',
            email: 'Please enter the email',
            rating: 'Please enter the rating and value between 0 to 5',
            status: 'Please enter the status and value 0 or 1',
            message: 'Please enter the message',
        },

        submitHandler: function(form) {
            const id = $('input[name=testimonialId]').val();
            const formData = $(form).serializeArray();

            $.ajax({
                url: 'testimonials',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response && response.status === 'success') {
        
                        // clear form
                        $('#testimonialForm')[0].reset();

                        // toggle modal
                        $('#testimonialModal').modal('toggle');
        
                        $('#testimonialTable p').empty();
        
                        const data = response.data;

                        if (id) {
                            $("#testimonial_"+id+" td:nth-child(2)").html(data.name);
                            $("#testimonial_"+id+" td:nth-child(3)").html(data.email);
                            $("#testimonial_"+id+" td:nth-child(4)").html(data.rating);
                            $("#testimonial_"+id+" td:nth-child(5)").html(data.status);
                            $("#testimonial_"+id+" td:nth-child(6)").html(data.message);
                        }

                        else {
                            $('#testimonialTable').prepend(`<tr id=${'testimonial_'+data.id}><td>${data.id}</td><td>${data.name}</td><td>${data.email}</td><td>${data.rating}</td><td>${data.status}</td><td>${data.message}</td><td>
                            <a href="javascript:void(0)" data-id=${data.id} title="View" class="btn btn-sm btn-info btn-view"> View </a>
                            <a href="javascript:void(0)" data-id=${data.id} title="Edit" class="btn btn-sm btn-success btn-edit"> Edit </a>
                            <a href="javascript:void(0)" data-id=${data.id} title="Delete" class="btn btn-sm btn-danger btn-delete"> Delete </a></td></tr>`);
                        }
                    }
                }            
            });
        }
    })
});

// view button click
$('.btn-view').click(function() {
    const id = $(this).data('id');
    $('label.error').remove();
    $('input[name=name]').removeClass('error');
    $('input[name=email]').removeClass('error');
    $('input[name=rating]').removeClass('error');
    $('input[name=status]').removeClass('error');
    $('textarea[name=message]').removeClass('error');
    $('input[name=name]').attr('disabled', 'disabled');
    $('input[name=email]').attr('disabled', 'disabled');
    $('input[name=rating]').attr('disabled', 'disabled');
    $('input[name=status]').attr('disabled', 'disabled');
    $('textarea[name=message]').attr('disabled', 'disabled');
    $('#testimonialModal button[type=submit]').addClass('d-none');

    $.ajax({
        url: `testimonials/${id}`,
        type: 'GET',
        success: function(response) {
            if (response && response.status === 'success') {
                const data = response.data;
                $('#testimonialModal #modalTitle').text('Testimonial Detail');
                $('#testimonialModal input[name=name]').val(data.name);
                $('#testimonialModal input[name=email]').val(data.email);
                $('#testimonialModal input[name=rating]').val(data.rating);
                $('#testimonialModal input[name=status]').val(data.status);
                $('#testimonialModal textarea[name=message]').val(data.message);
                $('#testimonialModal').modal('toggle');
            }
        }
    })
});

// edit button click
$('.btn-edit').click(function() {
    const id = $(this).data('id');
    $('label.error').remove();
    $('input[name=name]').removeClass('error');
    $('input[name=name]').after('<input type="hidden" name="testimonialId" value="'+id+'" />')
    $('input[name=email]').removeClass('error');
    $('input[name=email]').after('<input type="hidden" name="testimonialId" value="'+id+'" />')
    $('input[name=rating]').removeClass('error');
    $('input[name=rating]').after('<input type="hidden" name="testimonialId" value="'+id+'" />')
    $('input[name=status]').removeClass('error');
    $('input[name=status]').after('<input type="hidden" name="testimonialId" value="'+id+'" />')
    $('textarea[name=message]').removeClass('error');
    $('input[name=name]').removeAttr('disabled');
    $('input[name=email]').removeAttr('disabled');
    $('input[name=rating]').removeAttr('disabled');
    $('input[name=status]').removeAttr('disabled');
    $('textarea[name=message]').removeAttr('disabled');
    $('#testimonialModal button[type=submit]').removeClass('d-none');

    $.ajax({
        url: `testimonials/${id}`,
        type: 'GET',
        success: function(response) {
            if (response && response.status === 'success') {
                const data = response.data;
                $('#testimonialModal #modalTitle').text('Update testimonial');
                $('#testimonialModal input[name=name]').val(data.name);
                $('#testimonialModal input[name=email]').val(data.email);
                $('#testimonialModal input[name=rating]').val(data.rating);
                $('#testimonialModal input[name=status]').val(data.status);
                $('#testimonialModal textarea[name=message]').val(data.message);
                $('#testimonialModal').modal('toggle');
            }
        }
    })
});

// delete button click
$('.btn-delete').click(function() {
    const id = $(this).data('id');

    if (id) {
        const result = window.confirm('Do you want to delete?');
        if (result) {
            $.ajax({
                url: `testimonials/${id}`,
                type: 'DELETE',
                success: function(response) {
                    if (response && response.status === 'success') {
                        const data = response.data;
                        $(`#testimonial_${data.id}`).remove();
                    }
                }
            });
        }
        else {
            console.log('error', 'testimonial not found');
        }
    }
});

