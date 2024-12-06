@extends('admin.layouts.layout')
@section('content')
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
              <li class="breadcrumb-item active" aria-current="page">Event</li>
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
        <h4 class="card-header">New Event
            <a href="{{ route('addevent') }}"><i class="fa-regular fa-plus float-right" style="cursor: pointer;"></i></a>
        </h4>
        <div class="body m-4">
            
            <div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="deleteEventModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    Are you sure you want to delete this event?
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteEventBtn">Delete</button>
                    </div>
                </div>
                </div>
            </div>
  
            <table id="event-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        
        $('#event-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('getevent') }}",
            columns: [
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'price', name: 'price' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            language: {
                emptyTable: "No events available at the moment."
            }
        });

        let selectedEventName = null;


$(document).on('click', '.delete-btn', function () {
    selectedEventName = $(this).data('id'); 
    console.log('Selected event for deletion:', selectedEventName);
    $('#deleteEventModal').modal('show'); 
});


$('#confirmDeleteEventBtn').on('click', function () {
    if (selectedEventName) {
        $.ajax({
            url: '/events/delete/' + selectedEventName, 
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function (response) {
                $('#deleteEventModal').modal('hide'); 
                alert(response.message);
                $('#event-table').DataTable().ajax.reload(); 
            },
            error: function (xhr, status, error) {
                $('#deleteEventModal').modal('hide'); 
                alert("Error: " + xhr.responseText);
            }
        });
    }
});

    });
</script>
@endsection


