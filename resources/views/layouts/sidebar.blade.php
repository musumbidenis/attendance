<div class="sidebar" data-color="azure" data-background-color="white" data-image="../../assets/img/sidebar-1.jpg">
    <div class="logo"><a href="" class="simple-text logo-mini">
        AT
      </a>
      <a href="" class="simple-text logo-normal">
        SYSTEM
      </a></div>
    <div class="sidebar-wrapper">

      <!-- User profile details -->
      <div class="user">
        <div class="photo">
          <img src="../assets/img/faces/avatar.jpg" />
        </div>
        <div class="user-info">
          <a data-toggle="collapse" href="#profile" class="username">
            <span>
              Tania Andrew
              <b class="caret"></b>
            </span>
          </a>
          <div class="collapse" id="profile">
            <ul class="nav">
              <li class="nav-item">
                <a class="nav-link" href="/profile">
                  <span class="sidebar-mini"> MP </span>
                  <span class="sidebar-normal"> My Profile </span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/logout">
                  <span class="sidebar-mini"> L </span>
                  <span class="sidebar-normal"> Logout </span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Sidebar menu items -->
      <ul class="nav">

        <li class="nav-item {{ Request::path() == '/' ? 'active' : '' }} ">
          <a class="nav-link " href="/">
            <i class="material-icons">dashboard</i>
            <p> Dashboard </p>
          </a>
        </li>

        <li class="nav-item {{ Request::path() == '/users/tutors' || Request::path() == '/academics/units' ? 'active' : '' }} ">
          <a class="nav-link" data-toggle="collapse" href="#users">
            <i class="material-icons">supervised_user_circle</i>
            <p> Users
              <b class="caret"></b>
            </p>
          </a>
          <div class="collapse" id="users">
            <ul class="nav">
              <li class="nav-item {{ Request::path() == '/users/tutors' ? 'active' : '' }} ">
                <a class="nav-link" href="/users/tutors">
                  <span class="sidebar-mini"> T </span>
                  <span class="sidebar-normal"> Tutors </span>
                </a>
              </li>
              <li class="nav-item {{ Request::path() == '/users/students' ? 'active' : '' }} ">
                <a class="nav-link" href="/users/students">
                  <span class="sidebar-mini"> S </span>
                  <span class="sidebar-normal"> Students </span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item {{ Request::path() == '/academics/courses' || Request::path() == '/academics/units' ? 'active' : '' }} ">
          <a class="nav-link" data-toggle="collapse" href="#academics">
            <i class="material-icons">school</i>
            <p> Academics
              <b class="caret"></b>
            </p>
          </a>
          <div class="collapse" id="academics">
            <ul class="nav">
              <li class="nav-item {{ Request::path() == '/academics/courses' ? 'active' : '' }} ">
                <a class="nav-link" href="/academics/courses">
                  <span class="sidebar-mini"> C </span>
                  <span class="sidebar-normal"> Courses </span>
                </a>
              </li>
              <li class="nav-item {{ Request::path() == '/academics/units' ? 'active' : '' }} ">
                <a class="nav-link" href="/academics/units">
                  <span class="sidebar-mini"> U </span>
                  <span class="sidebar-normal"> Units </span>
                </a>
              </li>
            </ul>
          </div>
        </li>

        <li class="nav-item ">
          <a class="nav-link" data-toggle="collapse" href="#attendances">
            <i class="material-icons">list_alt</i>
            <p> Attendances
              <b class="caret"></b>
            </p>
          </a>
          <div class="collapse" id="attendances">
            <ul class="nav">
              <li class="nav-item {{ Request::path() == '/attendances/tutors' ? 'active' : '' }} ">
                <a class="nav-link" href="/attendances/tutors">
                  <span class="sidebar-mini"> TA </span>
                  <span class="sidebar-normal"> Tutors Attendance </span>
                </a>
              </li>
              <li class="nav-item {{ Request::path() == '/attendances/students' ? 'active' : '' }} ">
                <a class="nav-link" href="/attendances/students">
                  <span class="sidebar-mini"> SA </span>
                  <span class="sidebar-normal"> Students Attendance </span>
                </a>
              </li>
            </ul>
          </div>
        </li>

      </ul>
    </div>
  </div>