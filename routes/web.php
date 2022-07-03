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
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// user dashboard 
Route::get('users-dashboard', [UserController::class, 'index'])->name('users.dashboard');

// user create organization 
Route::get('create-organisaion', [OrganisationController::class, 'index'])->name('create.organisation');
Route::post('create-organisaion', [OrganisationController::class,'create']);
Route::get('update-organisaion/{id}', [OrganisationController::class,'update'])->name('update.organisation');
Route::get('delete-organisaion/{id}', [OrganisationController::class,'update'])->name('delete.organisation');
// load organisation user
Route::get('organisation-users',[OrganisationUserController::class,'index'])->name('organisation.users');
// add user to organisation 
Route::post('organisation-users',[OrganisationUserController::class,'create'])->name('organisation.users');
// organisation user access right 
Route::post('organisation-user-access',[OrgUserAccessController::class,'store'])->name('organisation.user.access');
// sign up with organisation link direct 
// Route::post('organisation-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('organisation.sign.up');

// user create school 
Route::get('school', [SchoolController::class, 'index'])->name('create.school');
Route::post('school', [SchoolController::class, 'create']);
Route::get('update-school/{id}', [SchoolController::class, 'update'])->name('update.school');
Route::get('delete-school/{id}', [SchoolController::class, 'update'])->name('delete.school');
// load school user
Route::get('school-users', [SchoolUserController::class, 'index'])->name('school.users');
// add user to school 
Route::post('school-users', [SchoolUserController::class, 'create'])->name('school.users');
// school user access right 
Route::post('school-user-access', [SchoolUserAccessController::class, 'store'])->name('school.user.access');
// sign up with school link direct 
// Route::post('school-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('school.sign.up');
Route::get('school-class', [ClassController::class, 'index'])->name('school.class');
// create category 
Route::post('school-category', [ClassController::class, 'createCategory'])->name('school.category');
// create class 
Route::post('school-class', [ClassController::class, 'createClass'])->name('school.class');
// create class arm 
Route::post('school-arm', [ClassController::class, 'createClassArm'])->name('school.arm');
// academic session
Route::get('school-session',[SchoolSessionController::class,'index'])->name('school.session');
Route::post('school-session',[SchoolSessionController::class,'createSession'])->name('school.session');
Route::post('school-session-active',[SchoolSessionController::class,'setActiveSession'])->name('school.session.active');

// terms 
Route::get('school-term',[SchoolTermController::class,'index'])->name('school.term');
Route::post('school-term',[SchoolTermController::class,'createTerm'])->name('school.term');
Route::post('school-active-term',[SchoolTermController::class, 'setActiveTerm'])->name('school.term.active');
// subjects  
// subject type
Route::get('school-subject-type',[SubjectTypeController::class, 'index'])->name('school.subject.type');
Route::post('school-subject-type',[SubjectTypeController::class, 'createSubjectType']);
Route::post('school-subject',[SubjectController::class, 'createSubject'])->name('school.subject');

// Assesment Title
Route::get('school-assessment-title',[AssessmentTitleController::class, 'index'])->name('school.assessment.title');
// submiting form and create assessment title 
Route::post('school-assessment-title',[AssessmentTitleController::class, 'createAssessmentTitle']);

// score settings 
Route::post('school-score-settings',[ScoreSettingsController::class, 'createScoreSettings'])->name('school.score.settings');

// grade key 
Route::get('school-grade-key',[GradeKeyController::class, 'index'])->name('school.grade.key');
Route::post('school-grade-key',[GradeKeyController::class, 'createGradeKey']);
Route::get('school-attendance',[AttendanceTypeController::class, 'index'])->name('school.attendance');
Route::post('school-attendance',[AttendanceTypeController::class, 'createAttendanceType']);
Route::post('school-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.class.attendance');
// Route::post('school-take-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.take.class.attendance');

Route::get('school-staff/{id}', [StaffController::class, 'index'])->name('school.staff');
Route::post('school-staff/{id}', [StaffController::class, 'create'])->name('school.staff');
Route::post('school-staff-role/{id}', [StaffController::class, 'staffRole'])->name('school.staff.role');
Route::post('school-staff-access/{id}', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
Route::post('school-staff-class', [StaffController::class, 'staffClass'])->name('school.staff.class');
Route::post('school-staff-subject', [StaffController::class, 'staffSubject'])->name('school.staff.subject');

// student 
Route::view('school-registration', 'school.registration.index')->name('school.registration');
// student 
Route::get('school-student-registration', [StudentRegistrationController::class, 'index'])->name('school.student.registration');
Route::post('school-student-registration', [StudentRegistrationController::class, 'registerStudent']);

Route::get('school-parent-registration', [StaffController::class, 'index'])->name('school.parent.registration');
