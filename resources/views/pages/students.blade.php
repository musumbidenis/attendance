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
                        <a class="nav-link" data-toggle="tab" href="#stats" role="tablist">
                          <i class="material-icons">pie_chart</i> Stats
                        </a>
                      </li>
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
                      <div class="tab-pane" id="stats">
                        <div class="content">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-5">
                                <div class="card card-chart">
                                  <div class="card-header card-header-icon card-header-primary">
                                    <div class="card-icon">
                                      <i class="material-icons">pie_chart</i>
                                    </div>
                                    <h4 class="card-title">Pie Chart</h4>
                                  </div>
                                  <div class="card-body">
                                    <div id="chartPreferences" class="ct-chart"></div>
                                  </div>
                                  <div class="card-footer">
                                    <div class="row">
                                      <div class="col-md-12">
                                        <h6 class="card-category">Legend</h6>
                                      </div>
                                      <div class="col-md-12">
                                        <i class="fa fa-circle text-info"></i> Apple
                                        <i class="fa fa-circle text-warning"></i> Samsung
                                        <i class="fa fa-circle text-danger"></i> Windows Phone
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
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
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Date</th>
                                            <th class="disabled-sorting text-right">Actions</th>
                                          </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th class="text-right">Actions</th>
                                          </tr>
                                        </tfoot>
                                        <tbody>
                                          <tr>
                                            <td>Vivian Harrell</td>
                                            <td>Financial Controller</td>
                                            <td>San Francisco</td>
                                            <td>62</td>
                                            <td>2009/02/14</td>
                                            <td class="text-right">
                                              <a href="#" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">favorite</i></a>
                                              <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                              <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Timothy Mooney</td>
                                            <td>Office Manager</td>
                                            <td>London</td>
                                            <td>37</td>
                                            <td>2008/12/11</td>
                                            <td class="text-right">
                                              <a href="#" class="btn btn-link btn-info btn-just-icon like"><i class="material-icons">favorite</i></a>
                                              <a href="#" class="btn btn-link btn-warning btn-just-icon edit"><i class="material-icons">dvr</i></a>
                                              <a href="#" class="btn btn-link btn-danger btn-just-icon remove"><i class="material-icons">close</i></a>
                                            </td>
                                          </tr>
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
                      <div class="tab-pane" id="new">
                        <div class="content">
                          <div class="container-fluid">
                            <div class="row">
                              <div class="col-md-6 ml-auto mr-auto">
                                <form id="addStudent" action="" method="">

                                  <div class="card ">
                                    <div class="card-header card-header-primary card-header-icon">
                                      <div class="card-icon">
                                        <i class="material-icons">mail_outline</i>
                                      </div>
                                      <h4 class="card-title">New Student Form</h4>
                                    </div>
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
                                      <div class="category form-category">* Required fields</div>
                                    </div>
                                    <div class="card-footer text-right">
                                      <button type="submit" class="btn btn-rose">Register</button>
                                    </div>
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
  @endsection
@section('scripts')
<script src="../../assets/js/plugins/jquery.dataTables.min.js"></script>
<script src="../../assets/js/plugins/jquery.validate.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#addStudent').validate({
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