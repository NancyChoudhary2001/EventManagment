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
            <h1 class="m-0">Branch</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('branch')}}">Branch</a></li>
                <li class="breadcrumb-item active" aria-current="page">Add Branch</li>
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
          <h4 class="card-header" >New Branch </h4>
          <div class="body m-3" style="padding: 60px;">
            <form  id="addBranch" >
                @csrf
            
                <div class="mb-3">
                  <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                  <small id="nameError" class="error-message"></small>
                </div>
      
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter address"></textarea>
                  <small id="addressError" class="error-message"></small>
                </div>
                
                <div class="mb-3">
                    <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                    <select class="form-select" id="country" name="country" >
                    <option value="" selected disabled>Select Country</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                    @endforeach
                    </select>
                    <small id="countryError" class="error-message"></small>
                    
                </div>
                
                <div class="mb-3">
                    <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                    <select class="form-select" id="state" name="state">
                    <option value="" selected disabled>Select State</option>
                    </select>
                    <small id="stateError" class="error-message"></small>
                </div>
                
                
                <div class="mb-3">
                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                    <select class="form-select" id="city" name="city">
                    <option value="" selected disabled>Select City</option>
                    </select>
                    <small id="cityError" class="error-message"></small>
                </div>
  
                <div class="mb-3">
                  <label for="pin" class="form-label">Zip/Postal Code <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="pin" name="pin" placeholder="Enter Zip/Postal Code">
                  <small id="pinError" class="error-message"></small>
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
       
        $('#state').prop('disabled', true);
        $('#city').prop('disabled', true);

        
        $('#country').change(function () {
            var country_id = $(this).val();

            if (country_id) {
           
            $('#state').prop('disabled', false).empty().append('<option value="" selected disabled>Select State</option>');
            $('#city').prop('disabled', true).empty().append('<option value="" selected disabled>Select City</option>');

           
            $.ajax({
                url: '/states/' + country_id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                $.each(data, function (key, value) {
                    $('#state').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                },
                error: function () {
                alert('Failed to fetch states. Please try again.');
                }
            });
            } else {
            $('#state').prop('disabled', true);
            $('#city').prop('disabled', true);
            }
        });

        
        $('#state').change(function () {
            var state_id = $(this).val();

            if (state_id) {
            
            $('#city').prop('disabled', false).empty().append('<option value="" selected disabled>Select City</option>');

           
            $.ajax({
                url: '/cities/' + state_id,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                $.each(data, function (key, value) {
                    $('#city').append('<option value="' + value.id + '">' + value.name + '</option>');
                });
                },
                error: function () {
                alert('Failed to fetch cities. Please try again.');
                }
            });
            } else {
            $('#city').prop('disabled', true);
            }
        });
      
        $('#addBranch').on('submit', function(event) {
    event.preventDefault();

   
    $('.error-message').text(''); 

    const nameValue = $('#name').val().trim();
    const addressValue = $('#address').val().trim();
    const countryValue = $('#country').val();
    const stateValue = $('#state').val();
    const cityValue = $('#city').val();
    const pinValue = $('#pin').val().trim();

    $.ajax({
        url: '/api/addbranch',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        contentType: 'application/json',
        data: JSON.stringify({
            name: nameValue,
            address: addressValue,
            country: countryValue,
            state: stateValue,
            city: cityValue,
            pincode: pinValue,
        }),
        success: function(response) {
            window.location.href = "{{ route('branch') }}";
        },
        error: function(xhr, status, error) {
    if (xhr.status === 412 && xhr.responseJSON) { 
        let messages = xhr.responseJSON.message; 
        $.each(messages, function(key, value) {
            if (key === 'name') {
                $('#nameError').show().text(value);
            }
            if (key === 'address') {
                $('#addressError').show().text(value);
            }
            if (key === 'country') {
                $('#countryError').show().text(value);
            }
            if (key === 'state') {
                $('#stateError').show().text(value);
            }
            if (key === 'city') {
                $('#cityError').show().text(value);
            }
            if (key === 'pincode') {
                $('#pinError').show().text(value);
            }
        });
    } else {
        console.error('Unexpected error:', xhr.responseText);
        alert('An unexpected error occurred. Please try again.');
    }
}

    });
});

      });

</script>
</body>
</html>
