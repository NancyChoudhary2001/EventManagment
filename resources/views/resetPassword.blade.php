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
    <title>Reset Password</title>
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
        .error-message {
            visibility: visible;
            color: #e74c3c;  
            font-size: 0.875rem; 
        }

        .input-group-text {
            cursor: pointer;
        }
        .error-message {
        color: red;
        font-size: 0.875rem; 
    }
    </style>
</head>
<body>
    <div class="container">
        <form id="resetpassword" >
        @csrf
            <div class="text-center mb-4">
                <h4 class="d-inline px-3 bg-white position-relative">{{__('lang.resetPassword')}}</h4>
                <hr class="mt-2" style="border: 1px solid #000; width: 100%;">
            </div>
            <div id="success-alert" class="alert alert-success" style="display: none;"></div>

            <div id="error-alert" class="alert alert-danger" style="display: none;"></div>
            <div class="mb-3">
                <input type="hidden" id="email" name="email" value="{{ $email }}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">{{__('lang.password')}}</label> 
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="{{__('lang.passwordPlaceholder')}}">
                    <span class="input-group-text" id="togglePassword">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
                <small id="passwordError" class="error-message"></small>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">{{__('lang.confirmPassword')}}</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="{{__('lang.confirmPassword')}}">
                    <span class="input-group-text" id="toggleConfirmPassword">
                        <i class="bi bi-eye-slash" id="eyeConfirmIcon"></i>
                    </span>
                </div>
                <small id="confirmPasswordError" class="error-message"></small>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary w-100" style="font-weight: bold" type="submit">{{__('lang.reset')}}</button>
                </div>
            </div>
        </form>    
    </div>

    <script>
        $(document).ready(function() {
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
                passwordField.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });
    
            $('#toggleConfirmPassword').click(function() {
                const confirmPasswordField = $('#confirm_password');
                const type = confirmPasswordField.attr('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });
    
            $('#resetpassword').submit(function(e) {
                e.preventDefault(); 
                let valid = true;
    
                $('.error-message').text('');
    
                const password = $('#password').val();
                const email = $('#email').val();
                const confirmPassword = $('#confirm_password').val();
    
                if (password.length < 8) {
                    valid = false;
                    $('#passwordError').text('Password must be at least 8 characters long.');
                }
    
                if (password !== confirmPassword) {
                    valid = false;
                    $('#confirmPasswordError').text('Passwords do not match.');
                }
    
                if (valid) {
                    $.ajax({
                        url : '/api/resetPassword',
                        type: 'POST',
                        headers : {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        contentType: 'application/json',
                        data: JSON.stringify({
                            email : email,
                            password : password,
                            confirm_password : confirmPassword,
                        }),
                        success: function(response) {
                           
                            $('#success-alert').empty().text('Password reset successfully!').append(
                                `<button type="button" class="btn btn-close btn-xs close_button float-end"></button>`
                            ).show();

                            
                            setTimeout(function () {
                                window.location.href = "{{ route('login') }}";
                            }, 3000);

                     
                            $('.close_button').click(function() {
                                $('#success-alert').hide().empty();
                                window.location.href = "{{ route('login') }}"; 
                            });
},

                        error: function(xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                let errors = xhr.responseJSON.errors;
                                if (errors.password) {
                                    $('#passwordError').text(errors.password.join(', '));
                                }
                                if (errors.confirm_password) {
                                    $('#confirmPasswordError').text(errors.confirm_password.join(', '));
                                }
                            } else {
                                $('#error-alert').html("Invalid credentials or unexpected error.").show();
                            }
                        },
                    });
                }
            });
        });
        </script>
</body>
</html>
