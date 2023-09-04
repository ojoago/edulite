<?php
define('APP_NAME', 'EduLite');
define('NAIRA_UNIT', "&#8358;"); //NAIRA sign
define('AUTH_TOKEN', "EduLiteAuthToken"); //
define('CLASS_NUMBER', ['1'=>'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', '10' => 'Ten']);//NAIRA sign
define('GENDER', ['2' => 'Female','1' => 'Male','3' => 'Other']);//NAIRA sign
define('RELIGION', ['2' => 'Christian','1' => 'Muslim','3' => 'Other']);
define('NOTIFICATION_TYPE', ['Individual','Notice board','Parent', 'Rider', 'General', 'Students',  'all staff', 'Academic staff', 'Non-academic']);
define('STAFF_ROLE', ['200' => 'School Super Admin','205' => 'School Admin','300' => 'Teacher','301' => 'Form/Class Teacher',
'303' => 'Clerk','305' => 'Secretary','307' => 'Portals','400' => 'Office Assisstnace','405' => 'Security',
'500' => 'Principal/Head Teacher', '600' => 'Student','601' => 'Applicant', '605' => 'Parent/Guardian',
'610' => 'Rider','700' => 'Agent/Referer', '710' => 'Partners','10' => 'App Admin',
// '505'=> 'Head Teacher',
]);
define('ACCOUNT_STATUS', ['Deactivated','Activated']);
define('SCHOOL_SETUP', ['pr','Activated']);
define('ER_500', 'Something Went Wrong ...error logged');
define('SETUP_STAGE', [
    '', "This is where you will create school head: e.g Principal, head teacher!!",
        "This is where you will create school Term. e.g First term, second term etc",
        "This is where you will create school Session",
        "This is where you will set school Active/Current Session",
        "This is where you will set school Active/Current Term",
        "This is where you will create Categories. e.g Primary, Nursery etc",
        "This is where you will create class under each Categories. e.g Primary 1, Nursery 1 etc",
        "This is where you will create class arms under each classes. e.g Primary 1 A, Nursery 1 B etc",
        "Here you will create school Subject Types/groups",
        "Here you will create school Subjects under each subject types",
        "Here you will assign subjects to each class",
        "Here you will create assessment as it will appear on student report card",
        "This is where you will assign maximum obtainable score to assessment title",
        "",
        "","","","","",""
    ]
);
