<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    School Attendance System
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
</head>

<body class="off-canvas-sidebar">
  @include('sweetalert::alert')
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
    <div class="container">
      <div class="navbar-wrapper">
        <a class="navbar-brand"> {{ Request::path() == 'register' ? 'Registration Page' : 'Login Page' }}</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="sr-only">Toggle navigation</span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
        <span class="navbar-toggler-icon icon-bar"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item {{ Request::path() == 'register' ? 'active' : '' }} ">
            <a href="/register" class="nav-link">
              <i class="material-icons">person_add</i>
              Register
            </a>
          </li>
          <li class="nav-item {{ Request::path() == 'login' ? 'active' : '' }} ">
            <a href="/login" class="nav-link">
              <i class="material-icons">fingerprint</i>
              Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="wrapper wrapper-full-page">
    <div class="page-header login-page header-filter" filter-color="black" style="background-image: url('../../assets/img/04.jpg'); background-size: cover; background-position: top center;">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
            @if (Request::path() == 'register')
              <form id="register" class="form" method="post" action="{{ url('/register') }}">
              {{ csrf_field() }})
                    
                <div class="card card-login card-hidden">
                  <div class="card-header card-header-info text-center">
                    <h4 class="card-title">Register</h4>
                  </div>
                  <div class="card-body ml-3 mr-3">
                    <div class="form-group">
                      <label class="bmd-label-floating"> Tutor ID * </label>
                      <input type="text" class="form-control" id="tutorId" name="tutorId" required="true">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating"> First Name * </label>
                      <input type="text" class="form-control" id="firstName" name="firstName" required="true">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating"> Surname * </label>
                      <input type="text" class="form-control" id="surname" name="surname" required="true">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating"> Phone * </label>
                      <input type="number" class="form-control" id="phone" name="phone" required="true">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating"> Email Address *</label>
                      <input type="email" class="form-control" id="email" name="email" required="true">
                    </div>
                    <div class="form-group">
                      <select class="selectpicker" name="courseCode" data-size="7" data-style="select-with-transition" title="Choose your course" required="true">
                        <option disabled selected>Select Course</option>
                        @foreach ($courses as $course)
                        <option value={{$course->courseCode}}>{{$course->description}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="card-footer justify-content-center">
                    <input type="submit" class="btn btn-info btn-link btn-lg" value="REGISTER">
                  </div>
                </div>
              </form>
            @else
              <form id="login" class="form" method="post" action="{{ url('/login') }}">
              {{ csrf_field() }}
                    
                <div class="card card-login card-hidden">
                  <div class="card-header card-header-info text-center">
                    <h4 class="card-title">Login</h4>
                  </div>
                  <div class="card-body ml-3 mr-3">
                    <div class="form-group">
                      <label class="bmd-label-floating"> Tutor ID *</label>
                      <input type="text" class="form-control" id="email" name="tutorId" required="true">
                    </div>
                    <div class="form-group">
                      <label class="bmd-label-floating"> Password *</label>
                      <input type="password" class="form-control" id="password" name="password" required="true">
                    </div>
                  </div>
                  <div class="card-footer justify-content-center">
                    <input type="submit" class="btn btn-info btn-link btn-lg" value="LOGIN">
                  </div>
                </div>
              </form>
            @endif
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container">
          <div class="copyright text-center">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script> Made with <i class="material-icons">favorite</i> by
          <a href="https://musumbidenis.github.io" target="_blank">Musumbi Denis</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../../assets/js/core/jquery.min.js"></script>
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
  <script src="../../assets/js/plugins/bootstrap-selectpicker.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>
  <script src="../../assets/js/plugins/jquery.validate.min.js"></script>
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
      setFormValidation('#login');
      setFormValidation('#register');
    });
  </script>
  <script>
    $(document).ready(function() {
      md.checkFullPageBackgroundImage();
      setTimeout(function() {
        /* after 1000 ms we add the class animated to the login/register card */
        $('.card').removeClass('card-hidden');
      }, 700);
    });
  </script>
</body>

</html>