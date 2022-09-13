<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Framework\Select2Controller;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Parent\ParentController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Rider\SchoolRiderController;
use App\Http\Controllers\Organisation\OrganisationController;
use App\Http\Controllers\Organisation\OrgUserAccessController;
use App\Http\Controllers\School\Student\StudentScoreController;
use App\Http\Controllers\Organisation\OrganisationUserController;
use App\Http\Controllers\School\Framework\Grade\GradeKeyController;
use App\Http\Controllers\School\Framework\Subject\SubjectController;
use App\Http\Controllers\School\Framework\Term\SchoolTermController;
use App\Http\Controllers\School\Framework\Psycho\PsychomotorController;
use App\Http\Controllers\School\Framework\Subject\SubjectTypeController;
use App\Http\Controllers\School\Framework\Psycho\PsychoGradeKeyController;
use App\Http\Controllers\School\Framework\Session\SchoolSessionController;
use App\Http\Controllers\School\Registration\ParentRegistrationController;
use App\Http\Controllers\School\Framework\Psycho\EffectiveDomainController;
use App\Http\Controllers\School\Registration\StudentRegistrationController;
use App\Http\Controllers\School\Student\Promotion\PromoteStudentController;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Framework\Attendance\AttendanceTypeController;
use App\Http\Controllers\School\Framework\Assessment\AssessmentTitleController;
use App\Http\Controllers\School\Student\Attendance\StudentAttendanceController;
use App\Http\Controllers\School\Student\Result\Comments\CommentResultController;
use App\Http\Controllers\School\Student\Results\Termly\StudentTermlyResultController;
use App\Http\Controllers\School\Student\Result\Comments\PortalCommentResultController;
use App\Http\Controllers\School\Student\Result\Comments\TeacherCommentResultController;
use App\Http\Controllers\School\Student\Results\Cumulative\ViewCumulativeResultController;
use App\Http\Controllers\School\Student\Assessment\Psychomotor\RecordPsychomotorController;
use App\Http\Controllers\School\Student\Assessment\AffectiveDomain\AffectiveDomainController;

// port 8400
Route::view('/','welcome');
// authentication 
// sign up 
// sign up form 
Route::view('sign-up', 'auths.sign-up')->name('sign.up');
// signing up 
Route::post('sign-up', [AuthController::class, 'signUp']);
// verify account 
Route::get('verify/{id}', [AuthController::class, 'verifyAccount']);
// login page 
Route::view('login', 'auths.login')->name('login');
// login in 
Route::post('login', [AuthController::class, 'login'])->name('login');
// reset password 
Route::post('reset', [AuthController::class, 'resetPassword'])->name('reset');
// Logout
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// user dashboard 
Route::get('users-dashboard', [UserController::class, 'index'])->name('users.dashboard');

// user create organization 
Route::get('create-base', [OrganisationController::class, 'index'])->name('create.organisation');
Route::post('create-base', [OrganisationController::class,'create']);
Route::get('update-base/{id}', [OrganisationController::class,'update'])->name('update.organisation');
Route::get('delete-base/{id}', [OrganisationController::class,'update'])->name('delete.organisation');
// load organisation user
Route::get('base-users',[OrganisationUserController::class,'index'])->name('organisation.users');
// add user to organisation 
Route::post('base-users',[OrganisationUserController::class,'create'])->name('organisation.users');
// organisation user access right 
Route::post('base-user-access',[OrgUserAccessController::class,'store'])->name('organisation.user.access');
// sign up with organisation link direct 
// Route::post('organisation-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('organisation.sign.up');

