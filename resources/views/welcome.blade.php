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
    {{-- <link rel="stylesheet" href="D://Ladybird/LaravelProject/Laravel-Project/resources/css/ext.css"> --}}
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
    <div class="dropdown" style="position: absolute; top: 10px; right: 10px;">
        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            {{ App::getLocale() }}
        </button>
        <ul class="dropdown-menu " aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="/setlang/En">English</a></li>
            <li><a class="dropdown-item" href="/setlang/Fr">French</a></li>
            <li><a class="dropdown-item" href="/setlang/KO">Korean</a></li>
        </ul>
    </div>
    <div class="container">
        <form id="signup">
        @csrf
            {{-- <div>
                <p>{{ $response->message }}</p>
            </div> --}}
            <div class="text-center mb-4">
                <h4 class="d-inline px-3 bg-white position-relative">{{__('lang.register')}}</h4>
                <hr class="mt-2" style="border: 1px solid #000; width: 100%;">
            </div>
            <div id="error-alert" class="alert alert-danger" style="display: none;"></div>
            <div class="row">
                <div class="col">
                    <label for="firstname" class="form-label">{{__('lang.firstName')}}</label>   
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="{{__('lang.firstName')}}" aria-label="First name">
                    <small id="firstNameError" class="error-message"></small>
                </div>
                <div class="col mb-3">
                    <label for="lastname" class="form-label">{{__('lang.lastName')}}</label>
                    <input type="text" class="form-control" id="lastname" name="lastname"  placeholder="{{__('lang.lastName')}}" aria-label="Last name">
                    <small id="lastNameError" class="error-message"></small>
                </div>
            </div>
            <div class="mb-3 ">
                <label for="email" class="form-label">{{__('lang.email')}}</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="{{__('lang.emailPlaceholder')}}">
                <small id="emailError" class="error-message"></small>
            </div>
            <div class="mb-3">
                <label for="phonenumber" class="form-label">{{__('lang.phoneNumber')}}</label>
                <input type="tel" class="form-control" id="phonenumber" name="phonenumber" placeholder="{{__('lang.phonePlaceholder')}}"> 
                <small id="phoneError" class="error-message"></small>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button class="btn btn-primary w-100" style="font-weight: bold" type="submit">{{__('lang.signup')}}</button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('login') }}">
                        <button class="btn btn-outline-primary w-100" style="font-weight: bold; border-width: 2px;" type="button">{{__('lang.login')}}</button>
                    </a>
                </div>
            </div>
        </form>    
    </div>
    <script>
        $('#signup').on('submit', function(event) {
            event.preventDefault();
    
            $('#firstNameError').text('');
            $('#lastNameError').text('');
            $('#emailError').text('');
            $('#phoneError').text('');
    
           
            const firstnameValue = $('#firstname').val().trim();
            const lastnameValue = $('#lastname').val().trim();
            const emailValue = $('#email').val().trim();
            const phonenumberValue = $('#phonenumber').val().trim();
    
            const isValid = checkInputs();
    
            if (isValid) {
                $.ajax({
                    url: '/api/signup',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        firstname: firstnameValue,
                        lastname: lastnameValue,
                        email: emailValue,
                        phonenumber: phonenumberValue
                    }),
                    success: function(response) {
                        window.location.href = "{{ route('login') }}";
                    },
                    error: function(error) {
                        if(error.status ===412 && error.responseJSON){
                            let messages = error.responseJSON.message;
                            $.each(messages, function(key,value){
                                if(key === 'firstname'){
                                    $('#firstError').show().text(value);
                                }
                                if(key==='lastname'){
                                    $('#lastError').show().text(value);
                                }
                                if(key==='email'){
                                    $('#emailError').show().text(value);
                                }
                                if(key==='phonenumber'){
                                    $('#phoneError').show().text(value);
                                }
                            });
                        }
                    },
                });
            }
    
            function checkInputs() {
                const namePattern = /^[a-zA-Z ]+$/;
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const phonenumberPattern = /^\d{10}$/;
                let isValid = true;
    
                if (firstnameValue === "") {
                    setErrorFor($('#firstname'), 'First name required');
                    isValid = false;
                } else if (!namePattern.test(firstnameValue)) {
                    setErrorFor($('#firstname'), 'Name must contain only characters');
                    isValid = false;
                } else {
                    setSuccessFor($('#firstname'));
                }
    
                if (lastnameValue === "") {
                    setErrorFor($('#lastname'), 'Last name required');
                    isValid = false;
                } else if (!namePattern.test(lastnameValue)) {
                    setErrorFor($('#lastname'), 'Name must contain only characters');
                    isValid = false;
                } else {
                    setSuccessFor($('#lastname'));
                }
    
                if (emailValue === "") {
                    setErrorFor($('#email'), 'Email required');
                    isValid = false;
                } else if (!emailPattern.test(emailValue)) {
                    setErrorFor($('#email'), 'Please enter a valid email address.');
                    isValid = false;
                } else {
                    setSuccessFor($('#email'));
                }
    
                if (phonenumberValue === "") {
                    setErrorFor($('#phonenumber'), 'Phone Number required');
                    isValid = false;
                } else if (!phonenumberPattern.test(phonenumberValue)) {
                    setErrorFor($('#phonenumber'), 'Phone number must be exactly 10 digits.');
                    isValid = false;
                } else {
                    setSuccessFor($('#phonenumber'));
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
        });
    </script>    
</body>
</html>