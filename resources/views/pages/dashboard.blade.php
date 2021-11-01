@extends('layouts.main')
@section('content')
<div class="content">
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">supervised_user_circle</i>
              </div>
              <p class="card-category">Tutors</p>
              <h3 class="card-title">{{ $tutors }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">supervised_user_circle</i>
                <a href="/users/tutors">View tutors</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-rose card-header-icon">
              <div class="card-icon">
                <i class="material-icons">supervised_user_circle</i>
              </div>
              <p class="card-category">Students</p>
              <h3 class="card-title">{{ $students }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">supervised_user_circle</i>
                <a href="/users/students">View students</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">school</i>
              </div>
              <p class="card-category">Courses</p>
              <h3 class="card-title">{{ $courses }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">school</i>
                <a href="/academics/courses">View courses</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-info card-header-icon">
              <div class="card-icon">
                <i class="material-icons">school</i>
              </div>
              <p class="card-category">Followers</p>
              <h3 class="card-title">{{ $units }}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">school</i>
                <a href="/academics/units">View units</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection