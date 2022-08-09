<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Framework\Select2Controller;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\Organisation\OrganisationController;
use App\Http\Controllers\Organisation\OrgUserAccessController;
use App\Http\Controllers\Organisation\OrganisationUserController;
use App\Http\Controllers\School\Framework\Grade\GradeKeyController;
use App\Http\Controllers\School\Framework\Subject\SubjectController;
use App\Http\Controllers\School\Framework\Term\SchoolTermController;
use App\Http\Controllers\School\Framework\Subject\SubjectTypeController;
use App\Http\Controllers\School\Framework\Session\SchoolSessionController;
use App\Http\Controllers\School\Registration\StudentRegistrationController;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Framework\Attendance\AttendanceTypeController;
use App\Http\Controllers\School\Framework\Assessment\AssessmentTitleController;
use App\Http\Controllers\School\Framework\Psycho\EffectiveDomainController;
use App\Http\Controllers\School\Framework\Psycho\PsychoGradeKeyController;
use App\Http\Controllers\School\Framework\Psycho\PsychomotorController;
use App\Http\Controllers\School\Parent\ParentController;
use App\Http\Controllers\School\Registration\ParentRegistrationController;
use App\Http\Controllers\School\Rider\SchoolRiderController;
use App\Http\Controllers\School\Student\StudentController;

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
Route::view('lite-class', 'school.framework.class.class_and_category')->name('school.class')->middleware('auth');
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
Route::view('lite-assessment-title', 'school.framework.assessment.assessment_title')->name('school.assessment.title')->middleware('auth');
Route::get('load-assessment-title', [AssessmentTitleController::class, 'index'])->name('load.school.assessment.title');
// submiting form and create assessment title 
Route::post('lite-assessment-title', [AssessmentTitleController::class, 'createAssessmentTitle'])->name('school.assessment.title');

// load dropdon select2
// load school on dropdon using select2  
Route::get('load-available-session', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.session')->middleware('auth');
// load category 
Route::get('load-available-category', [Select2Controller::class, 'loadAvailableCategory'])->name('load.available.category')->middleware('auth');
// load assessment title 
Route::get('load-available-title', [AssessmentTitleController::class, 'loadAvailableTitle'])->name('load.available.title');
// load term 
Route::get('load-available-term', [SchooltermController::class, 'loadSchoolTerm'])->name('load.available.term')->middleware('auth');
// load classes 
Route::post('load-available-class', [Select2Controller::class, 'loadAvailableClass'])->name('load.available.class');
// load classe arm 
Route::post('load-available-class-arm', [Select2Controller::class, 'loadAvailableClassArm'])->name('load.available.class.arm');
// load category subject 
Route::post('load-available-category-subject', [Select2Controller::class, 'loadAvailableSelectedCategorySubject'])->name('load.available.category.subject');
// load school head of staff 
Route::get('load-available-school-category-head', [Select2Controller::class, 'loadAvailableCategoryHead'])->name('load.available.school.category.head');
// load subject type 
Route::get('drop-down-subject-type', [SubjectTypeController::class, 'loadAvailableSubjectType'])->name('load.available.subject.type');
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
Route::post('create-lite-category-subject',[SubjectController::class, 'createSchoolCategorySubject'])->name('create.school.subject');


// grade key 
Route::view('lite-grade-key', 'school.framework.grade.grade_key')->name('school.grade.key')->middleware('auth');
Route::get('load-lite-grade-key',[GradeKeyController::class, 'index'])->name('load.school.grade.key');
Route::post('lite-grade-key',[GradeKeyController::class, 'createGradeKey'])->name('school.grade.key');
Route::view('lite-attendance', 'school.framework.attendance.attendance_setting')->name('school.attendance.setting')->middleware('auth');
Route::get('load-attendance',[AttendanceTypeController::class,'index'])->name('load.school.attendance.setting');
Route::post('lite-attendance',[AttendanceTypeController::class, 'createAttendanceType']);
Route::post('lite-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.class.attendance');
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

Route::view('lite-create-staff', 'school.registration.staff.create_staff')->name('create.staff.form')->middleware('auth');
Route::view('lite-staff-list', 'school.staff.staff_list')->name('school.staff.list')->middleware('auth');
Route::post('lite-staff', [StaffController::class, 'createStaff'])->name('create.school.staff');
Route::post('lite-staff-role/{id}', [StaffController::class, 'staffRole'])->name('school.staff.role');
Route::post('lite-staff-access/{id}', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
Route::post('lite-staff-class', [StaffController::class, 'staffClass'])->name('school.staff.class');
Route::post('lite-staff-subject', [StaffController::class, 'staffSubject'])->name('school.staff.subject');


// student 
Route::view('lite-registration', 'school.registration.index')->name('school.registration');
// student 
Route::view('lite-s-registration-form', 'school.registration.student.register_student')->name('school.registration.student.form')->middleware('auth');
Route::post('lite-student-registration', [StudentRegistrationController::class, 'registerStudent'])->name('register.student');

Route::view('lite-parent-registration-form', 'school.registration.parent.register-parent')->name('school.parent.registration.form')->middleware('auth');
Route::post('school-parent-registration', [ParentRegistrationController::class, 'registerParent'])->name('school.register.parent');
// parent assistance 
Route::view('create-lite-rider-form', 'school.registration.rider.register-rider')->name('school.rider')->middleware('auth');
Route::post('create-lite-rider', [SchoolRiderController::class, 'submitSchoolRiderForm'])->name('create.lite.rider')->middleware('auth');


// list 
// list school staff 
Route::view('lite-staff-list', 'school.lists.staff.staff-list')->name('school.staff.list')->middleware('auth');
// load staff 
// load active staff 
Route::get('load-staff-list', [StaffController::class,'index'])->name('load.staff.list');
Route::get('in-active-staff-list', [StaffController::class, 'inActiveStaff'])->name('load.inactive.staff.list');

// student list 
Route::view('lite-s-list', 'school.lists.student.student-list')->name('school.student.list')->middleware('auth');
Route::get('load-student-list', [StudentController::class, 'index'])->name('load.school.student.list');
// student list 
Route::view('lite-p-list', 'school.lists.parent.parent-list')->name('school.parent.list')->middleware('auth');
Route::get('load-parent-list', [ParentController::class, 'index'])->name('load.school.parent.list');
// student list 
Route::view('lite-rider-list', 'school.lists.rider.rider-list')->name('school.rider.list')->middleware('auth');
Route::get('load-rider-list', [SchoolRiderController::class, 'index'])->name('load.school.rider.list');

// profile 
// staff profile 
Route::get('staff-profile/{id}', [StaffController::class, 'staffProfile'])->name('school.staff.profile');
Route::get('view-staff-profile', [StaffController::class, 'viewStaffProfile'])->name('view.staff.profile');
// student profile 
Route::get('student-profile/{id}', [StudentController::class, 'staffProfile'])->name('school.student.profile');
Route::get('view-student-profile', [StudentController::class, 'viewStaffProfile'])->name('view.student.profile');
// student profile 
Route::get('parent-profile/{id}', [ParentController::class, 'parentProfile'])->name('school.parent.profile');
Route::get('view-parent-profile', [ParentController::class, 'viewParentProfile'])->name('view.parent.profile');
// student profile 
Route::get('rider-profile/{id}', [SchoolRiderController::class, 'riderProfile'])->name('school.rider.profile');
Route::get('view-rider-profile', [SchoolRiderController::class, 'viewRiderProfile'])->name('view.rider.profile');