// user create school 
Route::get('lite', [SchoolController::class, 'index'])->name('create.school');
Route::post('lite', [SchoolController::class, 'createSchool']);
Route::get('lite-sign-in/{id}', [SchoolController::class, 'schoolLogin'])->name('login.school');
Route::get('lite-dashboard', [SchoolController::class, 'mySchoolDashboard'])->name('my.school.dashboard');
Route::get('update-lite/{id}', [SchoolController::class, 'update'])->name('update.school');
Route::get('delete-lite/{id}', [SchoolController::class, 'update'])->name('delete.school');
// load school user
Route::get('lite-users', [SchoolUserController::class, 'index'])->name('school.users');
// add user to school 
Route::post('lite-users', [SchoolUserController::class, 'create'])->name('school.users');
// school user access right 
Route::post('lite-user-access', [SchoolUserAccessController::class, 'store'])->name('school.user.access');
// sign up with school link direct 
// Route::post('school-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('school.sign.up');
// category and class has the same controller 
Route::view('lite-class', 'school.framework.class.class-and-category')->name('school.class')->middleware('auth');
// tab 1 
Route::get('load-school-category', [ClassController::class, 'loadCategory'])->name('load.school.category');
// tab 2 
Route::get('load-school-class', [ClassController::class, 'loadClasses'])->name('load.school.classes');
// tab 3 
Route::get('load-school-class-arm', [ClassController::class, 'loadClassArm'])->name('load.school.class.arm');
// tab 4 
Route::get('load-school-class-arm-subject', [ClassController::class, 'loadClassArmSubject'])->name('load.school.class.arm.subject');
// create category 
Route::post('create-lite-category', [ClassController::class, 'createCategory'])->name('create.school.category');
// create class 
Route::post('lite-class', [ClassController::class, 'createClass'])->name('create.school.class');
// create class arm 
Route::post('lite-arm', [ClassController::class, 'createClassArm'])->name('create.school.class.arm');
// create class arm 
Route::post('create-class-arm-subject', [ClassController::class, 'createClassArmSubject'])->name('create.school.class.arm.subject');
// academic session
Route::view('lite-session', 'school.framework.session.school_session')->name('school.session')->middleware('auth');
// load session on tab with datatable server  
Route::get('load-school-session',[SchoolSessionController::class,'index'])->name('load.school.session');
// create new session 
Route::post('lite-session',[SchoolSessionController::class,'createSession'])->name('school.session');
// active school session 
// load active session on tab 
Route::get('load-school-active-session',[SchoolSessionController::class, 'loadSchoolActiveSession'])->name('load.school.active.session');
// update active session 
Route::post('lite-session-active',[SchoolSessionController::class,'setActiveSession'])->name('school.session.active');

// terms 
Route::view('lite-term', 'school.framework.terms.school_terms')->name('school.term')->middleware('auth');
Route::get('list-lite-term',[SchoolTermController::class,'index'])->name('school.list.term');
Route::post('lite-term',[SchoolTermController::class,'createSchoolTerm'])->name('school.term');
Route::post('lite-active-term',[SchoolTermController::class, 'setSchoolActiveTerm'])->name('school.term.active');
Route::get('load-active-term',[SchoolTermController::class, 'loaSchoolActiveTerm'])->name('load.school.active.term');


// Assesment Title
Route::view('lite-assessment-title', 'school.framework.assessment.assessment-title')->name('school.assessment.title')->middleware('auth');
Route::get('load-assessment-title', [AssessmentTitleController::class, 'index'])->name('load.school.assessment.title');
// submiting form and create assessment title 
Route::post('lite-assessment-title', [AssessmentTitleController::class, 'createAssessmentTitle'])->name('school.assessment.title');
//load score settings 
Route::get('load-score-setting', [ScoreSettingsController::class, 'index'])->name('load.score.setting');

