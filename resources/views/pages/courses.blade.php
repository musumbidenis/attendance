@extends('layouts.main')
  @section('content')

          <div class="content">
            <div class="container-fluid">
              <div class="row">

                <div class="col-md-12 ml-auto mr-auto">
                  <div class="students">
                    <h3 class="title text-center">Courses</h3>
                    <br />
                    <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#search" role="tablist">
                          <i class="material-icons">search</i> Search
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#new" role="tablist">
                          <i class="material-icons">person_add</i> New Course
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
                                    <h4 class="card-title">Courses</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="toolbar">
                                      <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                          <tr>
                                            <th>Course Code</th>
                                            <th>Description</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                            <th>Course Code</th>
                                            <th>Description</th>
                                            <th class="text-right">Actions</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                          @foreach ($courses as $course)
                                            <tr>
                                              <td>{{$course->courseCode}}</td>
                                              <td>{{$course->description}}</td>
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
                                                    <button id="editButton" type="submit" class="btn btn-success btn-link" rel="tooltip" data-placement="bottom" title="Edit">
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
                                    <form id="editCourse" method="post" class="horizontal" action="{{ url('/courses/update') }}">
                                      {{ csrf_field() }}
                                      
                                      <div id="editModal" class="modal" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Edit Course</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="card-body ">
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Course Code *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="courseCode" name="courseCode" required="true" hidden>
                                                      <input type="text" class="form-control" id="courseCode2" required="true" disabled>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <label class="col-md-3 col-form-label"> Description *</label>
                                                  <div class="col-md-9">
                                                    <div class="form-group has-default">
                                                      <input type="text" class="form-control" id="description" name="description" required="true">
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
                                    <h4 class="card-title">New Course(s)</h4>
                                  </div>
                                  <div class="file-import col-md-12 mr-auto ml-auto">

                                    <form id="addCourse" method="post" class="horizontal" action="{{ url('/courses/new') }}">
                                      {{ csrf_field() }}

                                      <div class="card-body ">
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Course Code *</label>
                                          <input type="text" class="form-control" id="courseCode" name="courseCode" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Description *</label>
                                          <input type="text" class="form-control" id="description" name="description" required="true">
                                        </div>
                                        <div class="category form-category">* Required fields</div>
                                      </div>
                                      <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Save</button>
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
        setFormValidation('#addCourse');
        setFormValidation('#editCourse');
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
          "bDestroy": true,
          responsive: true,
          language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
          }
        });
      });

      var table = $('#datatables').DataTable();

      // Edit record
      table.on('click', '#editButton', function() {

        $('#editModal').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function(){
          return $(this).text();
        }).get();
        
        $('#courseCode').val(data[0]);
        $('#courseCode2').val(data[0]);
        $('#description').val(data[1]);

      });

    </script>
@endsection