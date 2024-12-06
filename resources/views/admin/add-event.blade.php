<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <title>Admin Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
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
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- {{-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> --}} -->

  <!-- Navbar -->
   @include('admin.layouts.nav-top')
  <!-- /.navbar -->
  
  <!-- Main Sidebar Container -->
  @include('admin.layouts.side-nav')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Event</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('events')}}">Event</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Event</li>
              </ol>
            </nav>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content" >
    <section class="content" >
      <div class="container-fluid">
        <div class="card">
          <h4 class="card-header" style="font-weight: normal;" >New Event </h4>
          <div class="body" style="padding: 30px;">
            <div id="successMessage" class="alert alert-success" style="display: none;"></div>
            <form  id="addBranch" enctype="multipart/form-data" >
                @csrf
            
                <div class="mb-3">
                  <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                  <small id="firstNameError" class="error-message"></small>
                </div>
      
                <div class="mb-3">
                  <label for="description" class="form-label">Desciption <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="description" name="description" rows="3" placeholder="Details"></textarea>
                  <small id="descriptionError" class="error-message"></small>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Visibilty <span class="text-danger">*</span></label>
                    
                    <small id="roleError" class="error-message"></small>
                    <div class="d-flex"> 
                        <div class="form-check me-3">
                            <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin">
                            <label class="form-check-label" for="roleAdmin">
                                Admin
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="roleUser" value="user">
                            <label class="form-check-label" for="roleUser">
                                User
                            </label>
                        </div>
                      </div>
                      <small id="roleError" class="error-message"></small>
                  </div>

                  <div class="row mb-3">
                    
                    <div class="col-3">
                        <label for="currency" class="form-label">Currency <span class="text-danger">*</span></label>
                        <select id="currency" name="currency" class="form-select">
                            <option value="" selected disabled>Select Country</option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->currency }}</option>
                                @endforeach
                        </select>
                        <small id="currencyError" class="error-message"></small>
                    </div>
                    
                  
                    <div class="col-9">
                        <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter amount">
                        <small id="priceError" class="error-message"></small>
                    </div>
                    </div>

                    <div class="mb-3">
                      <label for="event_image" class="form-label">Event Image</label>
                      <input type="file" class="form-control" id="event_image" name="event_image" accept="image/*">
                    </div>

                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
  <!-- Footer -->
  @include('admin.layouts.footer');

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
 <!-- Include Bootstrap JS -->
{{-- <!-- <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script> -->
<!-- jQuery UI 1.11.4 --> --}}
<script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('admin/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
{{-- <!-- AdminLTE for demo purposes -->
<script src="{{ asset('admin/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admin/dist/js/pages/dashboard.js') }}"></script> --}}

<script>
    
      $(document).ready(function () {
    $('#addBranch').on('submit', function (event) {
        event.preventDefault();

        // Clear previous error messages
        $('.error-message').text('');

        const nameValue = $('#name').val().trim();
        const descriptionValue = $('#description').val().trim();
        const roleValue = $('input[name="role"]:checked').val() ;
        const currencyValue = $('#currency').val();
        const priceValue = $('#price').val();
        const eventImage = $('#event_image')[0]?.files[0];

        // Create FormData object
        const formData = new FormData();
        formData.append('name', nameValue);
        formData.append('description', descriptionValue);
        formData.append('role', roleValue);
        formData.append('currency', currencyValue);
        formData.append('price', priceValue);

        if (eventImage) {
            formData.append('event_image', eventImage);
        }

        // Send AJAX request
        $.ajax({
            url: '/api/addevent',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            contentType: false,
            processData: false,
            data: formData,
            success: function (response) {
                $('#successMessage').text(response.message).show();
                setTimeout(function () {
                    $('#successMessage').fadeOut();
                }, 3000);
                $('form')[0].reset();
            },
            error: function (xhr, status, error) {
    if (xhr.status === 412) {
        const errors = xhr.responseJSON.message; // Access "message" field for errors
        if (errors) {
            if (errors.name) {
                $('#name').next('.error-message').text(errors.name);
            }
            if (errors.description) {
                $('#description').next('.error-message').text(errors.description);
            }
            if (errors.role) {
                $('#roleError').show('.error-message').text(errors.role);
            }
            if (errors.currency) {
                $('#currency').next('.error-message').text(errors.currency);
            }
            if (errors.price) {
                $('#price').next('.error-message').text(errors.price);
            }
        }
    } else {
        console.error('Unexpected error:', xhr.responseText);
        alert('An error occurred. Please try again.');
    }
}

        });
    });
});

  </script>
  
</body>
</html>
