          <div class="sidebar" data-color="azure" data-background-color="white" data-image="../../assets/img/04.jpg">
              <div class="logo"><a href="" class="simple-text logo-mini">
                  AT
                </a>
                <a href="" class="simple-text logo-normal">
                  SYSTEM
                </a>
              </div>
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

                <li class="nav-item {{ Request::path() == 'dashboard' ? 'active' : '' }} ">
                  <a class="nav-link " href="/dashboard">
                    <i class="material-icons">dashboard</i>
                    <p> Dashboard </p>
                  </a>
                </li>

                <li class="nav-item {{ Request::path() == 'users/tutors' || Request::path() == 'users/students' ? 'active' : '' }} ">
                  <a class="nav-link" data-toggle="collapse" href="#users">
                    <i class="material-icons">supervised_user_circle</i>
                    <p> Users
                      <b class="caret"></b>
                    </p>
                  </a>
                  <div class="collapse {{ Request::path() == 'users/tutors' || Request::path() == 'users/students' ? 'show' : '' }}" id="users">
                    <ul class="nav">
                      <li class="nav-item {{ Request::path() == 'users/tutors' ? 'active' : '' }} ">
                        <a class="nav-link" href="/users/tutors">
                          <span class="sidebar-mini"> T </span>
                          <span class="sidebar-normal"> Tutors </span>
                        </a>
                      </li>
                      <li class="nav-item {{ Request::path() == 'users/students' ? 'active' : '' }} ">
                        <a class="nav-link" href="/users/students">
                          <span class="sidebar-mini"> S </span>
                          <span class="sidebar-normal"> Students </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>

                <li class="nav-item {{ Request::path() == 'academics/courses' || Request::path() == 'academics/units' ? 'active' : '' }} ">
                  <a class="nav-link" data-toggle="collapse" href="#academics">
                    <i class="material-icons">school</i>
                    <p> Academics
                      <b class="caret"></b>
                    </p>
                  </a>
                  <div class="collapse {{ Request::path() == 'academics/courses' || Request::path() == 'academics/units' ? 'show' : '' }}" id="academics">
                    <ul class="nav">
                      <li class="nav-item {{ Request::path() == 'academics/courses' ? 'active' : '' }} ">
                        <a class="nav-link" href="/academics/courses">
                          <span class="sidebar-mini"> C </span>
                          <span class="sidebar-normal"> Courses </span>
                        </a>
                      </li>
                      <li class="nav-item {{ Request::path() == 'academics/units' ? 'active' : '' }} ">
                        <a class="nav-link" href="/academics/units">
                          <span class="sidebar-mini"> U </span>
                          <span class="sidebar-normal"> Units </span>
                        </a>
                      </li>
                    </ul>
                  </div>
                </li>

                <li class="nav-item {{ Request::path() == 'attendances/tutors' || Request::path() == 'attendances/students' ? 'active' : '' }}">
                  <a class="nav-link" data-toggle="collapse" href="#attendances">
                    <i class="material-icons">list_alt</i>
                    <p> Attendances
                      <b class="caret"></b>
                    </p>
                  </a>
                  <div class="collapse {{ Request::path() == 'attendances/tutors' || Request::path() == 'attendances/students' ? 'show' : '' }}" id="attendances">
                    <ul class="nav">
                      <li class="nav-item {{ Request::path() == 'attendances/tutors' ? 'active' : '' }} ">
                        <a class="nav-link" href="/attendances/tutors">
                          <span class="sidebar-mini"> TA </span>
                          <span class="sidebar-normal"> Tutors Attendance </span>
                        </a>
                      </li>
                      <li class="nav-item {{ Request::path() == 'attendances/students' ? 'active' : '' }} ">
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
          <!-- Navbar -->
          <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
            <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                    <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
                </button>
                </div>
                <a class="navbar-brand" href="javascript:;">Dashboard</a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
                <span class="navbar-toggler-icon icon-bar"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">notifications</i>
                    <span class="notification">5</span>
                    <p class="d-lg-none d-md-block">
                        Some Actions
                    </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Mike John responded to your email</a>
                    <a class="dropdown-item" href="#">You have 5 new tasks</a>
                    <a class="dropdown-item" href="#">You're now friend with Andrew</a>
                    <a class="dropdown-item" href="#">Another Notification</a>
                    <a class="dropdown-item" href="#">Another One</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">person</i>
                    <p class="d-lg-none d-md-block">
                        Account
                    </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                    <a class="dropdown-item" href="#">Profile</a>
                    <a class="dropdown-item" href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Log out</a>
                    </div>
                </li>
                </ul>
            </div>
            </div>
        </nav>
        <!-- End Navbar -->