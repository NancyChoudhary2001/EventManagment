<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>OTP Verification</title>
    <style>
        body {
            background: linear-gradient(to right, rgb(216, 46, 131), rgb(164, 24, 186)); 
        }
        .container {
            padding: 20px;
            border-radius: 15px;
            max-width: 700px;
            margin-top: 80px;
            background-color: white; 
        }
        .error small {
            visibility: visible;
            color: #e74c3c;
        }
        .error-message {
        color: red;
        font-size: 0.875rem; 
    }
    </style>
</head>
<body>
    <div class="container">
        <form id="verifyotp">
            <input type="hidden" name="email" id="email" value="{{ $email }}">
            <div class="text-center mb-4">
                <h4 class="d-inline px-3 bg-white position-relative">{{__('lang.otpVerify')}}</h4>
                <hr class="mt-2" style="border: 1px solid #000; width: 100%;">
            </div>
            <div id="error-alert" class="alert alert-danger" style="display: none;"></div>
            <div class="mb-3">
                <label for="otp" class="form-label">{{__('lang.otp')}}</label>
                <input type="text" class="form-control" id="otp" name="otp" placeholder="{{__('lang.otpPlaceholder')}}">
                <small id="otpError" class="error-message"></small>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary w-100" style="font-weight: bold" type="submit">{{__('lang.verifyOtpBtn')}}</button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('forgetpassword') }}">
                        <button class="btn btn-outline-primary w-100" style="font-weight: bold; border-width: 2px;" type="button">{{__('lang.back')}}</button>
                    </a>
                </div>
            </div>
        </form>    
    </div>
    
    <script>
        $('#verifyotp').on('submit', function(event) {
    event.preventDefault();

    const otpValue = $('#otp').val().trim();
    const emailValue = $('#email').val();  

    const isValid = checkInputs();
    if (isValid) {
        $.ajax({
            url: '/api/verifyOtp',  
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            data: JSON.stringify({
                email: emailValue,   
                otp: otpValue
            }),
            success: function(response) {
                
                window.location.href = `{{ route('reset_password', ':email') }}`.replace(':email', encodeURIComponent(emailValue));
                 
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    $('#error-alert').empty().text(xhr.responseJSON.message).append(
                        `<button type="button" class="btn btn-close btn-xs close_button float-end"></button>`
                    ).show();
                    setTimeout(function () {
                        $('#error-alert').hide().empty();
                    }, 3000);


                    $('.close_button').click(function() {
                        $('#error-alert').hide().empty();
                    }); 
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.otp) {
                        $('#otpError').text(errors.otp.join(', '));
                    }
                } else {
                    console.log("An unexpected error occurred.");
                }
            },

        });
    }
});

        function checkInputs() {
            const otp = $('#otp');
            const otpValue = otp.val().trim();
            let isValid = true;
            const otpPattern = /^\d{6}$/;

            if (otpValue === "") {
                setErrorFor(otp, 'OTP required');
                isValid = false;
            } else if (!otpPattern.test(otpValue)) {
                setErrorFor(otp, 'Enter a 6-digit number.');
                isValid = false;
            } else {
                setSuccessFor(otp);
            }
            
            return isValid;
        }

        function setErrorFor(input, message) {
            const formControl = input.parent();
            const small = formControl.find('.error-message');
            small.text(message);
            formControl.addClass('error');
        }

        function setSuccessFor(input) {
            const formControl = input.parent();
            const small = formControl.find('.error-message');
            small.text('');
            formControl.removeClass('error');
        }
    </script>
</body>
</html>
