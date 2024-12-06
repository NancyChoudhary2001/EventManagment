@extends('admin.index')

@section('content')
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">User</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{route('index')}}">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
          </nav>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content" >
<div class="container mt-4">
    <h2>Edit User</h2>
    <form action="{{ route('updateUser') }}" method="POST">
        @csrf
        
        <input type="hidden" name="id" value="{{ $user->id }}">

        
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" required>
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" required>
        </div>
        <div class="form-group">
            <label for="first_name">Email Address </label>
            <input type="email" name="email" class="form-control" value="{{ $user->email}}" required>
        </div>
        
        <div class="form-group">
            <label for="role">Role</label>
            <div class="d-flex">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="role" id="roleAdmin" value="admin" {{ $user->role == 'admin' ? 'checked' : '' }}>
                    <label class="form-check-label" for="roleAdmin">
                        Admin
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="roleUser" value="user" {{ $user->role == 'user' ? 'checked' : '' }}>
                    <label class="form-check-label" for="roleUser">
                        User
                    </label>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" class="form-control" value="{{ $user->phone_number }}" required>
        </div>
        
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" class="form-control" rows="3" required>{{ $user->address }}</textarea>
        </div>
        
        <div class="form-group">
            <label for="country">Country</label>
            <select name="country" id="country" class="form-select" required>
                <option value="" disabled>Select Country</option>
                @foreach ($countries as $country)
                    <option value="{{ $country->id }}" {{ $user->country == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="state">State</label>
            <select name="state" id="state" class="form-select" required>
                <option value="" disabled>Select State</option>
                @foreach ($states as $state)
                    <option value="{{ $state->id }}" {{ $user->state == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="city">City</label>
            <select name="city" id="city" class="form-select" required>
                <option value="" disabled>Select City</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ $user->city == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        
        <div class="form-group">
            <label for="pin">Pincode</label>
            <input type="text" name="pin" class="form-control" value="{{ $user->pincode }}" required>
        </div>
        
        <div class="form-group">
            <label for="branch">Branch</label>
            <select name="branch" id="branch" class="form-select" required>
                <option value="" disabled>Select Branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
</section>
@endsection
@section('scripts')
<script>
$(document).ready(function () {
   
    $('#country').on('change', function () {
        let countryId = $(this).val();

        $.get('/states/' + countryId, function (states) {
            $('#state').html('<option value="">Select State</option>');
            $('#city').html('<option value="">Select City</option>'); // Reset city

            states.forEach(function (state) {
                $('#state').append(`<option value="${state.id}">${state.name}</option>`);
            });
        });
    });

  
    $('#state').on('change', function () {
        let stateId = $(this).val();

        $.get('/cities/' + stateId, function (cities) {
            $('#city').html('<option value="">Select City</option>');

            cities.forEach(function (city) {
                $('#city').append(`<option value="${city.id}">${city.name}</option>`);
            });
        });
    });
    $('#city').on('change', function () {
    let cityId = $(this).val();

    
    $.get('/branches/' + cityId, function (branches) {
        $('#branch').html('<option value="">Select Branch</option>'); 

        branches.forEach(function (branch) {
            $('#branch').append(`<option value="${branch.id}">${branch.name}</option>`);
        });
    });
});

});

</script>
@endsection
