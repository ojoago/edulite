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
use App\Http\Controllers\School\Upload\UploadRiderController;
use App\Http\Controllers\School\Upload\UploadStaffController;
use App\Http\Controllers\Organisation\OrgUserAccessController;
use App\Http\Controllers\School\Admission\AdmissionController;
use App\Http\Controllers\School\Upload\UploadParentController;
use App\Http\Controllers\School\Student\StudentClassController;
use App\Http\Controllers\School\Student\StudentScoreController;
use App\Http\Controllers\School\Upload\UploadStudentController;
use App\Http\Controllers\Organisation\OrganisationUserController;
use App\Http\Controllers\School\Framework\Fees\FeeItemController;
use App\Http\Controllers\School\Framework\Hostel\HostelController;
use App\Http\Controllers\School\Framework\Grade\GradeKeyController;
use App\Http\Controllers\School\Framework\Subject\SubjectController;
use App\Http\Controllers\School\Framework\Term\SchoolTermController;
use App\Http\Controllers\School\Framework\Subject\SubjectTypeController;
use App\Http\Controllers\School\Framework\Timetable\TimetableController;
use App\Http\Controllers\School\Framework\Psycho\PsychoGradeKeyController;
use App\Http\Controllers\School\Framework\Session\SchoolSessionController;
use App\Http\Controllers\School\Registration\ParentRegistrationController;
use App\Http\Controllers\School\Framework\Psycho\AffectiveDomainController;
use App\Http\Controllers\School\Registration\StudentRegistrationController;
use App\Http\Controllers\School\Student\Promotion\PromoteStudentController;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Framework\Admission\AdmissionConfigController;
use App\Http\Controllers\School\Framework\Attendance\AttendanceTypeController;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;
use App\Http\Controllers\School\Framework\Assessment\AssessmentTitleController;
use App\Http\Controllers\School\Student\Attendance\StudentAttendanceController;
use App\Http\Controllers\School\Framework\Psychomotor\PsychomotorBaseController;
use App\Http\Controllers\School\Student\Results\Termly\StudentTermlyResultController;
use App\Http\Controllers\School\Student\Result\Comments\PortalCommentResultController;
use App\Http\Controllers\School\Student\Results\Comments\TeacherCommentResultController;
use App\Http\Controllers\School\Student\Results\Comments\PrincipalCommentResultController;
use App\Http\Controllers\School\Student\Results\Cumulative\ViewCumulativeResultController;
use App\Http\Controllers\School\Student\Assessment\Psychomotor\RecordPsychomotorController;
use App\Http\Controllers\Users\HireAbleController;

// port 8400
Route::view('/','welcome')->middleware('guest');
// Route::view('/401','welcome')->name('401')->middleware('guest');
// authentication 
// sign up 
Route::get('/mail',function(){
    
    return view('mails.school-mail');
});
// sign up form 
// Route::view('sign-up/{id?}', [AuthController::class, 'signUpForm'])->name('sign.up')->middleware('guest');
Route::view('sign-up', 'auths.sign-up')->name('sign.up')->middleware('guest');
// signing up 
Route::post('sign-up', [AuthController::class, 'signUp']);
// verify account 
Route::get('verify/{id}', [AuthController::class, 'verifyAccount'])->middleware('guest');
// login page 
Route::view('login', 'auths.login')->name('login')->middleware('guest');
// login in 
Route::post('login', [AuthController::class, 'login']);
// reset password 
Route::get('reset/{id}', [AuthController::class, 'resetPasswordForm'])->name('reset')->middleware('guest');

Route::post('reset', [AuthController::class, 'resetPassword'])->name('reset.password')->middleware('guest');
Route::post('forget-password', [AuthController::class, 'forgetPassword'])->name('forget')->middleware('guest');
// update password 
Route::post('update-password', [AuthController::class, 'updatePassword'])->name('update.password')->middleware('auth');
// Logout
// Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');// app logout 
Route::get('logout-school', [AuthController::class, 'logoutSchool'])->middleware('auth')->name('logout.school'); // school log out

// user dashboard 
Route::get('users-dashboard', [UserController::class, 'index'])->name('users.dashboard');
Route::get('users-home', [UserController::class, 'dashboard'])->name('users.home');

// user create organization 
Route::get('create-base', [OrganisationController::class, 'index'])->name('create.organisation');
Route::post('create-base', [OrganisationController::class,'create']);
Route::get('update-base/{id}', [OrganisationController::class,'update'])->name('update.organisation');
Route::get('delete-base/{id}', [OrganisationController::class,'update'])->name('delete.organisation');
// load organisation user
Route::get('base-users',[OrganisationUserController::class,'index'])->name('organisation.users');
// add user to organisation 
Route::post('base-users',[OrganisationUserController::class,'create']);
// organisation user access right 
Route::post('base-user-access',[OrgUserAccessController::class,'store'])->name('organisation.user.access');
// sign up with organisation link direct 
// Route::post('organisation-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('organisation.sign.up');
Route::view('create-school', 'school.create-school')->name('create.school');
Route::view('help', 'helps.help')->name('helps');
Route::post('create-school', [SchoolController::class, 'createSchool']);
Route::get('school-sign-in/{id}', [SchoolController::class, 'schoolLogin'])->name('login.school');
//load states
Route::post('load-available-state', [Select2Controller::class, 'loadStates'])->name('load.available.state');
//load school states
Route::post('load-available-state-lga', [Select2Controller::class, 'loadStatesLga'])->name('load.available.state.lga');
// load all the subject of every school in a state 
Route::post('load-available-all-state-subjects', [Select2Controller::class, 'loadAllStateSchoolSubject'])->name('load.available.all.state.subject');


