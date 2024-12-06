<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h5>Hello, {{ $fullname }}</h5>
    <p>You have successfully created an account on our website. Your details are:</p>
    <p>Eamil: {{$user['email']}}</p>
    <p><strong>Password:</strong style="font-size: 20px;"> {{ $password }}</p>
    <p>Your account has been created successfully. Click <a href="{{ route('login')}}">Here</a> to login.</p>
</body>
</html>