@extends('admin.layouts.layout')
@section('content')<div class="content-header">
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
              <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
          </nav>
          
          {{-- <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">Library</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
          </nav> --}}
    </div>
    
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->

<section class="content" >

      <div class="container-fluid">
        <div class="card">
          <h4 class="card-header" >{{__('lang.user')}}
            <a href="{{ route('addUser') }}"><i class="fa-regular fa-plus float-right" style="cursor: pointer;" ></i></a>
          </h4>
          <div  class="body m-4">
          
            <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">{{__('lang.cmdlte')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    {{__('lang.cmdlteLine')}}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('lang.cancel')}}</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{__('lang.delete')}}</button>
                  </div>
                </div>
              </div>
            </div>

          <table id="ip-range-table" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>{{__('lang.firstName')}}</th>
                <th>{{__('lang.lastName')}}</th>
                <th>{{__('lang.email')}}</th>
                <th>{{__('lang.phoneNumber')}}</th>
                <th>{{__('lang.branch')}}</th>
                <th>{{__('lang.action')}}</th>
              </tr>
            </thead>
          </table>
        </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
</section>
@endsection
@section('scripts')
<script>
  $(document).ready(function () {
    $('#ip-range-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('getuser') }}",
        columns: [
            // { data: 'DT_RowIndex', name: 'DT_RowIndex' }, // Fixed name
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name' , name: 'last_name'},
            { data: 'email', name: 'email' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'branch', name: 'branch_id' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});
let selectedEmail = null; 

$(document).on('click', '.delete-btn', function () {
    selectedEmail = $(this).data('email');
    $('#deleteConfirmationModal').modal('show'); 
});

$('#confirmDeleteBtn').on('click', function () {
    if (selectedEmail) {
        $.ajax({
            url: '/users/delete',
            type: 'DELETE',
            data: { 
                email: selectedEmail, 
                _token: '{{ csrf_token() }}' 
            },
            success: function (response) {
                $('#deleteConfirmationModal').modal('hide'); 
                alert(response.success);
                $('#ip-range-table').DataTable().ajax.reload();
            },
            error: function (response) {
                $('#deleteConfirmationModal').modal('hide');
                alert(response.responseJSON.error);
            }
        });
    }
}); 

</script>
@endsection