Route::get('load-user-detail', [UserController::class, 'loadUserDetail'])->name('load.user.detail');
Route::post('update-user-detail', [UserController::class, 'updateUserDetail'])->name('update.user.detail');
    

Route::middleware('schoolAuth')->group(function(){
    // user create school 
    Route::get('school-dashboard', [SchoolController::class, 'mySchoolDashboard'])->name('my.school.dashboard');
    Route::get('update-school', [SchoolController::class, 'index'])->name('edit.school.info');
    Route::post('load-school-info', [SchoolController::class, 'loadSchoolDetailById'])->name('load.school.info');
    Route::get('delete-school/{id}', [SchoolController::class, 'update'])->name('delete.school');
    // load school user
    Route::get('school-users', [SchoolUserController::class, 'index'])->name('school.users');
    // add user to school 
    Route::post('school-users', [SchoolUserController::class, 'create']);
    // school user access right 
    Route::post('school-user-access', [SchoolUserAccessController::class, 'store'])->name('school.user.access');
    // sign up with school link direct 
    // Route::post('school-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('school.sign.up');
    // category and class has the same controller 
    Route::view('school-class', 'school.framework.class.class-and-category')->name('school.class');
    // tab 1 
    Route::get('load-school-category', [ClassController::class, 'loadCategory'])->name('load.school.category');
    // tab 2 
    Route::get('load-school-class', [ClassController::class, 'loadClasses'])->name('load.school.classes');
    // tab 3 
    Route::get('load-school-class-arm', [ClassController::class, 'loadClassArm'])->name('load.school.class.arm');
    // tab 4 
    Route::post('load-school-class-arm-subject', [ClassController::class, 'loadClassArmSubject'])->name('load.school.class.arm.subject');
    // create category 
    Route::post('create-school-category', [ClassController::class, 'createCategory'])->name('create.school.category');
    Route::post('load-school-category-by-pid', [ClassController::class, 'loadCategoryByPid'])->name('load.school.category.by.pid');
    // create class 
    Route::post('school-class', [ClassController::class, 'createClass'])->name('create.school.class');
    // create class arm 
    Route::post('school-arm', [ClassController::class, 'createClassArm'])->name('create.school.class.arm');
    // create class arm 
    Route::post('create-class-arm-subject', [ClassController::class, 'createClassArmSubject'])->name('create.school.class.arm.subject');
    // create class arm 
    Route::post('create-class-timetable', [TimetableController::class, 'createClassTimetable'])->name('create.school.timetable');
    Route::post('load-class-timetable', [TimetableController::class, 'index'])->name('load.school.timetable');
    // particular student timetable
    Route::post('load-student-timetable', [TimetableController::class, 'loadStudentTimetable'])->name('load.student.timetable');
    // create class arm rep 
    Route::post('assign-class-arm-rep', [StudentClassController::class, 'assignClassRep'])->name('assign.class.arm.rep');
    // academic session
    Route::view('school-session', 'school.framework.session.school-session')->name('school.session');
    // create new session 
    Route::post('school-session', [SchoolSessionController::class, 'createSession']);
    // load session on tab with datatable server  
    Route::get('load-school-session', [SchoolSessionController::class, 'index'])->name('load.school.session');

    // active school session 
    // load active session on tab 
    Route::get('load-school-active-session', [SchoolSessionController::class, 'loadSchoolActiveSession'])->name('load.school.active.session');
    // update active session 
    Route::post('school-session-active', [SchoolSessionController::class, 'setActiveSession'])->name('school.session.active');

    // terms 
    Route::view('school-term', 'school.framework.terms.school-terms')->name('school.term');
    Route::get('list-school-term', [SchoolTermController::class, 'index'])->name('school.list.term');
    Route::post('school-term', [SchoolTermController::class, 'createSchoolTerm']);
    Route::post('school-active-term', [SchoolTermController::class, 'setSchoolActiveTerm'])->name('school.term.active');
    Route::get('load-active-term', [SchoolTermController::class, 'loaSchoolActiveTerm'])->name('load.school.active.term');
    Route::get('load-active-term-detail', [SchoolTermController::class, 'loaSchoolActiveTermDetails'])->name('load.school.active.term.details');


    // Assesment Title
    Route::view('school-assessment-title', 'school.framework.assessment.assessment-title')->name('school.assessment.title');
    Route::get('load-assessment-title', [AssessmentTitleController::class, 'index'])->name('load.school.assessment.title');
    // submiting form and create assessment title 
    Route::post('school-assessment-title', [AssessmentTitleController::class, 'createAssessmentTitle']);
    //load score settings 
    Route::get('load-score-setting', [ScoreSettingsController::class, 'index'])->name('load.score.setting');

    // load dropdon select2
    // load school on dropdon using select2  
    Route::post('load-available-', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.dropdown');
    
    Route::post('load-available-session', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.session');
    // load category 
    Route::post('load-available-category', [Select2Controller::class, 'loadAvailableCategory'])->name('load.available.category');
    // load assessment title 
    Route::post('load-available-title', [AssessmentTitleController::class, 'loadAvailableTitle'])->name('load.available.title');
    // load term 
    Route::post('load-available-term', [SchooltermController::class, 'loadSchoolTerm'])->name('load.available.term');
    // load classes 
    Route::post('load-available-class', [Select2Controller::class, 'loadAvailableClass'])->name('load.available.class');
    // load all category classes 
    Route::post('load-available-all-class', [Select2Controller::class, 'loadAvailableAllClasses'])->name('load.available.all.class');
    // admission class
    Route::post('load-available-admission-class', [Select2Controller::class, 'loadAvailableAdmissionClass'])->name('load.available.admission.class');
    // load classe arm 
    Route::post('load-available-class-arm', [Select2Controller::class, 'loadAvailableClassArm'])->name('load.available.class.arm');
    // load class teacher/form classes 
    Route::post('load-available-class-teacher-arm', [Select2Controller::class, 'loadClassTeacherClassArms'])->name('load.available.class.arm');
    Route::post('load-available-all-class-arm', [Select2Controller::class, 'loadAllClassArm'])->name('load.all.class.arm');
    // load class arm subject
    Route::post('load-available-class-arm-subject', [Select2Controller::class, 'loadAvailableClassArmSubject'])->name('load.available.class.arm.subject');
    // load subjects of all arms under class
    Route::post('load-available-all-arms-subject', [Select2Controller::class, 'loadAvailableClassAllArmsSubject']);
    // load category subject 
    Route::post('load-available-category-subject', [Select2Controller::class, 'loadAvailableSelectedCategorySubject'])->name('load.available.category.subject');
    // load school head of staff 
    Route::post('load-available-school-category-head', [Select2Controller::class, 'loadAvailableCategoryHead'])->name('load.available.school.category.head');
    //load school teachers
    Route::post('load-available-school-teachers', [Select2Controller::class, 'loadAvailableTeacher'])->name('load.available.school.teacher');
    //load all school student
    Route::post('load-available-student', [Select2Controller::class, 'loadStudents'])->name('load.available.school.student');
    //load boarding school student
    Route::post('load-available-boarding-student', [Select2Controller::class, 'loadBoardingStudents'])->name('load.available.boarding.student');
    //load school student
    Route::post('load-available-class-arm-student', [Select2Controller::class, 'loadClassArmStudents'])->name('load.available.school.arm.student');
    //load school parents
    Route::post('load-available-parent', [Select2Controller::class, 'loadSchoolParent'])->name('load.available.parent');

    Route::post('load-available-rider', [Select2Controller::class, 'loadSchoolRider'])->name('load.available.rider');
    // load subject type 
    Route::post('load-available-subject-type', [Select2Controller::class, 'loadAvailableSubjectType'])->name('load.available.subject.type');
    // score settings 
    Route::post('school-score-settings', [ScoreSettingsController::class, 'createScoreSettings'])->name('create.school.score.settings');
    // load hostel 
    Route::post('load-available-hostels', [Select2Controller::class, 'loadAvailableHostels']);
    // portal 
    Route::post('load-available-portals', [Select2Controller::class, 'loadAvailablePortals']);
    
    // psychomotor 
    // load psychomotor by school cateogry
    Route::post('load-available-psychomotors', [Select2Controller::class, 'loadAvailablePsychomotors']);
    // load all psychomotor 
    Route::post('load-available-psychomotors-all', [Select2Controller::class, 'loadAvailableAllPsychomotors']);







    // fee items 
    Route::post('load-available-fee-items', [Select2Controller::class, 'loadAvailableFeeItem']);

    Route::post('load-available-on-demand-fee', [Select2Controller::class, 'loadAvailableOnDemandFee']);

    // subjects & subject type
    // load subject type page 
    Route::view('school-subject-type', 'school.framework.subject.subjects')->name('school.subject.type');
    // load subject type 
    Route::get('load-subject-type', [SubjectTypeController::class, 'index'])->name('load.school.subject.type');
    // create subject type 
    Route::post('school-subject-type', [SubjectTypeController::class, 'createSubjectType'])->name('create.school.subject.type');
    // load subjects 
    Route::post('load-school-subject', [SubjectController::class, 'index'])->name('load.school.subject');
    // create school category subject 
    Route::post('create-subject-subject', [SubjectController::class, 'createSchoolSubject'])->name('create.school.subject');
    Route::post('load-subject-by-id', [SubjectController::class, 'loadSubjectById'])->name('load.subject.by.id');


    // grade key 
    Route::view('school-grade-key', 'school.framework.grade.grade-key')->name('school.grade.key');
    Route::get('load-school-grade-key', [GradeKeyController::class, 'index'])->name('load.school.grade.key');
    Route::get('load-school-grade-key-by-class', [GradeKeyController::class, 'loadGradeKeyByClass'])->name('load.class.grade.key');
    Route::post('school-grade-key', [GradeKeyController::class, 'createGradeKey']);
    Route::view('school-attendance', 'school.framework.attendance.attendance-setting')->name('school.attendance.setting');
    Route::get('load-attendance', [AttendanceTypeController::class, 'index'])->name('load.school.attendance.setting');
    Route::post('school-attendance', [AttendanceTypeController::class, 'createAttendanceType']);
    Route::post('school-class-attendance', [AttendanceTypeController::class, 'createClassAttendance'])->name('school.class.attendance');
    // Route::post('school-take-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.take.class.attendance');


    // Psychomotor, effective domain and grade key 
    // Psychomotor 
    Route::view('extra-curricular', 'school.framework.psychomotor.psychomotor-config')->name('school.psychomotor.config');

    Route::view('timetable-config', 'school.framework.timetable.timetable-config')->name('timetable.config');

    Route::view('view-timetable', 'school.framework.timetable.view-timetable')->name('view.timetable');

    Route::view('event-config', 'school.framework.event.event-config')->name('event.config');
    // notification 
    Route::post('create-school-notification', [SchoolNotificationController::class, 'createSchoolNotification'])->name('create.school.notification');
    // load notification 
    Route::post('load-school-notification', [SchoolNotificationController::class, 'loadMyNotificationHistories'])->name('load.school.notification');

    // notify parent when time table is ready 
    Route::post('notify-parent-timetable', [SchoolNotificationController::class, 'createSchoolNotifyParent'])->name('create.school.notify.parent');
   
    Route::get('count-my-notification-tip', [SchoolNotificationController::class, 'countMyNotificationTip'])->name('count.my.notification.tip');
    Route::get('load-my-notification-tip', [SchoolNotificationController::class, 'loadMyNotificationTip'])->name('load.my.notification.tip');
    Route::get('load-my-notification-details', [SchoolNotificationController::class, 'loadMyNotificationDetails'])->name('load.my.notification.details');
    Route::get('my-notification', [SchoolNotificationController::class, 'myNotification'])->name('my.notification');

    // fee setup 
    Route::view('fees-config', 'school.framework.fees.fees-config')->name('fee.config');
    Route::get('load-fee-items', [FeeItemController::class,'loadFeeItems'])->name('load.fee.items');
    Route::post('load-fee-amount', [FeeItemController::class, 'loadFeeAmount'])->name('load.fee.amount');
    Route::post('load-student-invoice', [FeeItemController::class, 'loadStudentInvoice'])->name('load.student.invoice');
    // load a particular student invoice for payment 
    Route::post('load-student-piad-invoice', [FeeItemController::class, 'loadStudentPaidInvoice'])->name('load.student.paid.invoice');
    Route::get('load-fee-config', [FeeItemController::class, 'loadFeeConfig'])->name('load.fee.config');
    Route::post('generate-all-invoice', [FeeItemController::class, 'generateAllInvoice'])->name('generate.all.invoice');
    Route::post('re-generate-all-invoice', [FeeItemController::class, 'reGenerateAllInvoice'])->name('re.generate.all.invoice');
    // class teacher view student invoices 
    Route::view('student-invoice', 'school.fees.student-invoice')->name('student.invoice');

    // payment collection and management by clert 
    Route::view('payment-records', 'school.payments.payment-records')->name('payment.records');
    Route::get('load-paid-invoice', [FeeItemController::class, 'loadInvoicePayment'])->name('load.paid.invoice');
    Route::post('load-student-invoice-by-pid', [FeeItemController::class, 'loadStudentInvoiceByPid'])->name('load.student.invoice.by.pid');
    Route::post('process-student-invoice', [FeeItemController::class, 'processStudentInvoice'])->name('process.student.invoice');
    Route::get('payment-receipt/{invoice?}', [FeeItemController::class, 'loadPaymentInvoice'])->name('payment.invoice.receipt');

    // admission config
    Route::view('admission-config', 'school.framework.admission.admission-config')->name('admission.config');
    Route::post('admission-config', [AdmissionConfigController::class, 'setAdmissionClass'])->name('configure.admission');
    Route::get('load-admission-details', [AdmissionConfigController::class,'index'])->name('load.admission.details');
    Route::get('load-admission-setup', [AdmissionConfigController::class,'setup'])->name('load.admission.setup');

    Route::post('create-fee-name', [FeeItemController::class, 'createFeeName'])->name('create.fee.name');

    Route::post('configure-fee', [FeeItemController::class, 'feeConfigurationAndAmount'])->name('configure.fee');
    
    
    // admission 
    Route::view('admission-form', 'school.admission.admission-form')->name('school.admission');
    Route::post('admission-form', [AdmissionController::class, 'submitAdmission']);
    Route::get('adit-admission-form/{id?}', [AdmissionController::class, 'loadAdmissionByPid'])->name('edit.admission');
    Route::post('load-admission-by-pid', [AdmissionController::class, 'loadAdmissionDetail'])->name('load.admission.by.pid');
    Route::get('admission-fee', [AdmissionController::class, 'admissionFeeForm'])->name('admission.fee');
    // admission list 
    Route::view('admission-list', 'school.admission.admission-list')->name('admission.list');
    Route::get('process-admission',[AdmissionController::class, 'loadAppliedAllAdmission'])->name('admission.process');
    Route::post('process-admission',[AdmissionController::class, 'batchAdmission']);
    Route::get('load-admission', [AdmissionController::class, 'loadAppliedAdmission'])->name('admission.request');
    Route::get('load-denied-admission', [AdmissionController::class, 'loadDeniedAdmission'])->name('denied.admission');
    Route::post('grant-admission', [AdmissionController::class, 'grantAdmission'])->name('grant.admission');
    Route::post('deny-admission', [AdmissionController::class, 'denyAdmission'])->name('deny.admission');
    
    // Psychomotor, effective domain and grade key 
    // hostels  
    //   
    Route::middleware('boardingSchool')->group(function(){
        Route::view('hostels-config', 'school.framework.hostels.hostels-config')->name('school.hostels.config');
        Route::post('create-hostel', [HostelController::class, 'createHostel'])->name('create.hostel');
        Route::get('load-hostels', [HostelController::class, 'loadHostel'])->name('load.hostels');
        // load portals hostels 
        Route::get('load-hostel-portal', [HostelController::class, 'loadHostelPortal'])->name('load.hostel.portals'); 

        Route::post('load-hostel-student', [HostelController::class, 'loadHostelStudent'])->name('load.hostel.students');
        
        // assign hostel to portal staff 
        Route::Post('assign-hostel-to-portal', [HostelController::class, 'assignHostelToPortal'])->name('assign.hostel.to.portal');
        // assign hostel to student 
        Route::Post('assign-hostel-to-student', [HostelController::class, 'assignHostelToStudent'])->name('assign.hostel.to.student');
    });
    
    // load school base pschomotor 
    Route::get('load-psychomotor-base', [PsychomotorBaseController::class, 'index'])->name('load.psychomotor.base');
    
    // load school pschomotor key
    Route::post('load-psychomotor-key', [PsychomotorBaseController::class, 'psychomotorKeys'])->name('load.psychomotor.key');
    // Route::post('creat-psychomotor', [PsychomotorController::class, 'index'])->name('load.psychomotor');
    
    Route::post('create-psychomotor-base', [PsychomotorBaseController::class, 'createPsychomotorBase'])->name('create.psychomotor.base');
    // create psychomotor
    Route::post('create-psychomotor-key', [PsychomotorBaseController::class, 'createPsychomotorkey'])->name('create.psychomotor.key');
    // load effective domain 
    Route::get('load-effective-domian', [AffectiveDomainController::class, 'index'])->name('load.effective-domain');
    // create effective domain 
    Route::post('create-effective-domain', [AffectiveDomainController::class, 'createEffectiveDomain'])->name('create.effective.domain');
    // load psycho grade 
    Route::get('load-psycho-grade', [PsychoGradeKeyController::class, 'index'])->name('load.psycho-grade');
    // create psycho grade 
    Route::post('create-psycho-grade', [PsychoGradeKeyController::class, 'createPsychoGrade'])->name('create.psycho.grade');


    // result config 
    Route::view('school-assessment-config', 'school.framework.result.assessment-config')->name('school.assessment.config');
    Route::view('school-result-config', 'school.framework.result.result-config')->name('school.result.config');

    Route::view('register-staff', 'school.registration.staff.register-staff')->name('create.staff.form');
    Route::view('staff-list', 'school.staff.staff-list')->name('school.staff.list');
    Route::post('create-staff', [StaffController::class, 'createStaff'])->name('create.school.staff');
    Route::get('edit-staff/{id}', [StaffController::class, 'find'])->name('edit.staff');
    // load staff details for editing 
    Route::post('load-staff-detal-by-id', [StaffController::class, 'loadStaffDetailsById'])->name('load.staff.detail.by.id');
    // Route::post('school-staff-role/{id}', [StaffController::class, 'staffRole'])->name('school.staff.role');
    Route::post('school-staff-access/{id}', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
    Route::post('school-staff-class', [StaffController::class, 'assignClassToStaff'])->name('school.staff.class');
    Route::post('school-staff-subject', [StaffController::class, 'staffSubject'])->name('school.staff.subject');
    // update staff images 
    Route::post('update-staff-images', [StaffController::class, 'updateStaffImages'])->name('update.staff.image');
    // update role 
    Route::post('update-staff-role', [StaffController::class, 'updateStaffRole'])->name('update.staff.role');
    // update status 
    Route::get('update-staff-status/{id}', [StaffController::class, 'updateStaffStatus'])->name('update.staff.status');

    // student 
    // Route::view('school-registration', 'school.registration.index')->name('school.registration');
    // student 
    Route::view('register-student', 'school.registration.student.register-student')->name('school.registration.student.form');
    Route::post('register-student', [StudentRegistrationController::class, 'registerStudent'])->name('register.student');
    // edit student 

    Route::post('link-student-parent', [StudentController::class, 'linkStudentToParent'])->name('link.student.parent');
    // find student by reg returrn pid 
    Route::post('find-student-by-reg', [StudentController::class, 'findStudentByReg'])->name('find.student.by.reg');

    Route::view('register-parent', 'school.registration.parent.register-parent')->name('school.parent.registration.form');

    Route::post('school-parent-registration', [ParentRegistrationController::class, 'registerParent'])->name('school.register.parent');

    Route::post('change-parent-status', [ParentController::class, 'toggleParentStatus'])->name('toggle.parent.status');
    Route::post('parent-profile/{id}', [ParentController::class, 'myProfile'])->name('school.parent.profile');

    Route::get('parents-ward/{id}', [ParentController::class, 'myWards'])->name('school.parent.child');

    // parent assistance 
    Route::view('create-school-rider-form', 'school.registration.rider.register-rider')->name('school.rider.form');
    Route::post('create-school-rider', [SchoolRiderController::class, 'submitSchoolRiderForm'])->name('create.school.rider');
    // link Rider to student 
    Route::post('link-student-to-rider', [SchoolRiderController::class, 'linkStudentToRider'])->name('link.student.to.rider');

    // uploads 
    // upload staff 
    Route::view('upload-staff', 'school.uploads.staff.upload-staff')->name('upload.staff');
    Route::post('upload-staff', [UploadStaffController::class,'importStaff']);

    // upload student 
    Route::view('upload-student', 'school.uploads.student.upload-student')->name('upload.student');
    Route::post('upload-student', [UploadStudentController::class,'importStudent']);
    // upload parent 
    Route::view('upload-parent', 'school.uploads.parent.upload-parent')->name('upload.parent');
    Route::post('upload-parent', [UploadParentController::class,'importParent']);
    // upload rider 
    Route::view('upload-rider', 'school.uploads.rider.upload-rider')->name('upload.rider');
    Route::post('upload-rider', [UploadRiderController::class,'importRider']);


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
    Route::view('school-staff-list', 'school.lists.staff.staff-list')->name('school.staff.list');

    // load staff 
    // load active staff 
    Route::get('load-staff-list', [StaffController::class, 'index'])->name('load.staff.list');
    Route::get('in-active-staff-list', [StaffController::class, 'inActiveStaff'])->name('load.inactive.staff.list');
    // all staff class 
    Route::view('all-staff-classes', 'school.lists.staff.staff-classes')->name('school.staff.classes');
    // load all staff classes goes here 
    Route::post('load-all-staff-classes', [StaffController::class, 'loadAllStaffClasses'])->name('load.all.staff.classes');
    // all staff subjects goes here view 
    Route::view('all-staff-subjects', 'school.lists.staff.staff-subjects')->name('all.staff.subjects');
    // load all staff subjects goes here 
    Route::post('load-all-staff-subjects', [StaffController::class, 'loadAllStaffSubjects'])->name('load.all.staff.subjects');

    // profile 
    // staff profile 
    Route::get('staff-profile/{id}', [StaffController::class, 'staffProfile'])->name('school.staff.profile');
    Route::post('load-staff-profile', [StaffController::class, 'loadStaffProfile'])->name('load.staff.profile');
    Route::post('load-staff-classes', [StaffController::class, 'loadStaffClasses'])->name('load.staff.classes');
    Route::post('load-staff-subjects', [StaffController::class, 'loadStaffSubject'])->name('load.staff.subjects');


    // student list 
    Route::view('school-student-list', 'school.lists.student.student-list')->name('school.student.list');
    // load active student 
    Route::get('load-active-student', [StudentController::class, 'index'])->name('load.active.student.list');
    // load diabled student 
    Route::get('load-in-active-student', [StudentController::class, 'inActiveStudent'])->name('load.in.active.student');
    Route::get('load-ex-student', [StudentController::class, 'exStudent'])->name('load.ex.student');
    Route::get('update-student-status/{id}', [StudentController::class, 'updateStudentStatus'])->name('update.student.status');
    // staff student list 
    Route::view('staff-student-list', 'school.lists.staff.staff-student-list')->name('staff.student.list');
    // load active student 
    Route::get('load-staff-active-student', [StudentController::class, 'staffActiveStudent'])->name('load.staff.active.student.list');
    // load diabled student 
    Route::get('load-in-active-student', [StudentController::class, 'inActiveStudent'])->name('load.in.active.student');
    Route::get('load-ex-student',[StudentController::class, 'exStudent'])->name('load.ex.student');
    Route::get('update-student-status/{id}', [StudentController::class, 'updateStudentStatus'])->name('update.student.status');
    // parent list 
    Route::view('parent-list', 'school.lists.parent.parent-list')->name('school.parent.list');
    Route::get('load-parent-list', [ParentController::class, 'index'])->name('load.school.parent.list');
    // student list 
    Route::view('school-rider-list', 'school.lists.rider.rider-list')->name('school.rider.list');
    Route::get('load-rider-list', [SchoolRiderController::class, 'index'])->name('load.school.rider.list');

    // student profile 
    Route::get('student-profile/{id}', [StudentController::class, 'studentProfile'])->name('student.profile');
    // load student info for editing 
    Route::get('edit-student/{id}', [StudentController::class, 'find'])->name('edit.student.info');
    Route::post('load-student-detail-by-id', [StudentController::class, 'loadStudentDetailsById'])->name('load.student.details.by.id');
    Route::post('view-student-profile', [StudentController::class, 'viewStudentProfile'])->name('load.student.profile');
    Route::post('view-student-class-history', [StudentController::class, 'viewStudentClassHistroy'])->name('load.student.class');
    
    Route::post('load-student-riders', [StudentController::class, 'loadStudentRiders'])->name('load.student.riders');
    Route::post('view-student-results', [StudentTermlyResultController::class, 'viewStudentResult'])->name('load.student.result');
    Route::post('load-particular-student-invoices', [FeeItemController::class, 'loadParticularStudentInvoice'])->name('load.particular.student.invoice');
    Route::post('load-particular-student-payment', [FeeItemController::class, 'loadParticularStudentPayment'])->name('load.particular.student.payment');
    // student profile 
    Route::get('parent-profile/{id}', [ParentController::class, 'parentProfile']);
    Route::get('view-parent-profile', [ParentController::class, 'viewParentProfile'])->name('view.parent.profile');
    // student profile 
    Route::get('rider-profile/{id}', [SchoolRiderController::class, 'riderProfile'])->name('school.rider.profile');
    Route::post('view-rider-profile', [SchoolRiderController::class, 'viewRiderProfile'])->name('view.rider.profile');
    Route::post('load-rider-student', [SchoolRiderController::class, 'viewRiderStudent'])->name('load.rider.student');

    // student assignment 
    Route::view('class-assignment', 'school.assignment.assignments')->name('class.assignment.form');
    // Route::post('class-assignment', 'school.assignment.assignment-form')->name('class.assignment.form');

    //student attendance
    Route::view('student-attendance-form', 'school.student.attendance.student-attendance-form')->name('student.attendance.form');
    Route::post('student-attendance-form', [StudentAttendanceController::class, 'loadArmStudent']);
    Route::post('student-attendance-form', [StudentAttendanceController::class, 'loadArmStudent'])->name('attendance.change.class');
    Route::post('submit-student-attendance', [StudentAttendanceController::class, 'submitStudentAttendance'])->name('submit.student.attendance');
    // student attendance 
    Route::post('student-attendance', [StudentAttendanceController::class, 'studentAttendance'])->name('student.attendance');
    Route::view('student-attendance-history', 'school.student.attendance.student-attendance-history')->name('student.attendance.history');
    Route::post('load-student-attendance-history', [StudentAttendanceController::class, 'loadStudentAttendanceHistory'])->name('load.student.attendance.history');
    Route::view('student-attendance-count', 'school.student.attendance.student-attendance-count')->name('student.attendance.count');
    Route::post('load-student-attendance-count', [StudentAttendanceController::class, 'loadStudentAttendanceCount'])->name('load.student.attendance.count');

    // student assessment 
    Route::view('student-subject-score-form', 'school.student.assessment.student-subject-score-form')->name('student.assessment.form');
    Route::post('student-subject-score-form', [StudentScoreController::class, 'enterStudentScoreRecord']);
    Route::post('change-arm-subject', [StudentScoreController::class, 'changeSubject'])->name('change.arm.subject');
    Route::get('student-score-entering', [StudentScoreController::class, 'enterStudentScore'])->name('enter.student.score');
    Route::post('submit-student-ca', [StudentScoreController::class, 'submitCaScore'])->name('submit.student.ca');
    Route::post('change-student-ca-student', [StudentScoreController::class, 'changeSubjectResultStatus'])->name('change.student.ca.student');
    // export student list 
    Route::get('export-student-list', [StudentScoreController::class, 'exportStudentList'])->name('export.student.list');
    Route::post('import-student-score', [StudentScoreController::class, 'importStudentScore'])->name('import.student.score');
    // view student subject score 
    Route::view('view-student-subject-score-form', 'school.student.assessment.view-subject-score-form')->name('view.student.subject.score.form');
    Route::post('view-student-subject-score-form', [StudentScoreController::class, 'viewStudentScoreRecord']);
    Route::get('view-student-score', [StudentScoreController::class, 'loadStudentScore'])->name('view.student.score');

    // psychomotor 
    Route::view('psychomotor-form', 'school.student.psychomotor.psychomotor-form')->name('psychomotor.assessment.form');
    Route::post('psychomotor-form', [RecordPsychomotorController::class, 'loadPsychomotoKeys']);
    Route::post('record-psychomotor-score', [RecordPsychomotorController::class, 'recordPsychomotorScore'])->name('record.psycomotor.score');

    Route::view('view-psychomotor-form', 'school.student.psychomotor.view-psychomotor-form')->name('view.psychomotor.form');
    Route::post('view-psychomotor-form', [RecordPsychomotorController::class, 'loadPsychomotoScore']);
    // affective domain 
    // I dont think this route is still working 
    Route::view('student-ad-form', 'school.student.affective.affective-form')->name('affective.assessment.form');
    Route::post('student-ad-form', [AffectiveDomainController::class, 'loadAffecitveKeys']);
    Route::post('record-affective-score', [AffectiveDomainController::class, 'recordAffectiveDomainScore'])->name('record.affective.score');

    // view student result 
    Route::view('view-student-termly-result', 'school.student.result.termly-result.view-termly-result-form')->name('view.student.termly.result');
    Route::post('view-student-termly-result', [StudentTermlyResultController::class, 'loadStudentResult']);
    // redirect to this route 
    Route::get('student-termly-result', [StudentTermlyResultController::class, 'classResult'])->name('view.student.result');
    // particular student money
    Route::get('student-report-card/{param}/{pid}', [StudentTermlyResultController::class, 'studentReportCard'])->name('student.report.card');
    // view student cumualtive result 
    //view-student-cumualtive-result
    Route::view('view-student-cumulative-result', 'school.student.result.cumulative.cumulative-result-form')->name('view.student.cumualtive.result');
    Route::post('view-student-cumulative-result', [ViewCumulativeResultController::class, 'loadStudentCumulativeResult']);
    Route::get('class-cumulative-result/{param}/{std}', [ViewCumulativeResultController::class, 'studentCumulativeReportCard'])->name('student.cumulative.result');
    // redirect to this route 
    // particular student money
    Route::get('student-cumulative-result/{param}/{pid}', [StudentTermlyResultController::class, 'studentReportCard'])->name('student.cm.report.card');

    // comments 
    // principal comment 
    Route::view('principal-comment-termly-result', 'school.student.result.comments.principal.principal-comment-form')->name('principal.comment.termly.result');
    // the view // princal-comment.blade.php
    Route::post('principal-comment-termly-result', [PrincipalCommentResultController::class, 'loadStudentResult']);
     // pricinpal commenting 
     Route::post('principal-commenting-termly-result', [PrincipalCommentResultController::class, 'principalCommentStudentTermlyResult'])->name('comment.principal.student.termly.result');
    // principal automated comment
    Route::view('principal-automated-comment', 'school.student.result.comments.principal.principal-automated-comment')->name('principal.automated.comments');
    // load principal comment
    Route::get('load-principal-automated-comment', [PrincipalCommentResultController::class, 'loadPrincipalAutomatedComment'])->name('load.principal.automated.comments');
    // the view // princal-comment.blade.php
    Route::post('principal-automated-comment', [PrincipalCommentResultController::class, 'principalAutomatedComment'])->name('principal.add.comment');
    // class teacher comment
    Route::view('teacher-comment-termly-result', 'school.student.result.comments.teacher.teacher-comment-form')->name('teacher.comment.termly.result');
    // load student result
    Route::post('teacher-comment-termly-result', [TeacherCommentResultController::class, 'loadStudentResult']);
    // commenting student result
    Route::post('teacher-commenting-termly-result', [TeacherCommentResultController::class, 'teacherCommentStudentTermlyResult'])->name('comment.teacher.student.termly.result');
    
    // load student result
    Route::view('teacher-automated-comment', 'school.student.result.comments.teacher.teacher-automated-comment')->name('teacher.automated.comments');
    // load student result
    Route::get('load-teacher-automated-comments', [TeacherCommentResultController::class, 'loadTeacherAutomatedComment'])->name('load.teacher.automated.comments');
    // create comment  
    Route::post('teacher-automated-comment', [TeacherCommentResultController::class, 'teacherAutomatedComment']);
    
    // class portal comment
    Route::view('portals-comment-termly-result', 'school.student.result.comments.portals.portals-comment-form')->name('portal.comment.termly.result');

    Route::post('portals-comment-termly-result', [PortalCommentResultController::class, 'loadStudentResult']);
    // class portal comment
    Route::post('portals-commenting-termly-result', [PortalCommentResultController::class, 'portalsCommentStudentTermlyResult'])->name('comment.portals.student.termly.result');

    // class portal comment
    Route::view('portals-automated-comment', 'school.student.result.comments.portals.portals-automated-comment-form')->name('portal.automated.comments');

    Route::post('portals-automated-comment', [PortalCommentResultController::class, 'loadStudentResult']);
    
    // class subject teacher comment
    Route::view('subject-comment-termly-result', 'school.student.result.comments.principal-comment-form')->name('subject.comment.termly.result');
    // student promotion 
    Route::view('promote-student-form', 'school.student.promotion.promote-student-form')->name('promote.student.form');
    Route::post('promote-student-form', [PromoteStudentController::class, 'loadStudent']);
    Route::post('promote-student', [PromoteStudentController::class, 'promoteStudent'])->name('promote.student');
    // swap student 
    Route::view('swap-student-form', 'school.student.promotion.swap-student-form')->name('swap.student.form');
    Route::post('swap-student-form', [PromoteStudentController::class, 'loadStudentByArm']);
    Route::post('swap-student', [PromoteStudentController::class, 'swapStudent'])->name('swap.student');

    // parent activities 
    Route::post('ward-login/{pid}', [ParentController::class, 'wardLogin'])->name('ward.login');


    // payment receipt 

    // school hire process 
    // Route::view()->name('hire.config');

    Route::view('hire-config', 'school.framework.hire.hire-config')->name('hire.config');
    Route::post('load-hire-able', [HireAbleController::class, 'loadPotentialApplicantHireConfig'])->name('hire.hire.able');
    Route::get('load-recruitment', [HireAbleController::class, 'loadRecruitmentConfig'])->name('load.school.recruitment');
    Route::post('load-available-all-school-subject', [Select2Controller::class, 'loadAllSchoolSubject']);
    Route::post('school-recruitment', [HireAbleController::class, 'submitRecruitment'])->name('school.recruitment');

    // hireworthy 
    // Route::view('hire-worthy', 'add-on.hire-worthy')->name('hire.worthy')->middleware('auth');
    // available for hire
    Route::view('hire-me', 'add-on.hire-worthy')->name('hire.me')->middleware('auth');
    Route::post('hire-me-config',[HireAbleController::class, 'hireMeConfig'])->name('hire.me.config');

    Route::get('load-me-config', [HireAbleController::class, 'loadHireMeConfig'])->name('load.hire.config');

});


// admission 
Route::get('admission/{id?}',[AdmissionController::class,'index'])->name('admission');
// admission 
Route::post('admission',[AdmissionController::class,'createAdmission']);

// public hiring 
Route::get('hiring',[HireAbleController::class,'index'])->name('hiring');
Route::get('apply-job',[HireAbleController::class,'index'])->name('apply.school.job');

