@extends('layouts.main')
  @section('content')

          <div class="content">
            <div class="container-fluid">
              <div class="row">

                <div class="col-md-12 ml-auto mr-auto">
                  <div class="students">
                    <h3 class="title text-center">Units</h3>
                    <br />
                    <ul class="nav nav-pills nav-pills-info nav-pills-icons justify-content-center" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#search" role="tablist">
                          <i class="material-icons">search</i> Search
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#new" role="tablist">
                          <i class="material-icons">person_add</i> New Unit
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
                                    <h4 class="card-title">Units</h4>
                                  </div>
                                  <div class="card-body">
                                    <div class="toolbar">
                                      <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                      <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                          <tr>
                                            <th>Unit Code</th>
                                            <th>Description</th>
                                            <th>Course</th>
                                            <th>Study Period</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                            <th>Unit Code</th>
                                            <th>Description</th>
                                            <th>Course</th>
                                            <th>Study Period</th>
                                            <th class="text-right">Actions</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                          @foreach ($units as $unit)
                                            <tr>
                                              <td>{{$unit->unitCode}}</td>
                                              <td>{{$unit->description}}</td>
                                              <td>{{$unit->courseCode}}</td>
                                              <td>{{$unit->studyPeriod}}</td>
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
                                    <h4 class="card-title">New Unit(s)</h4>
                                  </div>
                                  <div class="file-import col-md-12 mr-auto ml-auto">

                                    <form id="addUnit" method="post" action="{{ url('/units/new') }}">
                                      {{ csrf_field() }}

                                      <div class="card-body ">
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Unit Code *</label>
                                          <input type="text" class="form-control" id="unitCode" name="unitCode" required="true">
                                        </div>
                                        <div class="form-group">
                                          <label class="bmd-label-floating"> Description *</label>
                                          <input type="text" class="form-control" id="description" name="description" required="true">
                                        </div>
                                        <div class="form-group">
                                            <select class="selectpicker" name="studyPeriod" data-size="7" data-style="select-with-transition" title="Choose study period" required="true">
                                              <option disabled selected>Select Study Period</option>
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
                                        <div class="form-group">
                                            <select class="selectpicker" name="courseCode" data-size="7" data-style="select-with-transition" title="Choose course" required="true">
                                              <option disabled selected>Select Course</option>
                                              @foreach ($courses as $course)
                                              <option value={{$course->courseCode}}>{{$course->description}}</option>
                                              @endforeach
                                            </select>
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
        setFormValidation('#addUnit');
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