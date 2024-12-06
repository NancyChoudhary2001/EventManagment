<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Purchased Events</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, rgb(216, 46, 131), rgb(164, 24, 186)); 
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: #ffffff; 
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #8e2b82; 
        }
        .table {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th {
            background-color: #8e2b82; 
            /* color: #fff;  */
            text-align: center;
        }
        td {
            text-align: center;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .no-records {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    @include('admin.layouts.user-nav')

    <div class="container">
        <h1>User Purchased Events</h1>
        
        @if ($userEvents->isEmpty())
            <p class="no-records">No events purchased yet.</p>
        @else
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <th>Event Name</th>
                        <th>Price</th>
                        <th>Purchased At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($userEvents as $index => $userEvent)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $userEvent->event->name }}</td> 
                            <td>{{ $userEvent->event->currency->currency}} {{ number_format($userEvent->event->price, 2) }}</td> 
                            <td>{{ $userEvent->created_at->format('d/m/Y') }}</td> 
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
