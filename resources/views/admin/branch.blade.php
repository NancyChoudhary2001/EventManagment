@extends('admin.layouts.layout')
@section('content')
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
            <li class="breadcrumb-item active" aria-current="page">Branch</li>
          </ol>
        </nav>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content" >
<div class="container-fluid">
  <div class="card">
    <h4 class="card-header" >Branches
      <a href="{{ route('addBranch') }}"><i class="fa-regular fa-plus float-right" style="cursor: pointer;"></i></a>
    </h4>
    <div  class="body m-4">
    
      <div class="modal fade" id="deleteBranchModal" tabindex="-1" role="dialog" aria-labelledby="deleteBranchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteBranchModalLabel">Confirm Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this branch?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-danger" id="confirmDeleteBranchBtn">Delete</button>
            </div>
          </div>
        </div>
      </div>

    <table id="branch-table" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Address</th>
          <th>State</th>
          <th>City</th>
          <th>Pin</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
  </div>
</div><!-- /.container-fluid -->
</section>
@endsection
@section('scripts')
<script>
  $(document).ready(function () {
    $('#branch-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getbranch') }}",
        columns: [
            // { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Fixed name
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'state', name: 'state' },
            { data: 'city', name: 'city' },
            { data: 'pincode', name: 'pincode'},
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
    let selectedBranchName = null; 


$(document).on('click', '.delete-btn', function () {
    selectedBranchName = $(this).data('id'); 
    console.log('Selected branch for deletion:', selectedBranchName);
    $('#deleteBranchModal').modal('show'); 
});


$('#confirmDeleteBranchBtn').on('click', function () {
    if (selectedBranchName) {
        $.ajax({
            url: '/branches/delete/' + selectedBranchName,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
                $('#deleteBranchModal').modal('hide'); 
                if (response.success) {
                    alert(response.success);
                    $('#branch-table').DataTable().ajax.reload(); 
                } else {
                    alert(response.error);
                }
            },
            error: function (xhr) {
                $('#deleteBranchModal').modal('hide'); 
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alert(xhr.responseJSON.error);
                } else {
                    alert('An error occurred while deleting the branch.');
                }
            }
        });
    }
});


});
</script>
@endsection

