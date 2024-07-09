     <!-- ======= Header ======= -->
     <header id="header" class="header fixed-top d-flex align-items-center">

         <div class="d-flex align-items-center justify-content-between">
             <i class="bi bi-list toggle-sidebar-btn"></i>
             @if(getSchoolPid())
             <a href="{{route('my.school.dashboard')}}" class="logo d-flex align-items-center">
                 <img src="{{asset(getSchoolLogo())}}" alt="logo">
                 <span class="d-none d-lg-block ellipsis-text" id="schoolName">{{getSchoolName()}}</span>
             </a>
             <span class="text-danger small"> {{activeTermName()}} {{activeSessionName()}}</span>
             <!-- <i class="bi bi-list toggle-sidebar-btn"></i> -->
             @else
             <a href="{{route('users.home')}}" class="logo d-flex align-items-center">
                 <img src="{{asset(getSchoolLogo())}}" alt="">
                 <span class="d-none d-lg-block ellipsis-text" id="appName">{{env('APP_NAME', APP_NAME)}}</span>
             </a>
             @endif
         </div><!-- End Logo -->

         <!-- @if(getSchoolPid()) -->
         <!-- <div class="search-bar">
             <form class="search-form d-flex align-items-center" method="POST" action="#">
                 <input type="text" name="query" placeholder="Search" title="Enter search keyword">
                 <button type="submit" title="Search"><i class="bi bi-search"></i></button>
             </form>
         </div> -->
         <!-- @endif -->
         <nav class="header-nav ms-auto">
             <ul class="d-flex align-items-center">

                 <!-- <li class="nav-item d-block d-lg-none">
                     <a class="nav-link nav-icon search-bar-toggle " href="#">
                         <i class="bi bi-search"></i>
                     </a>
                 </li> -->

                 <li class="nav-item dropdown d-none d-md-block">
                     <a class="nav-link nav-icon pointer" href="{{route('helps')}}">
                         <span class="badge bg-danger">Help</span>
                     </a>

                 </li>
                 <li class="nav-item dropdown">
                     <a class="nav-link nav-icon pointer" id="loadNotifications" data-bs-toggle="dropdown">
                         <i class="bi bi-bell"></i>
                         <span class="badge bg-primary badge-number" id="badge-number">0</span>
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications" id="notifications">
                     </ul>
                 </li>


                 <li class="nav-item dropdown pe-3">

                     <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                         <!-- <img src="{{asset('themes/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle"> -->
                         <span class="ellipsis-text dropdown-toggle ps-2">{{strtoupper(auth()->user()['username'])}}</span>
                     </a><!-- End Profile Iamge Icon -->

                     <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                         <li class="dropdown-header">
                             <h6 class="ellipsis-text">{{getAuthFullname()}}</h6>
                             <!-- <span>Web Designer</span> -->
                         </li>
                         <li>
                             <a class="dropdown-item d-flex align-items-center pointer" id="hireMeConfig">
                                 <i class="bi bi-briefcase-fill"></i>
                                 <span>Hire Me</span>
                             </a>
                         </li>
                         <li>
                             <a class="dropdown-item d-flex align-items-center pointer" href="{{route('hiring')}}">
                                 <i class="bi bi-briefcase-fill"></i>
                                 <span>Apply for Job</span>
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>
                         @if(getSchoolUserPid())
                         <li>
                             @if(studentRole())
                             <a class="dropdown-item d-flex align-items-center pointer" href="{{route('student.profile',['id'=>base64Encode(getSchoolUserPid())])}}">
                                 @elseif(parentRole())
                                 <a class="dropdown-item d-flex align-items-center pointer" href="{{route('parent.profile',['id'=>base64Encode(getSchoolUserPid())])}}">
                                     @elseif(riderRole())
                                     <a class="dropdown-item d-flex align-items-center pointer" href="{{route('rider.profile',['id'=>base64Encode(getSchoolUserPid())])}}">
                                         @else
                                         <a class="dropdown-item d-flex align-items-center pointer" href="{{route('staff.profile',['id'=>base64Encode(getSchoolUserPid())])}}">
                                             @endif
                                             <i class="bi bi-person"></i> Profile</a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>
                         @endif
                         <li>
                             <a class="dropdown-item d-flex align-items-center pointer" data-bs-toggle="modal" data-bs-target="#updatePwd">
                                 <i class="bi bi-lock-fill"></i>
                                 <span>Update Password</span>
                             </a>
                         </li>
                         <li>
                             <a class="dropdown-item d-flex align-items-center pointer" id="updateAccount">
                                 <i class="bi bi-file-earmark-person-fill"></i>
                                 <span>Update Account</span>
                             </a>
                         </li>
                         <!-- <li>
                             <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                 <i class="bi bi-gear"></i>
                                 <span>Account Settings</span>
                             </a>
                         </li> -->
                         <li>
                             <hr class="dropdown-divider">
                         </li>

                         <!-- <li>
                             <a class="dropdown-item d-flex align-items-center">
                                 <i class="bi bi-question-circle"></i>
                                 <span>Need Help?</span>
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li> -->
                         @if(getSchoolPid())
                         <li>
                             <a class="dropdown-item bg-warning d-flex align-items-center" href="{{route('logout.school')}}">
                                 <i class="bi bi-person"></i>
                                 <span>School Sign Out</span>
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>
                         @endif
                         <li>
                             <a class="dropdown-item d-flex align-items-center bg-danger" href="{{route('logout')}}">

                                 <!-- <form class="align-items-center" method="POST" action="{{route('logout')}}">
                                    csrf -->
                                 <!-- <button type="submit" class="btn"> -->
                                 <i class="bi bi-box-arrow-right"></i><span>App Sign Out</span>
                                 <!-- </button> -->
                                 <!-- </form> -->

                             </a>
                         </li>

                     </ul><!-- End Profile Dropdown Items -->
                 </li><!-- End Profile Nav -->

             </ul>
         </nav><!-- End Icons Navigation -->
     </header><!-- End Header -->