<li class="nav-item">
    <a class="nav-link " href="{{route('my.school.dashboard')}}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>
</li><!-- End Dashboard Nav -->

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
            <a href="{{route('school.subject.type')}}">
                <i class="bi bi-circle"></i><span>Subjects</span>
            </a>
        </li>
        <li>
            <a href="{{route('school.result.config')}}">
                <i class="bi bi-circle"></i><span>Results</span>
            </a>
        </li>
        <li>
            <a href="{{route('school.class')}}">
                <i class="bi bi-circle"></i><span>Class</span>
            </a>
        </li>
        <li>
            <a href="{{route('school.psychomotor.config')}}">
                <i class="bi bi-circle"></i><span>
                    Psychomotor
                    <!-- cycomfrence -->
                </span>
            </a>
        </li>
        <li>
            <a href="{{route('school.hostels.config')}}">
                <i class="bi bi-circle"></i><span>
                    Hostels
                    <!-- cycomfrence -->
                </span>
            </a>
        </li>
    </ul>
</li><!-- End Components Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#account-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-people-fill"></i><span>Account</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="account-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{ route('create.staff.form') }}">
                <i class="bi bi-circle"></i><span>Staff</span>
            </a>
        </li>
        <li>
            <a href="{{route('school.registration.student.form')}}">
                <i class="bi bi-circle"></i><span>Students</span>
            </a>
        </li>
        <li>
            <a href="{{route('school.parent.registration.form')}}">
                <i class="bi bi-circle"></i><span>Parents</span>
            </a>
        </li>
        <li>
            <a href="{{route('school.rider')}}">
                <i class="bi bi-circle"></i><span> PickUps Rider</span>
            </a>
        </li>
    </ul>
</li><!-- End Forms Nav -->
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
</li><!-- End Forms Nav -->
<li class="nav-item">
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
</li>
<!-- End Forms Nav -->
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-file-spreadsheet-fill"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
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
<!-- End Forms Nav -->
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#edit-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-file-spreadsheet-fill"></i><span>Edit</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="edit-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
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
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#assign-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-file-spreadsheet-fill"></i><span>Assign/Link</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="assign-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a class="pointer" data-bs-target="#createArmTeacherModal" data-bs-toggle="modal">
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

        <li>
            <a class="pointer" data-bs-target="#assignHostelToPortalModal" data-bs-toggle="modal">
                <i class="bi bi-circle"></i><span>Portal</span>
            </a>
        </li>

        <li>
            <a class="pointer" data-bs-target="#assignStudentToRiderModal" data-bs-toggle="modal">
                <i class="bi bi-circle"></i><span>Rider</span>
            </a>
        </li>
    </ul>
</li><!-- End Forms Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Assessment</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{route('student.assessment.form')}}">
                <i class="bi bi-circle"></i><span>TML</span>
            </a>
        </li>
        <li>
            <a href="tables-general.html">
                <i class="bi bi-circle"></i><span>Dly</span>
            </a>
        </li>
        <li>
            <a href="tables-general.html">
                <i class="bi bi-circle"></i><span> 2</span>
            </a>
        </li>
        <li>
            <a href="{{route('view.student.subject.score.form')}}">
                <i class="bi bi-circle"></i><span> VSR</span>
            </a>
        </li>
        <li>
            <a href="tables-data.html">
                <i class="bi bi-circle"></i><span>Data Tables</span>
            </a>
        </li>
    </ul>
</li><!-- End Tables Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#psychomotor-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-layout-text-window-reverse"></i><span>Psychomotor</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="psychomotor-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{route('psychomotor.assessment.form')}}">
                <i class="bi bi-circle"></i><span>PS</span>
            </a>
        </li>
        <li>
            <a href="{{route('affective.assessment.form')}}">
                <i class="bi bi-circle"></i><span>AF</span>
            </a>
        </li>
        <li>
            <a href="tables-general.html">
                <i class="bi bi-circle"></i><span> VPS</span>
            </a>
        </li>
        <li>
            <a href="{{route('view.student.subject.score.form')}}">
                <i class="bi bi-circle"></i><span> VFS</span>
            </a>
        </li>
    </ul>
</li><!-- End Tables Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#result-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Student Result</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="result-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{route('view.student.termly.result')}}">
                <i class="bi bi-circle"></i><span>V STR</span>
            </a>
        </li>
        <li>
            <a href="{{route('view.student.cumualtive.result')}}">
                <i class="bi bi-circle"></i><span>V SCR</span>
            </a>
        </li>
        <li>
            <a href="{{--route('view.broadsheet')--}}">
                <i class="bi bi-circle"></i><span>V SBS</span>
            </a>
        </li>

    </ul>
</li><!-- End Charts Nav -->

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Attendance</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="charts-chartjs.html">
                <i class="bi bi-circle"></i><span>Staff</span>
            </a>
        </li>
        <li>
            <a href="{{route('student.attendance.form')}}">
                <i class="bi bi-circle"></i><span>Std</span>
            </a>
        </li>
        <li>
            <a href="charts-echarts.html">
                <i class="bi bi-circle"></i><span>ECharts</span>
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
            <a href="{{route('promote.student.form')}}">
                <i class="bi bi-circle"></i><span>Promote class</span>
            </a>
        </li>
        <li>
            <a href="charts-apexcharts.html">
                <i class="bi bi-circle"></i><span>swap student</span>
            </a>
        </li>
        <li>
            <a href="charts-echarts.html">
                <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
        </li>
    </ul>
</li><!-- End Charts Nav -->

<!-- <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Activities</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="charts-chartjs.html">
                <i class="bi bi-circle"></i><span>CLS</span>
            </a>
        </li>
        <li>
            <a href="charts-apexcharts.html">
                <i class="bi bi-circle"></i><span>Sub-jectile</span>
            </a>
        </li>
        <li>
            <a href="charts-echarts.html">
                <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
        </li>
    </ul>
</li> -->
<!-- End Charts Nav -->
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#student-admission-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Admission</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="student-admission-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="charts-chartjs.html">
                <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
        </li>
        <li>
            <a href="charts-apexcharts.html">
                <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
        </li>
        <li>
            <a href="charts-echarts.html">
                <i class="bi bi-circle"></i><span>ECharts</span>
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
            <a href="charts-chartjs.html">
                <i class="bi bi-circle"></i><span>Chart.js</span>
            </a>
        </li>
        <li>
            <a href="charts-apexcharts.html">
                <i class="bi bi-circle"></i><span>ApexCharts</span>
            </a>
        </li>
        <li>
            <a href="charts-echarts.html">
                <i class="bi bi-circle"></i><span>ECharts</span>
            </a>
        </li>
    </ul>
</li><!-- End Charts Nav -->
<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#comment-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-bar-chart"></i><span>Cmmt</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="comment-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
        <li>
            <a href="{{route('principal.comment.termly.result')}}">
                <i class="bi bi-circle"></i><span>Principal </span>
            </a>
        </li>
        <li>
            <a href="{{route('teacher.comment.termly.result')}}">
                <i class="bi bi-circle"></i><span>Teacher</span>
            </a>
        </li>
        <li>
            <a href="{{route('portal.comment.termly.result')}}">
                <i class="bi bi-circle"></i><span>Portals</span>
            </a>
        </li>
    </ul>
</li><!-- End Charts Nav -->

<li class="nav-item">
    <a class="nav-link" href="{{route('principal.comment.termly.result')}}">
        <i class="bi bi-bar-chart"></i><span>My Wards </span>
    </a>

</li><!-- End Charts Nav -->