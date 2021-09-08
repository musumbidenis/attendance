@extends('layouts.main')
  @section('content')
  
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header card-header-primary card-header-icon">
                      <div class="card-icon">
                        <i class="material-icons">assignment</i>
                      </div>
                      <h4 class="card-title">DataTables.net</h4>
                    </div>
                    <div class="card-body">
                      <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                      </div>
                <div class="material-datatables">
                  <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                      <tr>
                        <th>Tutor ID</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="disabled-sorting text-right">Actions</th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr>
                        <th>Tutor ID</th>
                        <th>First Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                      </tr>
                    </tfoot>
                    <tbody>
                      @foreach ($tutors as $tutor)
                        <tr>
                          <td>{{$tutor->tutorId}}</td>
                          <td>{{$tutor->firstname}}</td>
                          <td>{{$tutor->surname}}</td>
                          <td>{{$tutor->email}}</td>
                          <td>{{$tutor->courseCode}}</td>
                          <td>{{$tutor->role}}</td>
                          <td>{{$tutor->status}}</td>
                          <td class="text-right">
                            <div class="float-right">
                              <form action="" method="post">
                                {{ csrf_field() }}

                                <button type="button" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Delete">
                                  <i class="material-icons">close</i>
                                </button>
                              </form>
                            </div>
                            <div class="float-right">
                              <form action="" method="post">
                                {{ csrf_field() }}

                                <button type="button" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                  <i class="material-icons">edit</i>
                                </button>
                              </form>
                            </div>
                            @if ($tutor->status == 'pending')
                            <div class="float-right">
                              <form action="" method="post">
                                {{ csrf_field() }}
                                
                                <button type="button" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Approve">
                                  <i class="material-icons">check_box</i>
                                </button>
                              </form>
                            </div>
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
  @endsection
@section('scripts')
<script src="../../assets/js/plugins/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#datatables').DataTable({
          "pagingType": "full_numbers",
          "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          responsive: true,
          language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
          }
        });

        var table = $('#datatable').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
          $tr = $(this).closest('tr');
          var data = table.row($tr).data();
          alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
          $tr = $(this).closest('tr');
          table.row($tr).remove().draw();
          e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
          alert('You clicked on Like button');
        });
      });
    </script>
@endsection