@extends('layouts.main')
  @section('content')

          <div class="content">
            <div class="container-fluid">
              <div class="row">

                <div class="col-md-12 ml-auto mr-auto">
                  <div class="students">
                    <h3 class="title text-center">Tutors</h3>
                    <br />
                    <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#search" role="tablist">
                          <i class="material-icons">search</i> Search
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#new" role="tablist">
                          <i class="material-icons">person_add</i> New Tutor
                        </a>
                      </li>
                    </ul>
                    <div class="tab-content tab-space tab-subcategories">
                      <div class="tab-pane active" id="search">
                        <div class="content">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="card">
                                  <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                      <i class="material-icons">assignment</i>
                                    </div>
                                    <h4 class="card-title">Tutors</h4>
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
                                            <th>Phone</th>
                                            <th hidden>Course Code</th>
                                            <th>Course</th>
                                            <th class="disabled-sorting text-center not-export-col">Actions</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                            <th>Tutor ID</th>
                                            <th>First Name</th>
                                            <th>Surname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th hidden>Course Code</th>
                                            <th>Course</th>
                                            <th class="text-center not-export-col">Actions</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                          @foreach ($tutors as $tutor)
                                            <tr>
                                              <td>{{$tutor->tutorId}}</td>
                                              <td>{{$tutor->firstname}}</td>
                                              <td>{{$tutor->surname}}</td>
                                              <td>{{$tutor->email}}</td>
                                              <td>{{$tutor->phone}}</td>
                                              <td hidden>{{$tutor->courseCode}}</td>
                                              <td>{{$tutor->description}}</td>
                                              <td class="text-right">
                                                <div class="float-right">
                                                  <button class="btn btn-danger btn-link show_confirm" rel="tooltip" data-placement="bottom" title="Delete">
                                                    <i class="material-icons">close</i>
                                                  </button>
                                                </div>
                                                <div class="float-right">
                                                  <button id="editButton" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                                    <i class="material-icons">edit</i>
                                                  </button>
                                                </div>
                                                <div class="float-right">
                                                  <button id="assignButton" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Assign units">
                                                    <i class="material-icons">assignment</i>
                                                  </button>
                                                </div>
                                              </td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>

                                    <!-- Assign modal start -->
                                    <form id="assignTutor" method="post" class="horizontal" action="{{ url('assign') }}">
                                      {{ csrf_field() }}
                                      
                                      <div id="assignModal" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Assign Units</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="card-body ">
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Tutor Id *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="tutorIdAssign" name="tutorId" required="true" hidden>
                                                      <input type="text" class="form-control" id="tutorIdAssign2" required="true" disabled>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> First Name *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="firstNameAssign" name="firstName" required="true" disabled>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Surname *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="surnameAssign" name="surname" required="true" disabled>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Units *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group">
                                                      <select id="selectUnits" class="selectpicker" name="unitCode[]" multiple data-style="select-with-transition" title="Select one or more units" required="true">
                                                        <option selected disabled>Select Units</option>
                                                      </select>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="category form-category">* Required fields</div>
                                              </div>;
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" id="saveChanges" class="btn btn-primary">Save changes</button>
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                    <!-- Assign modal end -->

                                    <!-- Edit modal start -->
                                    <form id="editTutor" method="post" class="horizontal" action="{{ url('/tutors/update') }}">
                                      {{ csrf_field() }}
                                      
                                      <div id="editModal" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Edit Tutor</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="card-body ">
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Tutor Id *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="tutorId" name="tutorId" required="true" hidden>
                                                      <input type="text" class="form-control" id="tutorId2" required="true" disabled>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> First Name *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="firstName" name="firstName" required="true">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Surname *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="surname" name="surname" required="true">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Email *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="email" name="email" required="true">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Phone *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="number" class="form-control" id="phone" name="phone" required="true">
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Course *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <select class="selectpicker" id="courseCode" name="courseCode" data-size="7" data-style="select-with-transition" title="Choose your course" required="true">
                                                        <option disabled selected>Select Course</option>
                                                        @foreach ($courses as $course)
                                                        <option value={{$course->courseCode}}>{{$course->description}}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="category form-category">* Required fields</div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="submit" id="saveChanges" class="btn btn-primary">Save changes</button>
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </form>
                                    <!-- Edit modal end -->

                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="new">
                        <div class="content">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-6 mr-auto ml-auto">
                                <div class="card ">
                                  <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                      <i class="material-icons">mail_outline</i>
                                    </div>
                                    <h4 class="card-title">New Tutor(s)</h4>
                                  </div>
                                  <div class="file-import col-md-12 mr-auto ml-auto">
                                    <h3 class="title text-center">Import Excel File</h3>
                                    <form id="importTutors" method="post" enctype="multipart/form-data" action="{{ url('/tutors/import') }}">
                                      {{ csrf_field() }}

                                        <div class="form-group form-file-upload form-file-multiple">
                                          <input type="file" name="excel" class="inputFileHidden">
                                          <div class="input-group">
                                              <input type="text" class="form-control inputFileVisible" placeholder="Select Excel File" required="true">
                                              <input type="submit" name="upload" class="btn btn-primary ml-3" value="Upload">
                                          </div>
                                        </div>
                                      </form>
                                      <div class="category form-category">* Use <a href="">this</a> sample file for uploads </div>
                                    </div>

                                    <h3 class="title text-center">Or Use Form</h3>

                                    <form id="addTutor" method="post" action="{{ url('/tutors/new') }}">
                                      {{ csrf_field() }}

                                      <div class="card-body ">
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Tutor Id *</label>
                                          <input type="text" class="form-control" id="tutorId" name="tutorId" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> First Name *</label>
                                          <input type="text" class="form-control" id="firstName" name="firstName" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Surname *</label>
                                          <input type="text" class="form-control" id="surname" name="surname" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Email Address *</label>
                                          <input type="email" class="form-control" id="email" name="email" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Phone Number *</label>
                                          <input type="number" class="form-control" id="phone" name="phone" minLength="10" maxLength="10" required="true">
                                        </div>
                                        <div class="form-group">
                                          <select class="selectpicker" name="courseCode" data-size="7" data-style="select-with-transition" title="Choose your course" required="true">
                                            <option disabled selected>Select Course</option>
                                            @foreach ($courses as $course)
                                            <option value={{$course->courseCode}}>{{$course->description}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                        <div class="category form-category">* Required fields</div>
                                      </div>
                                      <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Register</button>
                                      </div>
                                    </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
  @endsection
@section('scripts')
<script src="../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../assets/js/plugins/jquery.validate.min.js"></script>
<script src="../../assets/js/plugins/bootstrap-selectpicker.js"></script>
    <script type="text/javascript">
     $('.show_confirm').click(function(event) {
      event.preventDefault();

      swal({
        title: 'Warning!',
        text: "Are you sure you want to delete this record?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {

        if (willDelete) {

          $tr = $(this).closest('tr');
          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();

          //CORS
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });

          //Ajax request for getting units
          $.ajax({
              url: '/tutors/delete/' + data[0],
              type: 'post',
              data: {id: data[0]},
              success:function(response){

                Swal.fire(
                  'Deleted!',
                  'Your record has been deleted.',
                  'success'
                  ).then((result) => {
                  if (result.isConfirmed) {

                    location.reload();

                  }
                })

              }
          });
          }
      });
    });
    </script>
    <script>
      function setFormValidation(id) {
        $(id).validate({
          /* Add custom validation here -- rules,messages e.t.c */

          highlight: function(element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-danger');
            $(element).closest('.form-check').removeClass('has-success').addClass('has-danger');
          },
          success: function(element) {
            $(element).closest('.form-group').removeClass('has-danger').addClass('has-success');
            $(element).closest('.form-check').removeClass('has-danger').addClass('has-success');
          },
          errorPlacement: function(error, element) {
            $(element).closest('.form-group').append(error);
          },
        });
      }
      $(document).ready(function() {
        setFormValidation('#importTutors');
        setFormValidation('#addTutor');
        setFormValidation('#editTutor');
        setFormValidation('#assignTutor');
      });
    </script>
    <script>
      $(document).ready(function() {
        /** Datatables */
        $('#datatables').DataTable({
          dom: "<'row'<'col-md-6'B><'col-md-6'f>>" + "rt" + "<'row'<'col-md-6'i><'col-md-6'p>>",
          buttons: [
            {
              text: 'csv',
              extend: 'csvHtml5',
              className: 'btn-primary',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              }
            },
            {
              text: 'excel',
              extend: 'excelHtml5',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              }
            },
            {
              text: 'pdf',
              extend: 'pdfHtml5',
              className: "btn-primary",
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              },
              buttons:
                [{
                extend: "pdfHtml5", className: "btn-primary"
              }],
            },
            {
              text: 'print',
              extend: 'print',
              exportOptions: {
                columns: ':visible:not(.not-export-col)'
              }
            },
          ],
          "pagingType": "full_numbers",
          "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
          ],
          "bDestroy": true,
          responsive: true,
          language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
          }
        });

        var table = $('#datatables').DataTable();

        /** Assigning Units */
        table.on('click', '#assignButton', function() {

          $('#assignModal').modal('show'); //Show modal

          //Get the tutor details from table row
          $tr = $(this).closest('tr');
          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();
          
          //Assign values to modal form
          $('#tutorIdAssign').val(data[0]); //hidden input
          $('#tutorIdAssign2').val(data[0]); //Disabled input
          $('#firstNameAssign').val(data[1]);
          $('#surnameAssign').val(data[2]);
          

          //CORS
          $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          });
          
          //Ajax request for getting units
          $.ajax({
              url: "{{ url('/getUnits/{courseCode}') }}",
              type: 'get',
              data: {courseCode: data[5]},
              dataType: 'json',
              success:function(response){

                  var len = response.length;

                  $("#selectUnits").empty(); //Empty the select box

                  for( var i = 0; i<len; i++){
                    var unitCode = response[i]['unitCode'];
                    var description = response[i]['description'];
                      
                    $("#selectUnits").append(new Option(description, unitCode)); //Append select box with fetched units data

                    $('#selectUnits').selectpicker('refresh'); //Refresh bootstrap-selectpicker
                  }
              }
          });

        });

        /** Editing record */
        table.on('click', '#editButton', function() {

          $('#editModal').modal('show'); //Show modal

          //Get the tutor details from table row
          $tr = $(this).closest('tr');
          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();
          
          //Assign values to modal form
          $('#tutorId').val(data[0]); //Hidden input
          $('#tutorId2').val(data[0]); //Disabled input
          $('#firstName').val(data[1]);
          $('#surname').val(data[2]);
          $('#email').val(data[3]);
          $('#phone').val(data[4]);
          $('#courseCode').val(data[5]);

        });
      });
    </script>
@endsection


{{-- @if ($tutor->status == 'pending')
<div class="float-right">
  <form action="/approve/{{$tutor->tutorId}}" method="post">
    {{ csrf_field() }}

    <button type="submit" class="btn btn-info btn-link" rel="tooltip" data-placement="bottom" title="Approve">
      <i class="material-icons">check_box</i>
    </button>
  </form>
</div>
@endif --}}