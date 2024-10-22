
$(document).ready(function() {
    $('#contact-form').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true,
            },
            subject: 'required',
            message: 'required',
            attachment: 'required'
        },
        messages: {
            name: 'Name is required',
            email: 'Email is required',
            subject: 'Subject is required',
            message: 'Message is required',
            attachment: 'File is required',
        },
        submitHandler: function(form) {
            var formData = new FormData(form);

            // File validation (size and type)
            var fileInput = $('input[name="attachment"]')[0];
            var file = fileInput.files[0];
            var allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    $('#alert-container').html(
                        '<div class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg m-2">File size exceeds 2MB limit.</div>'
                    );
                    return;
                }
                if (!allowedTypes.includes(file.type)) {
                    $('#alert-container').html(
                        '<div class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg m-2">Invalid file format. Allowed: .pdf, .png, .jpeg</div>'
                    );
                    return;
                }
            }

            $.ajax({
                url: "{{ route('contactform') }}",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btnSubmit').prop('disabled', true); // Disable submit button
                    $('#loader').css('display', 'flex');
                    $('#loader').show(); // Show the full-screen loader
                },
                success: function(response) {
                    $('#alert-container').html(
                        '<div class="bg-green-500 text-white font-bold py-2 px-4 rounded-lg m-2">Message sent successfully!</div>'
                    );
                    $('#contact-form')[0].reset(); // Reset form fields
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMsg = '<p>An error occurred. Please try again.</p>';
                    if (errors) {
                        errorMsg = '<p>' + Object.values(errors).flat().join(
                            '</p><p>') + '</p>'; // Combine all error messages
                    }
                    $('#alert-container').html(
                        '<div class="bg-red-500 text-white font-bold py-2 px-4 rounded-lg m-2">' + errorMsg +
                        '</div>'
                    );
                },
                complete: function() {
                    $('#btnSubmit').prop('disabled',
                        false); // Re-enable the submit button
                    $('#loader').hide(); // Hide the full-screen loader
                }
            });
        }
    });
});


