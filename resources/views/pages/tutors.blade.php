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
                        <a class="nav-link" data-toggle="tab" href="#search" role="tablist">
                          <i class="material-icons">search</i> Search
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#new" role="tablist">
                          <i class="material-icons">person_add</i> New Tutor
                        </a>
                      </li>
                    </ul>
                    <div class="tab-content tab-space tab-subcategories">
                      <div class="tab-pane" id="search">
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
                                            <th>Course</th>
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
                                                  <form action="" method="post">
                                                    {{ csrf_field() }}
                    
                                                    <button type="submit" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
                                                      <i class="material-icons">edit</i>
                                                    </button>
                                                  </form>
                                                </div>
                                                
                                              </td>
                                            </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane active" id="new">
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
      });
    </script>
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