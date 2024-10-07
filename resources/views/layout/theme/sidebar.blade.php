  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">

        @if(parentRole())
        <a class="nav-link " href="{{route('parent.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
        @elseif(studentRole())
        <a class="nav-link " href="{{route('student.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
        @else
        <a class="nav-link " href="{{route('my.school.dashboard')}}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
        @endif

      </li><!-- End Dashboard Nav -->

       {{-- self attendance  --}}
          {{-- <li class="nav-item">

            <a class="nav-link " href="{{route('self.attendance')}}">
              <i class="bi bi-grid"></i>
              <span>Self Attendance</span>
            </a>

          </li><!-- End Dashboard Nav --> --}}

      <!-- school admin section  -->
      @if(getUserActiveRole() =="200" || getUserActiveRole()=="205")
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#framework" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Framework</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="framework" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('school.term')}}">
              <i class="bi bi-circle"></i><span>Terms</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.session')}}">
              <i class="bi bi-circle"></i><span>Sessions</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.assessment.title')}}">
              <i class="bi bi-circle"></i><span>Assessment</span>
            </a>
          </li>
          <!-- <li>
            <a href="{{route('school.attendance.setting')}}">
                <i class="bi bi-circle"></i><span>Attendance</span>
            </a>
        </li> -->
          <li>
            <a href="{{route('school.grade.key')}}">
              <i class="bi bi-circle"></i><span>Grade</span>
            </a>
          </li>
          
        

          <li>
            <a href="{{route('subjects')}}">
              <i class="bi bi-circle"></i><span>Individual Subjects</span>
            </a>
          </li>
           <li>
            <a href="{{route('subject.types')}}">
              <i class="bi bi-circle"></i><span>Grouped Subject (Type)</span>
            </a>
          </li> 

        
          <li>
            <a href="{{route('class.category')}}">
              <i class="bi bi-circle"></i><span>Class</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.psychomotor.config')}}">
              <i class="bi bi-circle"></i><span>
                Extra Curricular
                <!-- cycomfrence -->
              </span>
            </a>
          </li>
            <li>
            <a href="{{route('school.result.config')}}">
              <i class="bi bi-circle"></i><span>Results</span>
            </a>
          </li>

          <li>
            <a href="{{route('timetable.config')}}">
              <i class="bi bi-circle"></i><span>
                Timetable
              </span>
            </a>
          </li>

          <li>
            <a href="{{route('admission.config')}}">
              <i class="bi bi-circle"></i><span>Admission</span>
            </a>
          </li>
          @if(getSchoolType() == 2 || getSchoolType() == 3)
          <li>
            <a href="{{route('school.hostels.config')}}">
              <i class="bi bi-circle"></i><span>
                Hostels
                <!-- cycomfrence -->
              </span>
            </a>
          </li>
          @endif
          <li>
            <a href="{{route('student.award.config')}}">
              <i class="bi bi-circle"></i><span>Award</span>
            </a>
          </li>
          <li>
            <a href="{{route('edit.school.info')}}">
              <i class="bi bi-circle"></i><span>
                Update School Info
                <!-- cycomfrence -->
              </span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Framework -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#payment" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cash-stack"></i><span>Payment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="payment" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('fee.config')}}">
              <i class="bi bi-circle"></i><span>
                Fees Configuration
              </span>
            </a>
          </li>

          <li>
            <a href="{{route('manage.invoice')}}">
              <i class="bi bi-circle"></i><span>
                Payments
              </span>
            </a>
          </li>

          <li>
            <a href="{{route('result.records')}}">
              <i class="bi bi-circle"></i><span>
                Result Record
              </span>
            </a>
          </li>

        </ul>
      </li>
      
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#event" data-bs-toggle="collapse" href="#">
          <i class="bi bi-alarm"></i><span>Activities</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="event" class="nav-content collapse " data-bs-parent="#sidebar-nav">
         
          <li>
            <a href="{{route('event.notifications')}}">
              <i class="bi bi-circle"></i><span>
                Notifications
              </span>
            </a>
          </li>
          <li>
            <a href="{{route('event.config')}}">
              <i class="bi bi-circle"></i><span>
                Events
              </span>
            </a>
          </li>

          <li>
            <a class="nav-link collapsed" href="{{route('hire.config')}}">
              <i class="bi bi-layers-fill"></i><span>Advert</span><i class="bi bi-chevron-right ms-auto"></i>
            </a>
          </li>
          <li>
            <a href="{{route('staff.attendance')}}">
              <i class="bi bi-circle"></i><span>
                Attendance
              </span>
            </a>
          </li>
        </ul>
      </li>

      <!-- End Framework -->
      <!-- End Recruitment -->
    
      <!-- End Framework -->

      <!-- create account nav  -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#account-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>Account</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="account-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('register.staff') }}">
              <i class="bi bi-circle"></i><span>Staff</span>
            </a>
          </li>
          <li>
            <a href="{{route('register.student')}}">
              <i class="bi bi-circle"></i><span>Students</span>
            </a>
          </li>
          <li>
            <a href="{{route('register.parent')}}">
              <i class="bi bi-circle"></i><span>Parents</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.rider.form')}}">
              <i class="bi bi-circle"></i><span> PickUps Rider</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End create account nav -->
      <!-- uploads  -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#uploads-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people-fill"></i><span>Uploads</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="uploads-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('upload.staff') }}">
              <i class="bi bi-circle"></i><span>Staff</span>
            </a>
          </li>
          <li>
            <a href="{{route('upload.student')}}">
              <i class="bi bi-circle"></i><span>Students</span>
            </a>
          </li>
          <li>
            <a href="{{route('upload.parent')}}">
              <i class="bi bi-circle"></i><span>Parents</span>
            </a>
          </li>
          <li>
            <a href="{{route('upload.rider')}}">
              <i class="bi bi-circle"></i><span> PickUps Rider</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- end of uploads -->
      <!-- add/link users   -->

      {{-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#add-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-spreadsheet-fill"></i><span>Add</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="add-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#" data-bs-target="#addStaffModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Staff</span>
            </a>
          </li>
          <li>
            <a href="#" data-bs-target="#addStudentModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Students</span>
            </a>
          </li>
          <li>
            <a href="#" data-bs-target="#addParentModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Parents</span>
            </a>
          </li>

          <li>
            <a href="#" data-bs-target="#addRiderModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Rider List</span>
            </a>
          </li>
        </ul>
      </li> --}}

      <!-- End add/link users -->
      <!-- user list  -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('school.staff.list') }}">
              <i class="bi bi-circle"></i><span>Staff</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.student.list')}}">
              <i class="bi bi-circle"></i><span>Students</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.parent.list')}}">
              <i class="bi bi-circle"></i><span>Parents</span>
            </a>
          </li>
          <li>
            <a href="{{route('school.rider.list')}}">
              <i class="bi bi-circle"></i><span>Rider List</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Forms Nav -->
      <!-- user list  -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#staff-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-spreadsheet-fill"></i><span>Staff Activities</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="staff-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>
            <a href="{{ route('school.staff.classes') }}">
              <i class="bi bi-circle"></i><span>Staff Class</span>
            </a>
          </li>
          <li>
            <a href="{{ route('all.staff.subjects') }}">
              <i class="bi bi-circle"></i><span>Staff Subjects</span>
            </a>
          </li>

        </ul>
      </li>
      <!-- End Forms Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#assign-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-spreadsheet-fill"></i><span>Assign/Link</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="assign-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a class="pointer" data-bs-target="#assignClassArmTeacherModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Class</span>
            </a>
          </li>
          <li>
            <a class="pointer" data-bs-target="#createArmSubjectTeacherModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Subject</span>
            </a>
          </li>
          <li>
            <a class="pointer" data-bs-target="#linkStudentParentModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Link Student To Parent</span>
            </a>
          </li>
          <li>
            <a class="pointer" data-bs-target="#assignArmToRepModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Class Rep</span>
            </a>
          </li>
          @if(getSchoolType() == 2 || getSchoolType() == 3)
          <li>
            <a class="pointer" data-bs-target="#assignHostelToPortalModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Portal</span>
            </a>
          </li>
          <li>
            <a class="pointer" data-bs-target="#assignHostelToStudentModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Link Student to Hostels</span>
            </a>
          </li>
          @endif
          <li>
            <a class="pointer" data-bs-target="#linkStudentToRiderModal" data-bs-toggle="modal">
              <i class="bi bi-circle"></i><span>Care/Rider</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->

      @endif

      @if(schoolTeacher())
      
      
            
            <!-- End Charts Nav -->
            <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#assignment" data-bs-toggle="collapse" href="#">
                <i class="bi bi-bar-chart"></i><span>Learn Hub</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="assignment" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                  <a href="{{route('lesson.plans')}}">
                    <i class="bi bi-circle"></i><span>Lesson Plans</span>
                  </a>
                </li>
                <li>
                  <a href="{{route('lesson.notes')}}">
                    <i class="bi bi-circle"></i><span>Lesson Note</span>
                  </a>
                </li>
                @if (classTeacher() || subjectTeacher())
                    <li>
                      <a href="{{route('manual.assignment')}}">
                        <i class="bi bi-circle"></i><span>Manual</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('automated.assignment')}}">
                        <i class="bi bi-circle"></i><span>Automated</span>
                      </a>
                    </li>
                    <li>
                      <a href="{{route('class.assignment.form')}}">
                        <i class="bi bi-circle"></i><span>Records</span>
                      </a>
                    </li>
                @endif
              

              
              </ul>
            </li>
            <!-- End Charts Nav -->
            @if(classTeacher())
                  <!-- End Charts Nav -->
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#my-student-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-bar-chart"></i><span>My Student</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="my-student-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="{{route('register.student')}}">
                      <i class="bi bi-circle"></i><span>Register Student</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('staff.student.list')}}">
                      <i class="bi bi-circle"></i><span>Student Class</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('staff.student.list')}}">
                      <i class="bi bi-circle"></i><span>Student Award</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('timetable.config')}}">
                      <i class="bi bi-circle"></i><span>Student Timetable</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('student.invoice')}}">
                      <i class="bi bi-circle"></i><span>Student Invoice</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- End Charts Nav -->
                  

              <!-- End Charts Nav -->
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#attendance-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-bar-chart"></i><span>Attendance</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="attendance-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

                  <li>
                    <a href="{{route('student.attendance.form')}}">
                      <i class="bi bi-circle"></i><span>Take Attendance</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('student.attendance.count')}}">
                      <i class="bi bi-circle"></i><span>Attendance Count</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('student.attendance.history')}}">
                      <i class="bi bi-circle"></i><span>Attendance History</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!-- End Charts Nav -->
              <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#student-promotion-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-bar-chart"></i><span>Promotion</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="student-promotion-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                    <a href="{{route('promote.student')}}">
                      <i class="bi bi-circle"></i><span>Promote Students</span>
                    </a>
                  </li>
                  <li>
                    <a href="{{route('swap.student')}}">
                      <i class="bi bi-circle"></i><span>Swap student</span>
                    </a>
                  </li>
                </ul>
              </li><!-- End Charts Nav -->
          
          @endif

      
      @endif

      <!-- student assessment -->
      @if(schoolTeacher())

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span> Assessment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('enter.student.score')}}">
              <i class="bi bi-circle"></i><span>Record CA's</span>
            </a>
          </li>
          
          <li>
            <a href="{{route('view.subject.score')}}">
              <i class="bi bi-circle"></i><span> View Subject Result</span>
            </a>
          </li>
           @if(classTeacher())
          <li>
            <a href="{{route('review.class.result')}}">
              <i class="bi bi-circle"></i><span> Review Class Result</span>
            </a>
          </li>
          @endif

        </ul>
      </li>
      <!-- staff class and subject -->
      @endif


      @if(getUserActiveRole() =="301")

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#psychomotor-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Extra Curricular</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="psychomotor-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('record.extra.curricular')}}">
              <i class="bi bi-circle"></i><span>Extra Curricular Assessment</span>
            </a>
          </li>

          <li>
            <a href="{{route('view.psychomotor')}}">
              <i class="bi bi-circle"></i><span> View Extra Curricular Score</span>
            </a>
          </li>

        </ul>
      </li><!-- End Tables Nav -->
      @endif
      <!-- view student result  -->
      @if(getUserActiveRole() == "301" || getUserActiveRole() == "500" || getUserActiveRole() == "200" || getUserActiveRole() == "205")
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#result-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Student Result</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="result-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          
          {{-- <li>
            <a href="{{route('publish.result')}}">
              <i class="bi bi-circle"></i><span>Publish Result</span>
            </a>
          </li>
           --}}
          <li>
            <a href="{{route('view.student.termly.result')}}">
              <i class="bi bi-circle"></i><span>View Student Result</span>
            </a>
          </li>

          {{-- <li>
            <a href="{{route('view.student.cumualtive.result')}}">
              <i class="bi bi-circle"></i><span>View Cumulative Result</span>
            </a>
          </li>
           --}}
           
          {{-- <li>
            <a href="{{route('view.broadsheet')}}">
              <i class="bi bi-circle"></i><span>V SBS</span> 
            </a>
          </li> --}}

        </ul>
      </li><!-- End Charts Nav -->
      @endif

      <!-- admission and payment section form clark n secretary  -->
      @if(getUserActiveRole() == "303" || getUserActiveRole() == "305" || getUserActiveRole() == "500")

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#student-admission-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Admission</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="student-admission-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('school.admission')}}">
              <i class="bi bi-circle"></i><span>Admission</span>
            </a>
          </li>
          <li>
            <a href="{{route('admission.list')}}">
              <i class="bi bi-circle"></i><span>Admission List</span>
            </a>
          </li>
          <li>
            <a href="{{route('admission.process')}}">
              <i class="bi bi-circle"></i><span>Process Admission</span>
            </a>
          </li>

        </ul>
      </li><!-- End Charts Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#payment-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Payment Collection</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="payment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('accept.payment')}}">
              <i class="bi bi-circle pointer"></i><span>Accept Payment</span>
            </a>
          </li>
          <li>
            <a href="{{route('student.invoice')}}">
              <i class="bi bi-circle"></i><span>Invoices</span>
            </a>
          </li>
          <li>
            <a href="{{route('payment.records')}}">
              <i class="bi bi-circle"></i><span>Payment Records</span>
            </a>
          </li>

        </ul>
      </li><!-- End Charts Nav -->
      @endif
      @if(canComment())
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#comment-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Comment</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="comment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @if(getUserActiveRole() == "500")
          <li>
            <a href="{{route('principal.comment.termly.result')}}">
              <i class="bi bi-circle"></i><span>Manual Comment </span>
            </a>
          </li>
          <li>
            <a href="{{route('principal.automated.comments')}}">
              <i class="bi bi-circle"></i><span>Automated Comment </span>
            </a>
          </li>
          @endif
          @if(getUserActiveRole() == "301")
          <li>
            <a href="{{route('teacher.comment.termly.result')}}">
              <i class="bi bi-circle"></i><span>Manual Comment</span>
            </a>
          </li>
          <li>
            <a href="{{route('teacher.automated.comments')}}">
              <i class="bi bi-circle"></i><span>Automated Comment </span>
            </a>
          </li>
          @endif
          @if(getUserActiveRole() == "307")
          <li>
            <a href="{{route('portal.comment.termly.result')}}">
              <i class="bi bi-circle"></i><span>Portals</span>
            </a>
          </li>
          <li>
            <a href="{{route('portal.automated.comments')}}">
              <i class="bi bi-circle"></i><span>Automated Comment </span>
            </a>
          </li>
          @endif
        </ul>
      </li><!-- End Charts Nav -->
      @endif
      <!-- parent  -->
      @if(parentRole() || studentRole())

      @if(studentPid())
      <li class="nav-item">
        <a class="nav-link" href="{{route('student.profile')}}">
          <i class="bi bi-person"></i><span>Profile</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('student.payment')}}">
          <i class="bi bi-credit-card"></i><span>Payment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('student.attendance')}}">
          <i class="bi bi-calendar-date"></i><span>Attendance</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('student.assessment')}}">
          <i class="bi bi-play-circle-fill"></i><span>Assessments</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('student.result')}}">
          <i class="bi bi-journal-album"></i><span>Result</span>
        </a>
      </li>
      @endif
      @endif
      <!-- rider  -->
      <!-- @if(riderRole())
      <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#rider-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>My Wards</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="rider-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        
        <li>
            <a href="#">
                <i class="bi bi-circle"></i><span>My Wards</span>
            </a>
        </li>
    </ul>
</li> 
      @endif -->
      <!-- @if(studentRole())
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#student-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>My Wards</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="student-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>My Activities</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Attendance</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Result</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Timetable</span>
            </a>
          </li>
        </ul>
      </li>
      @endif -->
      @if(getUserAccess())
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#roles-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Switch Role</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="roles-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          @foreach(getUserAccess() as $role)
          <li>
            <a class="switchRole pointer" id="{{$role}}">
              <i class="bi bi-circle"></i><span>{{staffRoles($role)}}</span>
            </a>
          </li>
          @endforeach
        </ul>
      </li>
      @endif
    </ul>

  </aside><!-- End Sidebar-->