@extends('layouts.main')
  @section('content')
  
          <div class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12 ml-auto mr-auto">
                  <div class="students">
                    <h3 class="title text-center">Students</h3>
                    <br />
                    <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#search" role="tablist">
                          <i class="material-icons">search</i> Search
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#new" role="tablist">
                          <i class="material-icons">person_add</i> New Student
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
                                    <h4 class="card-title">Students</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="toolbar">
                                      <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                          <tr>
                                            <th>Student ID</th>
                                            <th>First Name</th>
                                            <th>Surname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th hidden>Course Code</th>
                                            <th>Course</th>
                                            <th>Study Period</th>
                                            <th class="disabled-sorting text-right not-export-col">Actions</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                            <th>Student ID</th>
                                            <th>First Name</th>
                                            <th>Surname</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th hidden>Course Code</th>
                                            <th>Course</th>
                                            <th>Study Period</th>
                                            <th class="text-right not-export-col">Actions</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                          @foreach ($students as $student)
                                            <tr>
                                              <td>{{$student->studentId}}</td>
                                              <td>{{$student->firstname}}</td>
                                              <td>{{$student->surname}}</td>
                                              <td>{{$student->email}}</td>
                                              <td>{{$student->phone}}</td>
                                              <td hidden>{{$student->courseCode}}</td>
                                              <td>{{$student->description}}</td>
                                              <td>{{$student->studyPeriod}}</td>
                                              <td class="text-right">
                                                <div class="float-right">
                                                  <form action="" method="post">
                                                    {{ csrf_field() }}
                    
                                                    <button type="submit" class="btn btn-danger btn-link" rel="tooltip" data-placement="bottom" title="Delete">
                                                      <i class="material-icons">close</i>
                                                    </button>
                                                  </form>
                                                </div>
                                                <div class="float-right">
                                                  <button id="editButton" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                                    <i class="material-icons">edit</i>
                                                  </button>
                                                </div>
                                              </td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>

                                    <!-- Edit modal start -->
                                    <form id="editStudent" method="post" class="horizontal" action="{{ url('/students/update') }}">
                                      {{ csrf_field() }}
                                      
                                      <div id="editModal" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Edit Student</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="card-body ">
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Student Id *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="studentId" name="studentId" required="true" hidden>
                                                      <input type="text" class="form-control" id="studentId2" required="true" disabled>
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
                                                      <select class="selectpicker" id="courseCode" name="courseCode" data-size="7" data-style="select-with-transition" title="Choose course" required="true">
                                                        <option disabled selected>Select Course</option>
                                                        @foreach ($courses as $course)
                                                        <option value={{$course->courseCode}}>{{$course->description}}</option>
                                                        @endforeach
                                                      </select>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Study Period *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <select class="selectpicker" id="studyPeriod" name="studyPeriod" data-size="7" data-style="select-with-transition" title="Choose study period" required="true">
                                                        <option disabled selected>Select Course</option>
                                                        <option value="Y1S1">Year 1 Semester 1</option>
                                                        <option value="Y1S2">Year 1 Semester 2</option>
                                                        <option value="Y2S1">Year 2 Semester 1</option>
                                                        <option value="Y2S2">Year 2 Semester 2</option>
                                                        <option value="Y3S1">Year 3 Semester 1</option>
                                                        <option value="Y3S2">Year 3 Semester 2</option>
                                                        <option value="Y4S1">Year 4 Semester 1</option>
                                                        <option value="Y4S2">Year 4 Semester 2</option>
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
                                    <h4 class="card-title">New Student(s)</h4>
                                  </div>
                                  <div class="file-import col-md-12 mr-auto ml-auto">
                                    <h3 class="title text-center">Import Excel File</h3>
                                    <form id="importStudents" method="post" enctype="multipart/form-data" action="{{ url('/students/import') }}">
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

                                    <form id="addStudent" method="post" action="{{ url('/students/new') }}">
                                      {{ csrf_field() }}

                                      <div class="card-body ">
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Student Id *</label>
                                          <input type="text" class="form-control" id="studentId" name="studentId" required="true">
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
                                        <div class="form-group">
                                          <select class="selectpicker" name="studyPeriod" data-size="7" data-style="select-with-transition" title="Choose your course" required="true">
                                            <option disabled selected>Select Course</option>
                                            <option value="Y1S1">Year 1 Semester 1</option>
                                            <option value="Y1S2">Year 1 Semester 2</option>
                                            <option value="Y2S1">Year 2 Semester 1</option>
                                            <option value="Y2S2">Year 2 Semester 2</option>
                                            <option value="Y3S1">Year 3 Semester 1</option>
                                            <option value="Y3S2">Year 3 Semester 2</option>
                                            <option value="Y4S1">Year 4 Semester 1</option>
                                            <option value="Y4S2">Year 4 Semester 2</option>
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
        setFormValidation('#importStudents');
        setFormValidation('#addStudent');
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

        /** Editing record */
        table.on('click', '#editButton', function() {

          $('#editModal').modal('show'); //Show modal

          //Get the tutor details from table row
          $tr = $(this).closest('tr');
          var data = $tr.children("td").map(function(){
            return $(this).text();
          }).get();
          
          //Assign values to modal form
          $('#studentId').val(data[0]); //Hidden input
          $('#studentId2').val(data[0]); //Disabled input
          $('#firstName').val(data[1]);
          $('#surname').val(data[2]);
          $('#email').val(data[3]);
          $('#phone').val(data[4]);
          $('#courseCode').val(data[5]);
          $('#studyPeriod').val(data[7]);

        });
      });
    </script>
@endsection