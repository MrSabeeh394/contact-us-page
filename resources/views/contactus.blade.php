<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gyb4Q3j9B1W62AsQGT2T9T9E4jD9p9yt94zD2Z1mELPTbDplQ4" crossorigin="anonymous">
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- 
     alpha/css/bootstrap.css"
        rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background-image: url('{{ asset('images/background2.jpg') }}');
            background-color: #cccccc;
            background-size: cover;
            background-position: center;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Loader -->
    <div id="loader" class="fixed inset-0 flex justify-center items-center bg-gray-200 bg-opacity-70 z-50 hidden">
        <img src="{{ asset('images/Infinity.svg') }}" alt="Loading..." style="width: 150px" />
    </div>
    <div class="container mx-auto p-4">
        <div class="flex flex-col md:flex-row justify-center">
            <!-- Form Section -->
            <div class="w-full md:w-1/2">
                <div class="bg-white rounded-lg shadow-lg p-6 mt-4">
                    <div id="alert-container"></div> <!-- Placeholder for alert messages -->
                    <h5 class="text-xl font-semibold mb-4">Contact Us</h5>
                    <form id="contact-form" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">Name</label>
                            <input type="text"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" name="name"
                                placeholder="Enter your name" required>
                        </div>
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium">Email</label>
                            <input type="email"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" name="email"
                                placeholder="example@example.com" required>
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="block text-sm font-medium">Subject</label>
                            <input type="text"
                                class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" name="subject"
                                placeholder="Subject" required>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium">Message</label>
                            <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm" name="message" rows="4"
                                placeholder="Your message here..." required></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="file" class="block text-sm font-medium">Attach a file</label>
                            <input type="file" class="mt-1 block w-full" name="attachment" required>
                            <small class="text-gray-500">Max size: 2MB. Allowed: .pdf, .png, .jpeg</small>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600"
                            id="btnSubmit">Send Message</button>
                    </form>
                </div>
            </div>
            <!-- Heading Section -->
            <div class="w-full md:w-1/2 flex justify-center items-center mt-8 md:mt-0">
                <h1 class="text-4xl md:text-8xl font-bold text-center">Contact Us</h1>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9gyb4Q3j9B1W62AsQGT2T9T9E4jD9p9yt94zD2Z1mELPTbDplQ4" crossorigin="anonymous">
    </script>
    {{-- <script src="{{ asset('js/contact-us.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            // Set toastr options globally
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right", // Optional: Set position of toastr notifications
                "timeOut": "5000", // Optional: Duration for which the notification is shown
                "extendedTimeOut": "1000" // Optional: Duration for which the notification is shown on hover
            };

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
                            toastr.error('File size exceeds 2MB limit.');
                            return;
                        }
                        if (!allowedTypes.includes(file.type)) {
                            toastr.error('Invalid file format. Allowed: .pdf, .png, .jpeg');
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
                            toastr.success('Form submitted successfully!');
                        },
                        error: function(xhr) {
                            var errors = xhr.responseJSON.errors;
                            var errorMsg = 'An error occurred. Please try again.';
                            if (errors) {
                                errorMsg = Object.values(errors).flat().join('<br>');
                            }
                            toastr.error(errorMsg);
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
    </script>


</body>

</html>
