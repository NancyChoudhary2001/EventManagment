<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Events</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, rgb(216, 46, 131), rgb(164, 24, 186)); 
        }

        .card-img-top {
            object-fit: contain;
            height: 200px;
            width: 100%;
        }

        .events-heading {
            text-align: center;
            margin-bottom: 30px;
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }

        .card-footer {
            text-align: center;
        }

        .btn-buy {
            background-color: #d82e83; 
            color: white;
        }
        .btn-buy:hover {
            background-color: #a418ba; 
        }

        .fa-user-icon {
            font-size: 16px;
            color: #6c757d; 
            background-color: #dee2e6; 
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-nav .nav-item {
            margin-left: 10px;
        }

        .nav-link {
            display: flex;
            align-items: center; 
        }

        .nav-link span {
            margin-right: 8px; 
        }
    </style>
</head>

<body>
    @include('admin.layouts.user-nav')   
      
    <div class="container mt-5">
        <h1 class="events-heading">Events</h1>

        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Purchase</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmationMessage">Are you sure you want to proceed with this purchase?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmBuy">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="message" class="alert d-none"></div>

        <div class="row">
            @foreach ($events as $event)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->name }}">
                    @else
                        <img src="https://via.placeholder.com/300" class="card-img-top" alt="No Image">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <p class="card-text">{{ Str::limit($event->description ?? 'No description available', 100) }}</p>
                        <p><strong>Price:</strong> 
                            {{ isset($event->price) ? $event->currency->currency . ' ' . number_format($event->price, 2) : 'N/A' }}

                        </p>
                        
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-buy buy-btn" data-id="{{ $event->id }}" 
                            data-price="{{ $event->price }}" 
                            data-currency="{{ $event->currency->currency }}"
                            data-name="{{ $event->name }}">Buy</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).on('click', '.buy-btn', function (e) {
            e.preventDefault();

            var eventId = $(this).data('id');
            var eventPrice = $(this).data('price');
            var eventName = $(this).data('name');
            var eventCurrency =$(this).data('currency');

            if (eventPrice > 0) {
                $('#confirmationMessage').text(`This event costs ${eventCurrency} ${eventPrice}. Do you want to proceed to the payment page?`);
            } else {
                $('#confirmationMessage').text(`Do you want to proceed with buying the event "${eventName}" for free?`);
            }

            $('#confirmationModal').modal('show');

            $('#confirmBuy').off('click').on('click', function () {
                $('#confirmationModal').modal('hide');

                if (eventPrice > 0) {
                    $.ajax({
                        url: '/buy-item',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            event_id: eventId
                        },
                        success: function (response) {
                            // showMessage('Gateway is not Implemented. Contect Admin', 'alert-danger');
                        },
                        error: function (xhr) {
                            var errorMessage = 'An error occurred. Please try again.';
                            if (xhr.status === 401) {
                                errorMessage = 'You need to log in to purchase this item.';
                                window.location.href = '/login';
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showMessage(errorMessage, 'alert-danger');
                        }
                    });
                } else {
                    $.ajax({
                        url: '/buy-item',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            event_id: eventId
                        },
                        success: function (response) {
                            showMessage('Event successfully purchased!', 'alert-success');
                        },
                        error: function (xhr) {
                            var errorMessage = 'An error occurred. Please try again.';
                            if (xhr.status === 401) {
                                errorMessage = 'You need to log in to purchase this item.';
                                window.location.href = '/login';
                            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            showMessage(errorMessage, 'alert-danger');
                        }
                    });
                }
            });
        });

        function showMessage(message, alertClass) {
            $('#message').removeClass('d-none').addClass(alertClass).text(message);
            $('html, body').animate({ scrollTop: 0 }, 'slow'); 
            setTimeout(function () {
                $('#message').addClass('d-none').removeClass(alertClass);
            }, 3000);
        }
    </script>
</body>
</html>
