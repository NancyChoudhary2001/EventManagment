<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
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
        .error small{
            visibility: visible;
            color:#e74c3c;
        }
        .error-message {
            color: red;
            font-size: 0.875rem; 
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="login">
        @csrf
            <div class="text-center mb-4">
                <h4 class="d-inline px-3 bg-white position-relative">{{__('lang.login')}}</h4>
                <hr class="mt-2" style="border: 1px solid #000; width: 100%;">
            </div>
            <div id="error-alert" class="alert alert-danger" style="display: none;"></div>
            <div class="mb-3">
                <label for="email" class="form-label">{{__('lang.email')}}</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="{{__('lang.emailPlaceholder')}}">
                <small id="emailError" class="error-message"></small>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{__('lang.password')}}</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"> 
                    <span class="input-group-text" id="togglePassword">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
                    <small id="passwordError" class="error-message"></small>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary w-100" style="font-weight: bold" type="submit">{{__('lang.login')}}</button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('signup') }}">
                        <button class="btn btn-outline-primary w-100" style="font-weight: bold; border-width: 2px;" type="button">{{__('lang.signup')}}</button>
                    </a>
                </div>
            </div>
            <div class="col text-center mt-3">
                <p style="margin-bottom: 5px; font-size: 14px; color: #555;">
                    {{__('lang.fpLine')}}
                </p>
                <a href="{{ route('forgetpassword')}}" style="color: #007bff; text-decoration: underline; font-weight: 600;">
                    {{__('lang.click')}}
                </a>
            </div>
        </form>    
    </div>

    <script>
        
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const eyeIcon = $('#eyeIcon');
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                eyeIcon.removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                passwordField.attr('type', 'password');
                eyeIcon.removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });

        $('#login').on('submit', function(event) {
            event.preventDefault();
    
            const emailValue = $('#email').val().trim();
            const passwordValue = $('#password').val().trim();
            
            const isValid = checkInputs();
            
            if (isValid) {
                $.ajax({
                    url: '/api/login',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        email: emailValue,
                        password: passwordValue
                    }),
                    success: function(response) {
                        console.log(response);
                        if (response.role === 'admin') {
                            window.location.href = "{{ env('APP_URL') }}/dashboard";
                        } else if (response.role === 'user') {
                            window.location.href = "{{ env('APP_URL') }}/eventuser";
                        } else {
                            
                            window.location.href = "{{ env('APP_URL') }}/login";
                        }
                        // alert('succes');
                        // window.location.href =  "{{env('APP_URL')}}/index";
                        // window.location.href = "{{ route('index')}}";
                    },
                    error:function(xhr) {
                        if(xhr.responseJSON && xhr.responseJSON.errors){
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#emailError').text(errors.email.join(',' ));
                            }
                            if (errors.password) {
                                $('#passwordError').text(errors.password.join(', '));
                            }
                        } else {
                            $('#error-alert').empty().text(xhr.responseJSON.message).append(
                        `<button type="button" class="btn btn-close btn-xs close_button float-end"></button>`
                    ).show();

                   
                    setTimeout(function () {
                        $('#error-alert').hide().empty();
                    }, 3000);

                    
                    $('.close_button').click(function() {
                        $('#error-alert').hide().empty();
                    });
                        }
                    }
                });
            }
        });

        function checkInputs() {
            let isValid = true;

            const emailValue = $('#email').val().trim();
            const passwordValue = $('#password').val().trim();
    
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailValue === "") {
                setErrorFor($('#email'), 'Email required');
                isValid = false;
            } else if (!emailPattern.test(emailValue)) {
                setErrorFor($('#email'), 'Please enter a valid email address.');
                isValid = false;
            } else {
                setSuccessFor($('#email'));
            }

            if (passwordValue === "") {
                setErrorFor($('#password'), 'Password required');
                isValid = false;
            } else {
                setSuccessFor($('#password'));
            }

            return isValid;
        }

        function setErrorFor(input, message) {
    const formControl = input.closest('.mb-3');
    const small = formControl.find('.error-message');
    small.text(message);
    formControl.addClass('error');
}

function setSuccessFor(input) {
    const formControl = input.closest('.mb-3');
    const small = formControl.find('.error-message');
    small.text('');
    formControl.removeClass('error');
}

    </script>
</body>    
</html>
