<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auths\AuthController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\School\SchoolController;
use App\Http\Controllers\Advert\JobAdvertController;
use App\Http\Controllers\Framework\Select2Controller;
use App\Http\Controllers\School\Rider\RiderController;
use App\Http\Controllers\School\Staff\StaffController;
use App\Http\Controllers\School\Parent\ParentController;
use App\Http\Controllers\School\Framework\ClassController;
use App\Http\Controllers\School\Student\StudentController;
use App\Http\Controllers\School\Class\AssessmentController;
use App\Http\Controllers\Organisation\OrganisationController;
use App\Http\Controllers\School\Upload\UploadRiderController;
use App\Http\Controllers\School\Upload\UploadStaffController;
use App\Http\Controllers\Organisation\OrgUserAccessController;
use App\Http\Controllers\School\Admission\AdmissionController;
use App\Http\Controllers\School\Framework\Term\TermController;
use App\Http\Controllers\School\Upload\UploadParentController;
use App\Http\Controllers\School\Student\StudentClassController;
use App\Http\Controllers\School\Student\StudentScoreController;
use App\Http\Controllers\School\Upload\UploadStudentController;
use App\Http\Controllers\Organisation\OrganisationUserController;
use App\Http\Controllers\School\Framework\Fees\FeeItemController;
use App\Http\Controllers\School\Framework\Fees\PaymentController;
use App\Http\Controllers\School\Framework\Hostel\HostelController;
use App\Http\Controllers\School\Framework\Grade\GradeKeyController;
use App\Http\Controllers\School\Framework\Result\AwardKeyController;
use App\Http\Controllers\School\Framework\Session\SessionController;
use App\Http\Controllers\School\Framework\Subject\SubjectController;
use App\Http\Controllers\School\Framework\Subject\SubjectTypeController;
use App\Http\Controllers\School\Framework\Timetable\TimetableController;
use App\Http\Controllers\School\Framework\Psycho\PsychoGradeKeyController;
use App\Http\Controllers\School\Framework\Psycho\AffectiveDomainController;
use App\Http\Controllers\School\Student\Promotion\PromoteStudentController;
use App\Http\Controllers\School\Framework\Assessment\ScoreSettingsController;
use App\Http\Controllers\School\Framework\Admission\AdmissionConfigController;
use App\Http\Controllers\School\Framework\Attendance\AttendanceTypeController;
use App\Http\Controllers\School\Framework\Events\SchoolNotificationController;
use App\Http\Controllers\School\Framework\Assessment\AssessmentTitleController;
use App\Http\Controllers\School\Student\Attendance\StudentAttendanceController;
use App\Http\Controllers\School\Framework\Psychomotor\PsychomotorBaseController;
use App\Http\Controllers\School\Framework\Result\ResultConfigController;
use App\Http\Controllers\School\Payment\ResultRecordController;
use App\Http\Controllers\School\Staff\StaffAttendanceController;
use App\Http\Controllers\School\Student\Assessment\LessonNoteController;
use App\Http\Controllers\School\Student\Assessment\LessonPlanController;
use App\Http\Controllers\School\Student\Results\Termly\StudentTermlyResultController;
use App\Http\Controllers\School\Student\Results\Comments\TeacherCommentResultController;
use App\Http\Controllers\School\Student\Results\Comments\PrincipalCommentResultController;
use App\Http\Controllers\School\Student\Results\Cumulative\ViewCumulativeResultController;
use App\Http\Controllers\School\Student\Assessment\Psychomotor\RecordPsychomotorController;
// school achievment display
// port 8400
Route::view('/','welcome')->middleware('guest');
Route::view('privacy-policy','privacy')->middleware('guest');
// Route::view('/401','welcome')->name('401')->middleware('guest');
// authentication 
// sign up 
Route::get('/mail',function(){
    
    return view('mails.greeting-mail');
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
Route::view('help', 'helps.help')->name('helps');



Route::middleware('auth')->group(function(){
    Route::post('update-password', [AuthController::class, 'updatePassword'])->name('update.password');//->middleware('auth');

    Route::get('load-user-detail', [UserController::class, 'loadUserDetail'])->name('load.user.detail');
    Route::post('update-user-detail', [UserController::class, 'updateUserDetail'])->name('update.user.detail');

    Route::post('create-school', [SchoolController::class, 'createSchool']);
    Route::get('school-sign-in/{id}', [SchoolController::class, 'schoolLogin'])->name('login.school');
    Route::get('school-setup', [SchoolController::class, 'schoolSetup'])->name('setup.school');
    Route::post('update-setup-stage', [SchoolController::class, 'updateSetupStage'])->name('update.setup.stage');
    Route::post('previous-setup-stage', [SchoolController::class, 'previousSetupStage'])->name('previous.setup.stage');

    // Logout
    Route::get('logout', [AuthController::class, 'logout'])->name('logout'); // app logout 
    // user dashboard 
    Route::get('users-dashboard', [UserController::class, 'index'])->name('users.dashboard');
    Route::get('users-home', [UserController::class, 'dashboard'])->name('users.home');
    Route::view('create-school', 'school.create-school')->name('create.school');
    
});

Route::middleware('schoolAuth')->group(function(){
    Route::get('logout-school', [AuthController::class, 'logoutSchool'])->name('logout.school'); // school log out
    Route::post('reset-user-password', [AuthController::class, 'resetUserPassword'])->name('reset.user.password');
    Route::view('self-attendance', 'school.lists.staff.self-attendance')->name('self.attendance');
    Route::get('load-my-attendance', [StaffAttendanceController::class, 'loadMyAttendance'])->name('load.my.attendance');
    Route::get('load-staff-attendance', [StaffAttendanceController::class, 'staffAttendance'])->name('load.staff.attendance');
    Route::post('capture-attendance', [StaffAttendanceController::class, 'captureAttendance'])->name('capture.attendance');
    Route::get('school-dashboard', [SchoolController::class, 'mySchoolDashboard'])->name('my.school.dashboard');
    Route::get('admin-dashboard', [SchoolController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('head-teacher-dashboard', [SchoolController::class, 'principalDashboard'])->name('head.teacher.dashboard');
    Route::get('class-teacher-dashboard', [SchoolController::class, 'classTeacherDashboard'])->name('class.teacher.dashboard');
    Route::get('teacher-dashboard', [SchoolController::class, 'teacherDashboard'])->name('teacher.dashboard');



    // user create school 
    Route::get('update-school', [SchoolController::class, 'index'])->name('edit.school.info');
    Route::post('load-school-info', [SchoolController::class, 'loadSchoolDetailById'])->name('load.school.info');
    Route::get('delete-school/{id}', [SchoolController::class, 'update'])->name('delete.school');
    // load school user
    // Route::get('school-users', [SchoolUserController::class, 'index'])->name('school.users');
    // add user to school 
    // Route::post('school-users', [SchoolUserController::class, 'create']);
    // school user access right 
    // Route::post('school-user-access', [SchoolUserAccessController::class, 'store'])->name('school.user.access');
    // sign up with school link direct 
    // Route::post('school-sign-up/{id}',[OrgUserAccessController::class,'store'])->name('school.sign.up');
    // category and class has the same controller 
    Route::view('class-and-category', 'school.framework.class.class-and-category')->name('class.category');
    // tab 1 
    Route::get('load-school-category', [ClassController::class, 'loadCategory'])->name('load.school.category');
    // tab 2 
    Route::get('load-school-class', [ClassController::class, 'loadClasses'])->name('load.school.classes');
    // tab 3 
    Route::get('load-school-class-arm', [ClassController::class, 'loadClassArm'])->name('load.class.arm');
    // tab 4 
    Route::post('load-school-class-arm-subject', [ClassController::class, 'loadClassArmSubject'])->name('load.school.class.arm.subject');
    // create category 
    Route::post('create-category', [ClassController::class, 'createCategory'])->name('create.school.category');
    Route::post('delete-category', [ClassController::class, 'deleteCategory'])->name('delete.category');
    Route::post('load-school-category-by-pid', [ClassController::class, 'loadCategoryByPid'])->name('load.school.category.by.pid');
    // create class 
    Route::post('create-class', [ClassController::class, 'createClass'])->name('create.school.class');
    Route::post('update-class', [ClassController::class, 'updateClass'])->name('update.class');
    Route::post('delete-class', [ClassController::class, 'deleteClass'])->name('delete.class');
    // create class arm 
    Route::post('create-class-arm', [ClassController::class, 'createClassArm'])->name('create.class.arm');
    Route::post('update-class-arm', [ClassController::class, 'updateClassArm'])->name('update.class.arm');
    Route::post('delete-class-arm', [ClassController::class, 'deleteClassArm'])->name('delete.class.arm');
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
    Route::view('sessions', 'school.framework.session.sessions')->name('school.session');
    // create new session 
    Route::post('school-session', [SessionController::class, 'createSession'])->name('create.session');
    // load session on tab with datatable server  
    Route::get('load-school-session', [SessionController::class, 'index'])->name('load.school.session');

    // active school session 
    // load active session on tab 
    Route::get('load-school-active-session', [SessionController::class, 'loadSchoolActiveSession'])->name('load.school.active.session');
    // update active session 
    Route::post('school-session-active', [SessionController::class, 'setActiveSession'])->name('school.session.active');

    // terms 
    Route::view('terms', 'school.framework.terms.terms')->name('school.term');
    Route::get('list-terms', [TermController::class, 'index'])->name('school.list.term');
    Route::post('create-term', [TermController::class, 'createTerm'])->name('create.term');
    Route::post('school-active-term', [TermController::class, 'setActiveTerm'])->name('school.term.active');
    Route::get('load-active-term', [TermController::class, 'loaSchoolActiveTerm'])->name('load.school.active.term');
    Route::get('load-active-term-detail', [TermController::class, 'loaSchoolActiveTermDetails'])->name('load.school.active.term.details');


    // Assesment Title
    Route::view('assessment-title', 'school.framework.assessment.assessment-title')->name('school.assessment.title');
    Route::get('load-assessment-title', [AssessmentTitleController::class, 'index'])->name('load.school.assessment.title');
    // submiting form and create assessment title 
    Route::post('assessment-title', [AssessmentTitleController::class, 'createAssessmentTitle']);
    Route::post('update-assessment-title', [AssessmentTitleController::class, 'updateAssessmentTitle'])->name('update.assessment.title');
    Route::post('delete-assessment-title', [AssessmentTitleController::class, 'deleteAssessmentTitle'])->name('delete.assessment.title');
    //load score settings 
    Route::get('load-score-setting', [ScoreSettingsController::class, 'index'])->name('load.score.setting');

    Route::post('school-score-settings', [ScoreSettingsController::class, 'createScoreSettings'])->name('create.school.score.settings');


    // fee items 
    Route::post('load-available-fee-items', [Select2Controller::class, 'loadAvailableFeeItem']);

    Route::post('load-available-on-demand-fee', [Select2Controller::class, 'loadAvailableOnDemandFee']);

    // subjects & subject type
    // load subject type page 
    Route::view('subject-types', 'school.framework.subject.subject-types')->name('subject.types');
    Route::view('subjects', 'school.framework.subject.subjects')->name('subjects');
    // load subject type 
    Route::get('load-subject-type', [SubjectTypeController::class, 'index'])->name('load.school.subject.type');
    // create subject type 
    Route::post('subjects', [SubjectTypeController::class, 'createSubjectType'])->name('create.subject.type');
    Route::post('create-group-subjects', [SubjectTypeController::class, 'createGroupSubject'])->name('create.group.subject');
    // load subjects 
    Route::post('load-school-subject', [SubjectController::class, 'index'])->name('load.school.subject');
    // create school category subject 
    Route::post('create-subject-subject', [SubjectController::class, 'createSchoolSubject'])->name('create.subject');
    Route::post('update-subject-subject', [SubjectController::class, 'updateSubject'])->name('update.subject');
    Route::post('dup-subject-subject', [SubjectController::class, 'dupSubjectTypeAsSubject'])->name('dup.subject.type.subject');
    Route::post('load-subject-by-id', [SubjectController::class, 'loadSubjectById'])->name('load.subject.by.id');


    // grade key 
    Route::view('grade-key', 'school.framework.grade.grade-key')->name('school.grade.key');
    Route::get('load-grade-key', [GradeKeyController::class, 'index'])->name('load.school.grade.key');
    Route::get('load-grade-key-by-class', [GradeKeyController::class, 'loadGradeKeyByClass'])->name('load.class.grade.key');
    Route::post('grade-key', [GradeKeyController::class, 'createGradeKey']);
    Route::view('school-attendance', 'school.framework.attendance.attendance-setting')->name('school.attendance.setting');
    Route::get('load-attendance', [AttendanceTypeController::class, 'index'])->name('load.school.attendance.setting');
    Route::post('school-attendance', [AttendanceTypeController::class, 'createAttendanceType']);
    Route::post('school-class-attendance', [AttendanceTypeController::class, 'createClassAttendance'])->name('school.class.attendance');
    // Route::post('school-take-class-attendance',[AttendanceTypeController::class, 'createCLassAttendance'])->name('school.take.class.attendance');


    // Psychomotor, effective domain and grade key 
    // Psychomotor 
    Route::view('extra-curricular', 'school.framework.extra-curricular.extra-curricular-config')->name('school.psychomotor.config');

    Route::view('timetable-config', 'school.framework.timetable.timetable-config')->name('timetable.config');

    Route::view('view-timetable', 'school.framework.timetable.view-timetable')->name('view.timetable');

    Route::view('notifications', 'school.framework.event.notifications')->name('event.notifications');
    Route::view('event-config', 'school.framework.event.event-config')->name('event.config');
    // notification 
    Route::post('create-school-notification', [SchoolNotificationController::class, 'createSchoolNotification'])->name('create.school.notification');
    // load notification 
    Route::post('load-school-notification', [SchoolNotificationController::class, 'loadMyNotificationHistories'])->name('load.school.notification');

    Route::get('load-school-events', [SchoolNotificationController::class, 'loadEvents'])->name('load.events');

    // notify parent when time table is ready 
    Route::post('notify-parent-timetable', [SchoolNotificationController::class, 'notifyParentTimetable'])->name('notify.parent.timetable');
   
    Route::get('count-my-notification-tip', [SchoolNotificationController::class, 'countMyNotificationTip'])->name('count.my.notification.tip');
    Route::get('load-my-notification-tip', [SchoolNotificationController::class, 'loadMyNotificationTip'])->name('load.my.notification.tip');
    Route::get('my-notifications', [SchoolNotificationController::class, 'myNotificationDetails'])->name('my.notification');
    Route::view('all-notifications', 'school.all-notifications')->name('all.notification');
    Route::get('load-all-my-notification', [SchoolNotificationController::class, 'allNotifications'])->name('load.all.my.notification');

    // fee setup 
    Route::view('manage-invoice', 'school.framework.fees.manage-invoice')->name('manage.invoice');
    Route::view('fees-config', 'school.framework.fees.fees-config')->name('fee.config');
    Route::get('load-fee-items', [FeeItemController::class,'loadFeeItems'])->name('load.fee.items');
    Route::post('load-fee-account', [FeeItemController::class, 'loadFeeAccount'])->name('load.fee.account');
    Route::post('load-fee-amount', [FeeItemController::class, 'loadFeeAmount'])->name('load.fee.amount');
    Route::post('load-student-invoice', [FeeItemController::class, 'loadStudentInvoice'])->name('load.student.invoice');
    // load a particular student invoice for payment 
    Route::post('load-student-piad-invoice', [FeeItemController::class, 'loadStudentPaidInvoice'])->name('load.student.paid.invoice');
    Route::get('load-fee-config', [FeeItemController::class, 'loadFeeConfig'])->name('load.fee.config');
    Route::post('generate-all-invoice', [FeeItemController::class, 'generateAllInvoice'])->name('generate.all.invoice');
    Route::post('re-generate-all-invoice', [FeeItemController::class, 'reGenerateAllInvoice'])->name('re.generate.all.invoice');
    // class teacher view student invoices 
    Route::view('accept-payment', 'school.fees.accept-payment')->name('accept.payment');
    Route::view('student-invoice', 'school.fees.student-invoice')->name('student.invoice');

    // payment collection and management by clert 
    Route::view('payment-records', 'school.payments.payment-records')->name('payment.records');
    Route::post('load-student-invoice-by-pid', [FeeItemController::class, 'loadStudentInvoiceByPid'])->name('load.student.invoice.by.pid');
    Route::get('load-paid-invoice', [PaymentController::class, 'loadInvoicePayment'])->name('load.paid.invoice');
    Route::post('process-student-invoice', [PaymentController::class, 'processStudentInvoice'])->name('process.student.invoice');
    Route::get('payment-receipt', [PaymentController::class, 'loadPaymentInvoice'])->name('payment.invoice.receipt');

    // admission config
    Route::view('admission-config', 'school.framework.admission.admission-config')->name('admission.config');
    Route::post('admission-config', [AdmissionConfigController::class, 'setAdmissionClass'])->name('configure.admission');
    Route::get('load-admission-details', [AdmissionConfigController::class,'index'])->name('load.admission.details');
    Route::get('load-admission-setup', [AdmissionConfigController::class,'setup'])->name('load.admission.setup');
    
    Route::post('create-fee-account', [FeeItemController::class, 'createFeeAccount'])->name('create.fee.account');
    Route::post('create-fee-name', [FeeItemController::class, 'createFeeName'])->name('create.fee.name');
    
    Route::post('configure-fee', [FeeItemController::class, 'feeConfigurationAndAmount'])->name('configure.fee');
    Route::post('update-fee-amount', [FeeItemController::class, 'updateFeeAmount'])->name('update.fee.amount');
    // award 
    Route::view('student-award-config', 'school.framework.award.award-config')->name('student.award.config');
    Route::get('load-student-award', [AwardKeyController::class, 'index'])->name('load.student.award');
    Route::post('create-student-award', [AwardKeyController::class, 'createStudentAward'])->name('create.student.award');
    
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


    // parent dashboaRD
    Route::get('parent-dashboard', [SchoolController::class, 'parentLogin'])->name('parent.dashboard');


    Route::get('student-dashboard', [SchoolController::class, 'studentLogin'])->name('student.dashboard');
    // student 
    Route::view('student-payment', 'school.lists.student.student-payment')->name('student.payment');
    Route::view('student-result', 'school.lists.student.student-result')->name('student.result');
    Route::view('student-assessment', 'school.lists.student.student-assessment')->name('student.assessment');
    Route::view('student-attendance', 'school.lists.student.student-attendance')->name('student.attendance');

    // rider dashboard 
    Route::get('rider-dashboard', [SchoolController::class, 'riderLogin'])->name('rider.dashboard');

    // Psychomotor, effective domain and grade key 
    // hostels  
    //   
    Route::middleware('schoolAdmin')->group(function(){
        Route::view('result-records', 'school.result-record.result-records')->name('result.records');
        Route::get('load-result-records', [ResultRecordController::class,'resultRecords'])->name('load.result.records');
        Route::get('result-details', [ResultRecordController::class,'resultDetails'])->name('result.detail');
        Route::view('staff-attendance', 'school.lists.staff.staff-attendance')->name('staff.attendance');
        Route::post('config-staff-attendance', [StaffAttendanceController::class, 'configStaffAttendance'])->name('config.staff.attendance');
        Route::get('load-config-staff-attendance', [StaffAttendanceController::class, 'loadStaffAttendanceConfig'])->name('load.config.staff.attendance');
    });
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
    Route::post('load-psychomotor-base', [PsychomotorBaseController::class, 'index'])->name('load.psychomotor.base');
    
    // load school pschomotor key
    Route::post('load-psychomotor-key', [PsychomotorBaseController::class, 'psychomotorKeys'])->name('load.psychomotor.key');
    // Route::post('creat-psychomotor', [PsychomotorController::class, 'index'])->name('load.psychomotor');
    
    Route::post('create-psychomotor-base', [PsychomotorBaseController::class, 'createPsychomotorBase'])->name('create.psychomotor.base');
    Route::post('update-psychomotor-base', [PsychomotorBaseController::class, 'updatePsychomotorBase'])->name('update.psychomotor.base');
    Route::post('delete-psychomotor-base', [PsychomotorBaseController::class, 'deletePsychomotorBase'])->name('delete.psychomotor.base');
    Route::post('clone-psychomotor-base', [PsychomotorBaseController::class, 'clonePsychomotorBase'])->name('clone.psychomotor.base');
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
    Route::view('assessment-config', 'school.framework.result.assessment-config')->name('school.assessment.config');
    Route::get('result-config', [ResultConfigController::class,'index'])->name('school.result.config');
    Route::post('save-template', [ResultConfigController::class,'saveTemplate'])->name('save.template');
    Route::post('save-config', [ResultConfigController::class,'saveConfig'])->name('save.config');

    Route::view('register-staff', 'school.registration.staff.register-staff')->name('register.staff');
    Route::view('staff-list', 'school.staff.staff-list')->name('school.staff.list');
    Route::post('create-staff', [StaffController::class, 'createStaff'])->name('create.staff');
    Route::get('edit-staff/{id}', [StaffController::class, 'find'])->name('edit.staff');
    // load staff details for editing 
    Route::post('load-staff-detal-by-id', [StaffController::class, 'loadStaffDetailsById'])->name('load.staff.detail.by.id');
    // Route::post('school-staff-role/{id}', [StaffController::class, 'staffRole'])->name('school.staff.role');
    // Route::post('school-staff-access/{id}', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
    Route::post('assign-class-to-staff', [StaffController::class, 'assignClassToStaff'])->name('assign.staff.class');
    Route::post('re-assign-class-to-staff', [StaffController::class, 'reAssignClassToStaff'])->name('reassign.staff.class');
    Route::post('assign-staff-subject', [StaffController::class, 'staffSubject'])->name('school.staff.subject');
    Route::post('re-assign-staff-subject', [StaffController::class, 'reAssignStaffSubject'])->name('reassign.staff.subject');
    // update staff images 
    Route::post('update-staff-images', [StaffController::class, 'updateStaffImages'])->name('update.staff.image');
    // update role 
    Route::post('update-staff-role', [StaffController::class, 'updateStaffRole'])->name('update.staff.role');
    // update staff access
    Route::post('staff-access', [StaffController::class, 'staffAccessRight'])->name('school.staff.access');
    // switch role
    Route::get('switch-role/{role}', [SchoolController::class, 'switchRole'])->name('switch.role');
    // update status 
    Route::get('update-staff-status/{id}', [StaffController::class, 'updateStaffStatus'])->name('update.staff.status');

    // student 
    // Route::view('school-registration', 'school.registration.index')->name('school.registration');
    // student 
    Route::view('register-student', 'school.registration.student.register-student')->name('register.student');
    Route::post('register-student', [StudentController::class, 'registerStudent'])->name('register.student');
    // edit student 

    Route::post('link-student-parent', [StudentController::class, 'linkStudentToParent'])->name('link.student.parent');
    // find student by reg returrn pid 
    Route::post('find-student-by-reg', [StudentController::class, 'findStudentByReg'])->name('find.student.by.reg');

    Route::view('register-parent', 'school.registration.parent.register-parent')->name('register.parent');

    Route::post('register-parent', [ParentController::class, 'registerParent']);//->name('school.register.parent');

    Route::post('change-parent-status', [ParentController::class, 'toggleParentStatus'])->name('toggle.parent.status');
    Route::post('parent-profile/{id}', [ParentController::class, 'myProfile'])->name('parent.profile');

    Route::get('parents-ward/{id}', [ParentController::class, 'myWards'])->name('parent.child');

    // parent assistance 
    Route::view('create-rider-form', 'school.registration.rider.register-rider')->name('school.rider.form');
    Route::post('create-rider', [RiderController::class, 'submitRiderForm'])->name('create.school.rider');
    // link Rider to student 
    Route::post('link-student-to-rider', [RiderController::class, 'linkStudentToRider'])->name('link.student.to.rider');

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
    Route::get('find-existing-parent', [SchoolController::class, 'findExistingParent'])->name('find.existing.parent');
    // link link to school 
    Route::get('link-existing-parent', [SchoolController::class, 'linkExistingParentToSchool'])->name('link.existing.parent');
    // find student for linking 
    Route::get('find-existing-rider/{key}', [SchoolController::class, 'findExistingRider']);
    // link link to school 
    Route::get('link-existing-rider', [SchoolController::class, 'linkExistingRiderToSchool'])->name('link.existing.rider');

    // list 
    // list school staff 
    Route::view('staff-list', 'school.lists.staff.staff-list')->name('school.staff.list');

    // load staff 
    // load active staff 
    Route::get('load-staff-list', [StaffController::class, 'index'])->name('load.staff.list');
    Route::get('in-active-staff-list', [StaffController::class, 'inActiveStaff'])->name('load.inactive.staff.list');
    // all staff class 
    Route::view('staff-classes', 'school.lists.staff.staff-classes')->name('school.staff.classes');
    // load all staff classes goes here 
    Route::post('load-all-staff-classes', [StaffController::class, 'loadAllStaffClasses'])->name('load.all.staff.classes');
    // all staff subjects goes here view 
    Route::view('staff-subjects', 'school.lists.staff.staff-subjects')->name('all.staff.subjects');
    // load all staff subjects goes here 
    Route::post('load-all-staff-subjects', [StaffController::class, 'loadAllStaffSubjects'])->name('load.all.staff.subjects');

    // profile 
    // staff profile 
    Route::get('staff-profile/{id}', [StaffController::class, 'staffProfile'])->name('staff.profile');
    Route::post('load-staff-profile', [StaffController::class, 'loadStaffProfile'])->name('load.staff.profile');
    Route::post('load-staff-classes', [StaffController::class, 'loadStaffClasses'])->name('load.staff.classes');
    Route::post('load-staff-subjects', [StaffController::class, 'loadStaffSubject'])->name('load.staff.subjects');


    // student list 
    Route::view('student-list', 'school.lists.student.student-list')->name('school.student.list');
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
    Route::view('rider-list', 'school.lists.rider.rider-list')->name('school.rider.list');
    Route::get('load-rider-list', [RiderController::class, 'index'])->name('load.rider.list');

    // student profile 
    Route::get('student-login/{id}', [StudentController::class, 'studentLogin'])->name('student.login');
    Route::view('student-profile', 'school.lists.student.student-profile')->name('student.profile');
    
    // load student info for editing 
    Route::get('edit-student/{id}', [StudentController::class, 'find'])->name('edit.student.info');
    Route::post('load-student-detail-by-id', [StudentController::class, 'loadStudentDetailsById'])->name('load.student.details.by.id');
    Route::post('view-student-profile', [StudentController::class, 'viewStudentProfile'])->name('load.student.profile');
    Route::post('view-student-class-history', [StudentController::class, 'viewStudentClassHistroy'])->name('load.student.class');
    
    Route::post('load-student-riders', [StudentController::class, 'loadStudentRiders'])->name('load.student.riders');
    Route::post('load-student-results', [StudentTermlyResultController::class, 'viewStudentResult'])->name('load.student.result');

    Route::post('load-particular-student-invoices', [FeeItemController::class, 'loadParticularStudentInvoice'])->name('load.particular.student.invoice');
    Route::post('load-particular-student-payment', [FeeItemController::class, 'loadParticularStudentPayment'])->name('load.particular.student.payment');
    // student profile 
    Route::get('parent-profile/{id}', [ParentController::class, 'parentProfile']);
    Route::get('view-parent-profile', [ParentController::class, 'viewParentProfile'])->name('view.parent.profile');
    // student profile 
    Route::get('rider-profile/{id}', [RiderController::class, 'riderProfile'])->name('rider.profile');
    Route::post('view-rider-profile', [RiderController::class, 'viewRiderProfile'])->name('view.rider.profile');
    Route::post('load-rider-student', [RiderController::class, 'viewRiderStudent'])->name('load.rider.student');

    // student assignment 
    Route::view('class-assessment', 'school.assessments.class-assessment')->name('class.assignment.form');
    Route::view('manual-assessment', 'school.assessments.manual-assessment')->name('manual.assignment');
    Route::view('automated-assessment', 'school.assessments.automated-assessment')->name('automated.assignment');
    
    // lesson note/plan
    Route::view('lesson-plans', 'school.assessments.lesson-plans')->name('lesson.plans');
    Route::post('add-lesson-plan', [LessonPlanController::class, 'addLessonPlan'])->name('add.lesson.plan');
    Route::post('load-lesson-plan', [LessonPlanController::class, 'loadLessonPlan'])->name('load.lesson.plan');
    Route::view('lesson-notes', 'school.assessments.lesson-notes')->name('lesson.notes');
    Route::post('add-lesson-note', [LessonNoteController::class, 'addLessonNote'])->name('add.lesson.note');
    Route::post('load-lesson-notes', [LessonNoteController::class, 'loadLessonNotes'])->name('load.lesson.notes');

    Route::post('class-assessment', [AssessmentController::class, 'createManualAssessment'])->name('submit.manual.assignment');
    Route::post('submit-automated-assessment', [AssessmentController::class, 'createAutomatedAssessment'])->name('submit.automated.assignment');
    Route::post('delete-assessment', [AssessmentController::class, 'deleteAssessment'])->name('delete.assessment');
    Route::get('load-assessment', [AssessmentController::class, 'loadAssessment'])->name('load.assignment');
    Route::get('load-assessment-student/{id}', [AssessmentController::class, 'loadAssessmentForStudent'])->name('load.assignment.for.student');
    Route::get('load-student-submitted-assessment/{id}', [AssessmentController::class, 'loadStudentSubmittedAssessment'])->name('load.student.submitted.assignment');
    Route::post('submit-assessment', [AssessmentController::class, 'submitAssessment'])->name('submit.assessment');
    Route::get('load-class-submitted-assessments', [AssessmentController::class, 'loadClassSubmittedAssessments'])->name('load.class.submitted.assessments');
    // student attempt assigment 
    Route::get('attempt-assessment', [AssessmentController::class, 'loadQuestions'])->name('load.questions');
    
    Route::get('mark-assessment', [AssessmentController::class, 'loadSubmittedAssessmentsByStudent'])->name('mark.assessment');
    Route::post('mark-student-assessment', [AssessmentController::class, 'markStudentAssessment'])->name('mark.student.assessment');
    Route::get('view-assessment', [AssessmentController::class, 'viewSubmittedAssessment'])->name('view.assessment');


    //student attendance
    Route::view('take-attendance', 'school.student.attendance.take-attendance')->name('student.attendance.form');
    // Route::post('student-attendance-form', [StudentAttendanceController::class, 'loadArmStudent']);
    Route::post('take-attendance', [StudentAttendanceController::class, 'loadArmStudent'])->name('take.attendance');
    Route::post('submit-student-attendance', [StudentAttendanceController::class, 'submitStudentAttendance'])->name('submit.student.attendance');
    // student attendance 
    Route::view('student-attendance-history', 'school.student.attendance.student-attendance-history')->name('student.attendance.history');
    Route::post('student-attendance', [StudentAttendanceController::class, 'studentAttendance'])->name('student.attendance');
    Route::post('student-attendance-history', [StudentAttendanceController::class, 'studentAttendanceHistory']);//->name('student.attendance.history');
    Route::post('load-student-attendance-history', [StudentAttendanceController::class, 'loadStudentAttendanceHistory'])->name('load.student.attendance.history');
    Route::view('student-attendance-count', 'school.student.attendance.student-attendance-count')->name('student.attendance.count');
    Route::post('load-student-attendance-count', [StudentAttendanceController::class, 'loadStudentAttendanceCount'])->name('load.student.attendance.count');

    // student assessment 
    Route::view('enter-student-score', 'school.student.assessment.enter-student-score')->name('enter.student.score');
    Route::post('enter-student-score', [StudentScoreController::class, 'enterStudentScoreRecord']);
    Route::post('change-arm-subject', [StudentScoreController::class, 'changeSubject'])->name('change.arm.subject');
    // Route::get('enter-student-score', [StudentScoreController::class, 'enterStudentScore'])->name('enter.student.score');
    Route::post('submit-student-ca', [StudentScoreController::class, 'submitCaScore'])->name('submit.student.ca');
    Route::post('change-student-ca-student', [StudentScoreController::class, 'changeSubjectResultStatus'])->name('change.student.ca.student');

    Route::post('publish-subject-result', [StudentScoreController::class, 'publishSubjectResult'])->name('publish.subject.result');
    Route::view('review-class-result', 'school.student.assessment.review-class-result')->name('review.class.result');
    Route::post('review-class-result', [StudentScoreController::class, 'reviewClassResult']);
    Route::post('lock-class-result', [StudentScoreController::class, 'lockClassResult'])->name('lock.class.result');
    Route::get('review-subject-result', [StudentScoreController::class, 'reviewSubjectResult'])->name('review.subject.result');

    Route::view('publish-result','school.student.assessment.publish-class-result')->name('publish.result');
    Route::get('load-school-result', [ResultRecordController::class, 'loadSchoolResult'])->name('load.school.result');
    Route::post('publish-result', [ResultRecordController::class, 'publishSchoolResult'])->name('publish.school.result');

    // export student list 
    Route::get('export-student-list', [StudentScoreController::class, 'exportStudentList'])->name('export.student.list');
    Route::post('import-student-score', [StudentScoreController::class, 'importStudentScore'])->name('import.student.score');
    // view student subject score 
    Route::view('view-subject-score', 'school.student.assessment.view-subject-score')->name('view.subject.score');
    Route::post('view-subject-score', [StudentScoreController::class, 'loadStudentScore']);
    // Route::get('view-student-score', [StudentScoreController::class, 'loadStudentScore'])->name('view.student.score');

    // psychomotor 
    Route::view('record-extra-curricular', 'school.student.psychomotor.record-psychomotor')->name('record.extra.curricular');
    Route::post('record-extra-curricular', [RecordPsychomotorController::class, 'loadPsychomotoKeys']);
    Route::post('record-extra-curricular-score', [RecordPsychomotorController::class, 'recordPsychomotorScore'])->name('record.psycomotor.score');

    Route::view('view-extra-curricular-score', 'school.student.psychomotor.view-extra-curricular-score')->name('view.psychomotor');
    Route::post('view-extra-curricular-score', [RecordPsychomotorController::class, 'loadPsychomotoScore']);
    // affective domain 
    // I dont think this route is still working 
    // Route::view('student-ad-form', 'school.student.affective.affective-form')->name('affective.assessment.form');
    // Route::post('student-ad-form', [AffectiveDomainController::class, 'loadAffecitveKeys']);
    // Route::post('record-affective-score', [AffectiveDomainController::class, 'recordAffectiveDomainScore'])->name('record.affective.score');

    // view student result 
    Route::view('view-termly-result', 'school.student.result.termly-result.view-termly-result')->name('view.student.termly.result');
    Route::post('view-termly-result', [StudentTermlyResultController::class, 'loadStudentResult']);

    
    // particular student money
    Route::get('student-report-card/{param}/{pid}', [StudentTermlyResultController::class, 'studentReportCard'])->name('student.report.card');
    Route::get('print-student-report-card/{param}/{pid}', [StudentTermlyResultController::class, 'loadStudentResultPdf'])->name('student.report.card.pdf');
    // view student cumualtive result 
    //view-student-cumualtive-result
    Route::view('load-student-cumulative-result', 'school.student.result.cumulative.cumulative-result-form')->name('view.student.cumualtive.result');
    Route::post('load-student-cumulative-result', [ViewCumulativeResultController::class, 'loadStudentCumulativeResult']);
    Route::get('view-class-cumulative-results', [ViewCumulativeResultController::class, 'loadClassCumulativeResult'])->name('view.class.cumulative.result');
    Route::get('class-cumulative-result/{param}/{std}', [ViewCumulativeResultController::class, 'studentCumulativeReportCard'])->name('student.cumulative.result');
    // redirect to this route 
    // particular student money
    Route::get('student-cumulative-result/{param}/{pid}', [StudentTermlyResultController::class, 'studentReportCard'])->name('student.cm.report.card');

    // comments 
    // principal comment 
    Route::view('principal-comment-form', 'school.student.result.comments.principal.principal-comment-form')->name('principal.comment.termly.result');
    // the view // princal-comment.blade.php
    Route::post('principal-comment-form', [PrincipalCommentResultController::class, 'loadStudentResult']);
     // pricinpal commenting 
     Route::post('principal-commenting-termly-result', [PrincipalCommentResultController::class, 'principalCommentStudentTermlyResult'])->name('comment.principal.student.termly.result');
    // principal automated comment
    Route::view('principal-automated-comment', 'school.student.result.comments.principal.principal-automated-comment')->name('principal.automated.comments');
    // load principal comment
    Route::get('load-principal-automated-comment', [PrincipalCommentResultController::class, 'loadPrincipalAutomatedComment'])->name('load.principal.automated.comments');
    // the view // princal-comment.blade.php
    Route::post('principal-automated-comment', [PrincipalCommentResultController::class, 'principalAutomatedComment'])->name('principal.add.comment');
    // class teacher comment
    Route::view('teacher-comment', 'school.student.result.comments.teacher.teacher-comment')->name('teacher.comment.termly.result');
    // load student result
    Route::post('teacher-comment', [TeacherCommentResultController::class, 'loadStudentResult']);
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

    // Route::post('portals-comment-termly-result', [PortalCommentResultController::class, 'loadStudentResult']);
    // class portal comment
    // Route::post('portals-commenting-termly-result', [PortalCommentResultController::class, 'portalsCommentStudentTermlyResult'])->name('comment.portals.student.termly.result');

    // class portal comment
    Route::view('portals-automated-comment', 'school.student.result.comments.portals.portals-automated-comment-form')->name('portal.automated.comments');

    // Route::post('portals-automated-comment', [PortalCommentResultController::class, 'loadStudentResult']);
    
    // class subject teacher comment
    Route::view('subject-comment-termly-result', 'school.student.result.comments.principal-comment-form')->name('subject.comment.termly.result');
    // student promotion 
    Route::view('promote-student', 'school.student.promotion.promote-student')->name('promote.student');
    Route::post('promote-student', [PromoteStudentController::class, 'loadStudent']);
    Route::post('migrate-student', [PromoteStudentController::class, 'promoteStudent'])->name('migrate.student');
    // swap student 
    Route::view('swap-student', 'school.student.promotion.swap-student')->name('swap.student');
    Route::post('swap-student', [PromoteStudentController::class, 'loadStudentByArm']);
    Route::post('swaping-student', [PromoteStudentController::class, 'swapStudent'])->name('swaping.student');

    // parent activities 
    Route::post('ward-login/{pid}', [ParentController::class, 'wardLogin'])->name('ward.login');


    // payment receipt 

    // school hire process 
    // Route::view()->name('hire.config');

    Route::view('hire-config', 'school.framework.hire.hire-config')->name('hire.config');
    Route::post('load-hire-able', [JobAdvertController::class, 'loadPotentialApplicantHireConfig'])->name('hire.hire.able');
    Route::get('load-advert', [JobAdvertController::class, 'loadAdvertConfig'])->name('load.school.recruitment');
    Route::post('load-job-applicant', [JobAdvertController::class, 'loadJobApplicant'])->name('load.job.applicant');
    Route::post('load-available-all-school-subject', [Select2Controller::class, 'loadAllSchoolSubject']);
    Route::post('create-advert', [JobAdvertController::class, 'createAdvert'])->name('create.advert');

    // hireworthy 
    // Route::view('hire-worthy', 'add-on.hire-worthy')->name('hire.worthy')->middleware('auth');
    // available for hire
    Route::view('hire-me', 'add-on.hire-worthy')->name('hire.me')->middleware('auth');
    Route::post('hire-me-config',[JobAdvertController::class, 'hireMeConfig'])->name('hire.me.config');

    Route::get('load-me-config', [JobAdvertController::class, 'loadHireMeConfig'])->name('load.hire.config');



    // drop down 

    // load dropdon select2
    // load school on dropdon using select2  
    Route::post('load-available-', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.dropdown');

   
    Route::post('load-available-all-state-subjects', [Select2Controller::class, 'loadAllStateSchoolSubject'])->name('load.available.all.state.subject');

    Route::post('load-available-session', [Select2Controller::class, 'loadSchoolSession'])->name('load.available.session');
    // load category 
    Route::post('load-available-category', [Select2Controller::class, 'loadAvailableCategory'])->name('load.available.category');
    // load assessment title 
    Route::post('load-available-title', [Select2Controller::class, 'loadAvailableTitle'])->name('load.available.title');
    // load term 
    Route::post('load-available-term', [Select2Controller::class, 'loadSchoolTerm'])->name('load.available.term');
    // load classes 
    Route::post('load-available-class', [Select2Controller::class, 'loadAvailableClass'])->name('load.available.class');
    // load all category classes 
    Route::post('load-available-all-class', [Select2Controller::class, 'loadAvailableAllClasses'])->name('load.available.all.class');
    // admission class
    Route::post('load-available-admission-class', [Select2Controller::class, 'loadAvailableAdmissionClass'])->name('load.available.admission.class');
    // load classe arm 
    Route::post('load-available-class-arm', [Select2Controller::class, 'loadAvailableClassArm'])->name('load.available.class.arm');
    // load class teacher/form classes 
    Route::post('load-available-class-teacher-class', [Select2Controller::class, 'loadClassTeacherClass'])->name('load.available.class'); // just for classes
    Route::post('load-available-class-teacher-arm', [Select2Controller::class, 'loadClassTeacherClassArms'])->name('load.available.class.arm'); // 4 class n subject
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
    // load hostel 
    Route::post('load-available-hostels', [Select2Controller::class, 'loadAvailableHostels']);
    // portal 
    Route::post('load-available-portals', [Select2Controller::class, 'loadAvailablePortals']);

    // psychomotor 
    // load psychomotor by school cateogry
    Route::post('load-available-psychomotors', [Select2Controller::class, 'loadAvailablePsychomotors']);
    // load all psychomotor 
    Route::post('load-available-psychomotors-all', [Select2Controller::class, 'loadAvailableAllPsychomotors']); 

    Route::post('load-available-fee-account', [Select2Controller::class, 'loadAvailableFeeAccount']); 

    Route::post('load-available-assessment-types', [AssessmentController::class, 'loadAssessmentTypes']);
    Route::post('load-available-award', [Select2Controller::class, 'loadAward']);
    
});
//load states
Route::post('load-available-state', [Select2Controller::class, 'loadStates'])->name('load.available.state');
//load school states
Route::post('load-available-state-lga', [Select2Controller::class, 'loadStatesLga'])->name('load.available.state.lga');
    // load all the subject of every school in a state 

// admission 
Route::get('admission/{id?}',[AdmissionController::class,'index'])->name('admission');
// admission 
Route::post('admission',[AdmissionController::class,'createAdmission']);

// public hiring 
Route::get('hiring',[JobAdvertController::class,'index'])->name('hiring');
Route::get('apply-job',[JobAdvertController::class,'applyJob'])->name('apply.school.job');

