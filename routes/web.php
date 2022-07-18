<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auths\AuthController;
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

// port 8400
Route::view('/','welcome');
// authentication 
// sign up 
// sign up form 
Route::view('sign-up', 'auths.sign-up');
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
Route::post('lite', [SchoolController::class, 'create']);
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
Route::get('lite-class', [ClassController::class, 'index'])->name('school.class');
// create category 
Route::post('lite-category', [ClassController::class, 'createCategory'])->name('school.category');
// create class 
Route::post('lite-class', [ClassController::class, 'createClass'])->name('school.class');
// create class arm 
Route::post('lite-arm', [ClassController::class, 'createClassArm'])->name('school.arm');
// academic session
Route::view('lite-session', 'school.framework.session.school_session')->name('school.session');
Route::get('ajax-session',[SchoolSessionController::class,'ajax'])->name('ajax.session');
Route::post('lite-session',[SchoolSessionController::class,'createSession'])->name('school.session');
Route::post('lite-session-active',[SchoolSessionController::class,'setActiveSession'])->name('school.session.active');

// terms 
Route::get('lite-term',[SchoolTermController::class,'index'])->name('school.term');
Route::post('lite-term',[SchoolTermController::class,'createTerm'])->name('school.term');
Route::post('lite-active-term',[SchoolTermController::class, 'setActiveTerm'])->name('school.term.active');
// subjects  
// subject type
Route::get('lite-subject-type',[SubjectTypeController::class, 'index'])->name('school.subject.type');
Route::post('lite-subject-type',[SubjectTypeController::class, 'createSubjectType']);
Route::post('lite-subject',[SubjectController::class, 'createSubject'])->name('school.subject');

// Assesment Title
Route::get('lite-assessment-title',[AssessmentTitleController::class, 'index'])->name('school.assessment.title');
// submiting form and create assessment title 
Route::post('lite-assessment-title',[AssessmentTitleController::class, 'createAssessmentTitle']);

// score settings 
Route::post('lite-score-settings',[ScoreSettingsController::class, 'createScoreSettings'])->name('school.score.settings');

// grade key 
Route::get('lite-grade-key',[GradeKeyController::class, 'index'])->name('school.grade.key');
Route::post('lite-grade-key',[GradeKeyController::class, 'createGradeKey']);
Route::get('lite-attendance',[AttendanceTypeController::class, 'index'])->name('school.attendance');
Route::post('lite-attendance',[AttendanceTypeController::class, 'createAttendanceType']);
Route::post('lite-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.class.attendance');
// Route::post('school-take-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.take.class.attendance');

Route::get('lite-staff/{id}', [StaffController::class, 'index'])->name('school.staff');
Route::post('lite-staff/{id}', [StaffController::class, 'create'])->name('school.staff');
Route::post('lite-staff-role/{id}', [StaffController::class, 'staffRole'])->name('school.staff.role');
Route::post('lite-staff-access/{id}', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
Route::post('lite-staff-class', [StaffController::class, 'staffClass'])->name('school.staff.class');
Route::post('lite-staff-subject', [StaffController::class, 'staffSubject'])->name('school.staff.subject');

// student 
Route::view('lite-registration', 'school.registration.index')->name('school.registration');
// student 
Route::get('lite-student-registration', [StudentRegistrationController::class, 'index'])->name('school.student.registration');
Route::post('lite-student-registration', [StudentRegistrationController::class, 'registerStudent']);

Route::get('lite-parent-registration', [StaffController::class, 'index'])->name('school.parent.registration');