// load dropdon select2
// load school on dropdon using select2  
Route::post('load-available-', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.dropdown')->middleware('auth');
Route::post('load-available-session', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.session')->middleware('auth');
// load category 
Route::post('load-available-category', [Select2Controller::class, 'loadAvailableCategory'])->name('load.available.category')->middleware('auth');
// load assessment title 
Route::post('load-available-title', [AssessmentTitleController::class, 'loadAvailableTitle'])->name('load.available.title');
// load term 
Route::post('load-available-term', [SchooltermController::class, 'loadSchoolTerm'])->name('load.available.term')->middleware('auth');
// load classes 
Route::post('load-available-class', [Select2Controller::class, 'loadAvailableClass'])->name('load.available.class');
// load classe arm 
Route::post('load-available-class-arm', [Select2Controller::class, 'loadAvailableClassArm'])->name('load.available.class.arm');
Route::post('load-available-all-class-arm', [Select2Controller::class, 'loadAllClassArm'])->name('load.all.class.arm');
// load classe arm subject
Route::post('load-available-class-arm-subject', [Select2Controller::class, 'loadAvailableClassArmSubject'])->name('load.available.class.arm.subject');
// load category subject 
Route::post('load-available-category-subject', [Select2Controller::class, 'loadAvailableSelectedCategorySubject'])->name('load.available.category.subject');
// load school head of staff 
Route::post('load-available-school-category-head', [Select2Controller::class, 'loadAvailableCategoryHead'])->name('load.available.school.category.head');
//load school teachers
Route::post('load-available-school-teachers', [Select2Controller::class, 'loadAvailableTeacher'])->name('load.available.school.category.head');
//load school teachers
Route::post('load-available-student', [Select2Controller::class, 'loadStudents'])->name('load.available.school.student');
//load school parents
Route::post('load-available-parent', [Select2Controller::class, 'loadSchoolParent'])->name('load.available.parent');
//load states
Route::post('load-available-state', [Select2Controller::class, 'loadStates'])->name('load.available.state');
//load school states
Route::post('load-available-state-lga', [Select2Controller::class, 'loadStatesLga'])->name('load.available.state.lga');
// load subject type 
Route::post('load-available-subject-type', [Select2Controller::class, 'loadAvailableSubjectType'])->name('load.available.subject.type');
// score settings 
Route::post('lite-score-settings', [ScoreSettingsController::class, 'createScoreSettings'])->name('create.school.score.settings');

// subjects & subject type
// load subject type page 
Route::view('lite-subject-type', 'school.framework.subject.subjects')->name('school.subject.type')->middleware('auth');
// load subject type 
Route::get('load-subject-type',[SubjectTypeController::class, 'index'])->name('load.school.subject.type');
// create subject type 
Route::post('lite-subject-type',[SubjectTypeController::class, 'createSubjectType'])->name('create.school.subject.type');
// load subjects 
Route::get('load-school-subject',[SubjectController::class, 'index'])->name('load.school.subject');
// create school category subject 
Route::post('create-subject-subject',[SubjectController::class, 'createSchoolSubject'])->name('create.school.subject');
Route::post('load-subject-by-id',[SubjectController::class, 'loadSubjectById'])->name('load.subject.by.id');


// grade key 
Route::view('lite-grade-key', 'school.framework.grade.grade_key')->name('school.grade.key')->middleware('auth');
Route::get('load-lite-grade-key',[GradeKeyController::class, 'index'])->name('load.school.grade.key');
Route::post('lite-grade-key',[GradeKeyController::class, 'createGradeKey'])->name('school.grade.key');
Route::view('lite-attendance', 'school.framework.attendance.attendance-setting')->name('school.attendance.setting')->middleware('auth');
Route::get('load-attendance',[AttendanceTypeController::class,'index'])->name('load.school.attendance.setting');
Route::post('lite-attendance',[AttendanceTypeController::class, 'createAttendanceType']);
Route::post('lite-class-attendance',[AttendanceTypeController::class, 'createClassAttendance'])->name('school.class.attendance');
// Route::post('school-take-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.take.class.attendance');


// Psychomotor, effective domain and grade key 
// Psychomotor 
Route::view('lite-confrence', 'school.framework.psychomotor.psychomotor_config')->name('school.psychomotor.config')->middleware('auth');

Route::get('load-psychomotor',[PsychomotorController::class,'index'])->name('load.psychomotor');
// create psychomotor
Route::post('create-psychomotor',[PsychomotorController::class,'createPsychomotor'])->name('create.psychomotor');
// load effective domain 
Route::get('load-effective-domian',[EffectiveDomainController::class,'index'])->name('load.effective-domain');
// create effective domain 
Route::post('create-effective-domain',[EffectiveDomainController::class,'createEffectiveDomain'])->name('create.effective.domain');
// load psycho grade 
Route::get('load-psycho-grade',[PsychoGradeKeyController::class,'index'])->name('load.psycho-grade');
// create psycho grade 
Route::post('create-psycho-grade',[PsychoGradeKeyController::class,'createPsychoGrade'])->name('create.psycho.grade');


// result config 
Route::view('lite-result-config', 'school.framework.result.result_config')->name('school.result.config')->middleware('auth');

Route::view('lite-create-staff', 'school.registration.staff.create-staff')->name('create.staff.form')->middleware('auth');
Route::view('lite-staff-list', 'school.staff.staff-list')->name('school.staff.list')->middleware('auth');
Route::post('lite-staff', [StaffController::class, 'createStaff'])->name('create.school.staff');
Route::post('lite-staff-role/{id}', [StaffController::class, 'staffRole'])->name('school.staff.role');
Route::post('lite-staff-access/{id}', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
Route::post('school-staff-class', [StaffController::class, 'assignClassToStaff'])->name('school.staff.class');
Route::post('lite-staff-subject', [StaffController::class, 'staffSubject'])->name('school.staff.subject');


// student 
Route::view('lite-registration', 'school.registration.index')->name('school.registration');
// student 
Route::view('lite-s-registration-form', 'school.registration.student.student-registration-form')->name('school.registration.student.form')->middleware('auth');
Route::post('lite-student-registration', [StudentRegistrationController::class, 'registerStudent'])->name('register.student');
Route::post('link-student-parent', [StudentController::class, 'linkStudentToParent'])->name('link.student.parent');

Route::view('lite-parent-registration-form', 'school.registration.parent.register-parent')->name('school.parent.registration.form')->middleware('auth');

Route::post('school-parent-registration', [ParentRegistrationController::class, 'registerParent'])->name('school.register.parent');

Route::post('change-parent-status', [ParentController::class, 'toggleParentStatus'])->name('toggle.parent.status');
Route::post('parent-profile/{id}', [ParentController::class, 'myProfile'])->name('school.parent.profile');

Route::get('parents-ward/{id}', [ParentController::class, 'myWards'])->name('school.parent.child');

// parent assistance 
Route::view('create-lite-rider-form', 'school.registration.rider.register-rider')->name('school.rider')->middleware('auth');
Route::post('create-lite-rider', [SchoolRiderController::class, 'submitSchoolRiderForm'])->name('create.lite.rider')->middleware('auth');

// link Activities 
// find staff for linking 
Route::get('find-existing-user/{key}', [SchoolController::class, 'findExistingUser']);
// link staff to school 
Route::get('link-existing-staff', [SchoolController::class, 'linkExistingUserToSchool'])->name('link.existing.staff');
// find student for linking 
Route::get('find-existing-student/{key}', [SchoolController::class, 'findExistingStudent']);
// link link to school 
Route::get('link-existing-student', [SchoolController::class, 'linkExistingStudentToSchool'])->name('link.existing.student');
// find student for linking 
Route::get('find-existing-parent/{key}', [SchoolController::class, 'findExistingParent']);
// link link to school 
Route::get('link-existing-parent', [SchoolController::class, 'linkExistingParentToSchool'])->name('link.existing.parent');
// find student for linking 
Route::get('find-existing-rider/{key}', [SchoolController::class, 'findExistingRider']);
// link link to school 
Route::get('link-existing-rider', [SchoolController::class, 'linkExistingRiderToSchool'])->name('link.existing.rider');

// list 
// list school staff 
Route::view('lite-staff-list', 'school.lists.staff.staff-list')->name('school.staff.list')->middleware('auth');
// load staff 
// load active staff 
Route::get('load-staff-list', [StaffController::class,'index'])->name('load.staff.list');
Route::get('in-active-staff-list', [StaffController::class, 'inActiveStaff'])->name('load.inactive.staff.list');

// profile 
// staff profile 
Route::get('staff-profile/{id}', [StaffController::class, 'staffProfile'])->name('school.staff.profile');
Route::post('loadstaff-profile', [StaffController::class, 'loadStaffProfile'])->name('load.staff.profile');


// student list 
Route::view('lite-s-list', 'school.lists.student.student-list')->name('school.student.list')->middleware('auth');
Route::get('load-student-list', [StudentController::class, 'index'])->name('load.school.student.list');
// student list 
Route::view('lite-p-list', 'school.lists.parent.parent-list')->name('school.parent.list')->middleware('auth');
Route::get('load-parent-list', [ParentController::class, 'index'])->name('load.school.parent.list');
// student list 
Route::view('lite-rider-list', 'school.lists.rider.rider-list')->name('school.rider.list')->middleware('auth');
Route::get('load-rider-list', [SchoolRiderController::class, 'index'])->name('load.school.rider.list');

// student profile 
Route::get('student-profile/{id}', [StudentController::class, 'studentProfile'])->name('school.student.profile');
Route::post('view-student-profile', [StudentController::class, 'viewStudentProfile'])->name('load.student.profile');
Route::post('view-student-class-history', [StudentController::class, 'viewStudentClassHistroy'])->name('load.student.class');
Route::post('view-student-results', [StudentController::class, 'viewStudentResult'])->name('load.student.result');
// student profile 
Route::get('parent-profile/{id}', [ParentController::class, 'parentProfile'])->name('school.parent.profile');
Route::get('view-parent-profile', [ParentController::class, 'viewParentProfile'])->name('view.parent.profile');
// student profile 
Route::get('rider-profile/{id}', [SchoolRiderController::class, 'riderProfile'])->name('school.rider.profile');
Route::post('view-rider-profile', [SchoolRiderController::class, 'viewRiderProfile'])->name('view.rider.profile');
Route::get('load-rider-student', [SchoolRiderCntroller::class, 'viewRiderStudent'])->name('load.rider.student');



//student attendance
Route::view('std-a-f', 'school.student.attendance.student-attendance-form')->name('student.attendance.form')->middleware('auth');
Route::post('std-a-f', [StudentAttendanceController::class,'loadArmStudent']);
Route::post('std-a-f', [StudentAttendanceController::class,'loadArmStudent'])->name('attendance.change.class');
Route::post('submit-student-attendance', [StudentAttendanceController::class,'submitStudentAttendance'])->name('submit.student.attendance');

// student assessment 
Route::view('student-subject-score-form', 'school.student.assessment.assessment-form')->name('student.assessment.form')->middleware('auth');
Route::post('student-subject-score-form', [StudentScoreController::class, 'enterStudentScoreRecord']);
Route::post('change-arm-subject', [StudentScoreController::class, 'changeSubject'])->name('change.arm.subject');
Route::get('student-score-entering', [StudentScoreController::class, 'enterStudentScore'])->name('enter.student.score');
Route::post('submit-student-ca', [StudentScoreController::class, 'submitCaScore'])->name('submit.student.ca');
Route::post('change-student-ca-student', [StudentScoreController::class, 'changeSubjectResultStatus'])->name('change.student.ca.student');
// view student subject score 
Route::view('view-student-subject-score-form', 'school.student.assessment.view-subject-score-form')->name('view.student.subject.score.form')->middleware('auth');
Route::post('view-student-subject-score-form', [StudentScoreController::class, 'viewStudentScoreRecord']);
Route::get('view-student-score', [StudentScoreController::class, 'loadStudentScore'])->name('view.student.score');

// psychomotor 
Route::view('student-ps-form', 'school.student.psychomotor.psychomotor-form')->name('psychomotor.assessment.form')->middleware('auth');
Route::post('student-ps-form', [RecordPsychomotorController::class, 'loadPsychomotoKeys']);
Route::post('record-psychomotor-score', [RecordPsychomotorController::class, 'recordPsychomotorScore'])->name('record.psycomotor.score');
// affective domain 
Route::view('student-ad-form', 'school.student.affective.affective-form')->name('affective.assessment.form')->middleware('auth');
Route::post('student-ad-form', [AffectiveDomainController::class, 'loadAffecitveKeys']);
Route::post('record-affective-score', [AffectiveDomainController::class, 'recordAffectiveDomainScore'])->name('record.affective.score');



// view student result 
Route::view('view-student-termly-result', 'school.student.result.termly-result.view-termly-result-form')->name('view.student.termly.result')->middleware('auth');
Route::post('view-student-termly-result', [StudentTermlyResultController::class, 'loadStudentResult']);
// redirect to this route 
Route::get('student-termly-result', [StudentTermlyResultController::class, 'classResult'])->name('view.student.result');
// particular student money
Route::get('s-r-c/{param}/{pid}', [StudentTermlyResultController::class, 'studentReportCard'])->name('student.report.card');
// view student cumualtive result 
//view-student-cumualtive-result
Route::view('v-s-c-r', 'school.student.result.cumulative.cumulative-result-form')->name('view.student.cumualtive.result')->middleware('auth');
Route::post('v-s-c-r', [ViewCumulativeResultController::class, 'loadStudentCumulativeResult']);
Route::get('s-c-r-c/{param}/{std}', [ViewCumulativeResultController::class, 'studentCumulativeReportCard'])->name('student.cumulative.result');
// redirect to this route 
// particular student money
Route::get('s-c-r/{param}/{pid}', [StudentTermlyResultController::class, 'studentReportCard'])->name('student.report.card');

// comments 
// principal comment 
Route::view('principal-comment-termly-result','school.student.result.comments..principal.principal-comment-form')->name('principal.comment.termly.result')->middleware('auth');
// the view // princal-comment.blade.php
Route::post('principal-comment-termly-result',[CommentResultController::class,'loadStudentResult']);
// pricinpal commenting 
Route::post('principal-commenting-termly-result',[CommentResultController::class,'principalCommentStudentTermlyResult'])->name('comment.principal.student.termly.result');
// class teacher comment
Route::view('teacher-comment-termly-result', 'school.student.result.comments.teacher.teacher-comment-form')->name('teacher.comment.termly.result')->middleware('auth');
// load student result
Route::post('teacher-comment-termly-result',[TeacherCommentResultController::class,'loadStudentResult']);
// commenting student result
Route::post('teacher-commenting-termly-result',[TeacherCommentResultController::class,'teacherCommentStudentTermlyResult'])->name('comment.teacher.student.termly.result');
// class portal comment
Route::view('portals-comment-termly-result', 'school.student.result.comments.portals.portals-comment-form')->name('portal.comment.termly.result')->middleware('auth');

Route::post('portals-comment-termly-result', [PortalCommentResultController::class, 'loadStudentResult']);
// class portal comment
Route::post('portals-commenting-termly-result', [PortalCommentResultController::class, 'portalsCommentStudentTermlyResult'])->name('comment.portals.student.termly.result');
// class subject teacher comment
Route::view('subject-comment-termly-result', 'school.student.result.comments.principal-comment-form')->name('subject.comment.termly.result')->middleware('auth');
// student promotion 
Route::view('promote-student-form', 'school.student.promotion.promote-student-form')->name('promote.student.form')->middleware('auth');
Route::post('promote-student-form', [PromoteStudentController::class,'loadStudent'])->name('promote.student.form')->middleware('auth');
Route::post('promote-student', [PromoteStudentController::class,'promoteStudent'])->name('promote.student');


