<?php
define('APP_NAME', 'EduLite');
define('NAIRA_UNIT', "&#8358;"); //NAIRA sign
define('AUTH_TOKEN', "EduLiteAuthToken"); //
define('DEFAULT_PASSWORD', "123456"); //
define('CLASS_NUMBER', ['1'=>'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', '10' => 'Ten']);//NAIRA sign
define('GENDER', ['2' => 'Female','1' => 'Male','3' => 'Other','0'=>null]);//NAIRA sign
define('RELIGION', ['2' => 'Christian','1' => 'Muslim','3' => 'Other', '0' => null]);
define('NOTIFICATION_TYPE', ['Individual','Notice board','Parent', 'Rider', 'General', 'Students',  'all staff', 'Academic staff', 'Non-academic']);
define('STAFF_ROLE', ['200' => 'School Super Admin','205' => 'School Admin','300' => 'Teacher','301' => 'Form/Class Teacher',
'303' => 'Clerk','305' => 'Secretary','307' => 'Portals','400' => 'Office Assisstnace','405' => 'Security',
'500' => 'Principal/Head Teacher', '600' => 'Student','601' => 'Applicant', '605' => 'Parent/Guardian',
'610' => 'Rider','700' => 'Agent/Referer', '710' => 'Partners','10' => 'App Admin',
// '505'=> 'Head Teacher',
]);
define('ACCOUNT_STATUS', ['Deactivated','Activated']);
define('SETUP_STATUS', [' Suspended', ' Active',' Incomplete setup']);
define('STUDENT_STATUS', ['0' => 'Disabled','1' => 'Active Student', '3' => 'Left School',  '4' => 'Suspended', '2' => 'Graduated' , '' => '' ]);
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
        // "Here you will assign subjects to each class",
        "Here you will create assessment as it will appear on student report card",
        "This is where you will assign maximum obtainable score to assessment title",
        "",
        "","","","","",""
    ]
);
define('BANKS',[
    'Access Bank Plc' , 
'Citibank Nigeria Limited' , 
'Ecobank Nigeria Plc' , 
'Fidelity Bank Plc'  ,
'First Bank Nigeria Limited'  ,
'First City Monument Bank Plc'  ,
'Globus Bank Limited'  ,
'Guaranty Trust Bank Plc'  ,
'Heritage Banking Company Ltd.'  , 
'Keystone Bank Limited'  ,
'Optimus Bank'  ,
'Parallex Bank Ltd'  ,
'Polaris Bank Plc'  ,
'Premium Trust Bank'  ,
'Providus Bank'  ,
'Signature Bank Limited'  ,
'Stanbic IBTC Bank Plc'  ,
'Standard Chartered Bank Nigeria Ltd.'  ,
'Sterling Bank Plc'  ,
'SunTrust Bank Nigeria Limited'  ,
'Titan Trust Bank Ltd'  ,
'Union Bank of Nigeria Plc'  ,
'United Bank For Africa Plc'  ,
'Unity Bank Plc'  ,
'Wema Bank Plc'  ,
'Zenith Bank Plc'  ,
]);

define('MONTH_CODE',[
    '01' =>'JA' , 
    '02' =>'FE' , 
    '03' =>'MR' , 
    '04' =>'AP' , 
    '05' =>'MA' , 
    '06' =>'JN' , 
    '07' =>'JL' , 
    '08' =>'AG' , 
    '09' =>'SE' , 
    '10' =>'OC' , 
    '11' =>'NO' , 
    '12' =>'DC' , 
]);

define('EXTRA_CURRICULAR_GRADE_STYLE',[1 => 'Number', 2 => 'Alphabet', 3 => 'Checked', 4 => 'Sentence']);
define('AWARD_TYPE',[1 => 'One per Class', 2 => 'One per School', 3 => 'General', '' =>'']);
define('RESULT_FEE_STATUS',['Not Paid Yet' , 'Paid' , 'Part Payment' , 'Credit' , 'Free' , 'Annual Payment']);



