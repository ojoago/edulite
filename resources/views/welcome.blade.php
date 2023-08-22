@extends('layout.mainlayout')
@section('title','School Management Software that make life easier for Teacher and Admin...')
@section('content')

<style>
    /* .apple_button {
        display: flex;
        align-items: center;
        border: none;
        background-color: #fff;
        border-radius: 10px;
        padding: 5px 10px;
        width: 150px;
        margin-right: 20px;
        margin-top: 10px;
        box-shadow: -14px 7px 19px 5px rgba(0, 0, 0, 0.72);
        -webkit-box-shadow: -14px 7px 19px 5px rgba(0, 0, 0, 0.72);
        -moz-box-shadow: -14px 7px 19px 5px rgba(0, 0, 0, 0.72);
    }

    .bi-apple,
    .bi-google-play {
        font-size: 25px;
        padding-right: 10px;
    }

    .button_info>span {
        font-size: 12px;
        color: lightgray;
        padding-bottom: 2px;
    }

    .button_info>p {
        font-size: 15px;
        line-height: 0;
    } */

    .basic_section {
        display: grid;
        place-items: center;
    }

    .basic {
        /* width: 60%; */
        padding-top: 40px;
    }

    .basic>h1 {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
    }

    .basic>p {
        font-size: 16px;
        font-weight: 400;
        text-align: justify;
    }


    .card-secction>img {
        width: 150px;
        height: 150px;
        object-fit: contain;
    }

    .card-secction>h3 {
        font-size: 22px;
        font-weight: 500;
        padding-top: 10px;
        text-transform: uppercase;
    }

    .card-secction>p {
        font-size: 16px;
        font-weight: 400;
        padding-top: 10px;
        text-align: center;
    }

    .card-secction {
        width: 100%;
        height: 400px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #fff;
        border-radius: 4px;
        padding: 0 10px;
        box-shadow: -6px -4px 24px 5px rgba(212, 201, 201, 0.59);
        -webkit-box-shadow: -6px -4px 24px 5px rgba(212, 201, 201, 0.59);
        -moz-box-shadow: -6px -4px 24px 5px rgba(212, 201, 201, 0.59);
    }

    .card-secction>button {
        background-color: black;
        color: #fff;
        width: 50%;
        border-radius: 6px;
    }

    .values {
        padding: 40px;
    }

    .values>h1 {
        font-size: 28px;
        font-weight: 600;
        text-align: center;
    }

    .mobility {
        padding: 20px 10px;
    }

    .mobility>img {
        width: 150px;
        height: 150px;
        object-fit: contain;
    }

    .mobility>h3 {
        font-size: 22px;
        font-weight: 500;
        padding-top: 10px;
    }

    .mobility>p {
        font-size: 16px;
        font-weight: 400;
        padding-top: 10px;
        text-align: left;
    }
</style>

<section class="mt-4">
    <div class="row shadow">
        <div class="col-md-6">
            <div class="hero_left shadow mt-4">
                <h1>
                    <span class="ed-color">Learning Today</span>,
                    <span class="lite-color">Leading Tomorrow</span>
                </h1>
                <p>
                    Dear parent, guardian, teacher elders, it is our collective duty to give our children (the next generation) the best education they deserve in-order to make this world a better and safe place.
                </p>
                <h5 class="shadow m-3 p-2">
                    <p><span class="ed-color">Edu</span><span class="lite-color">Lite</span> Making life easier for teacher.</p>

                    <!-- <b class="ed-color">Education</b> <i class="bg-text">is</i> <b class="lite-color">Light</b> Hence <span class="ed-color">Edu</span><span class="lite-color">Lite</span> -->
                    <!-- <br /> @EduLite We celebrate champion -->
                </h5>

            </div>
        </div>
        <div class="col-md-6">
            <div class="hero_right mt-4">
                <img src="{{asset('files/edulite/svg/seminar-pana.svg')}}" alt="hero image" />
            </div>
        </div>
    </div>
</section>
<section class="basic_section">
    <div class="basic">
        <h1><span class="ed-color">Edu</span><span class="lite-color">Lite</span></h1>
        <p>Upgrade your school with EduLite, and ease the stress of school manual process at less cost. get accurate and accessible information about students, staff remotely.
            Allow guardian/parent keep track of their childrens performance easily and at their own time and convenience. EduLite manage school process such as report card,
            performance charts, attendance, student promotion, automated principal comment, hostel/portals, student pick up rider, event notification such as holidays, notify parent student exam timetable</p>
        <p>
            EduLite help school manage various tasks of school staff (admin, teacher, portal, hostel, Student pick up rider), parent, student.
            it helps to generate and organize reports, monitor activities etc.

        <ul>
            <li> Result and Reports Automation </li>
            <li> Class Arm Management </li>
            <li>Student Assignment</li>
            <li>Attendance </li>
            <li> Exam Time-Table </li>
            <li>
                Manage Admission
            </li>
            <li>
                Record Fee Collection
            </li>
            <li>
                Event, Birthday, holiday etc
            </li>
            <li>
                Student Awards
            </li>
        </ul>
        </p>
    </div>
</section>
<section class="basic_section">
    <h2 class="text-center">With <span class="ed-color">Edu</span><span class="lite-color">Lite</span> you can Manage</h2>
    <div class="basic row">
        <div class="col-md-3 mb-3">
            <div class="card-secction">
                <img src="{{asset('files/edulite/svg/student preparing.svg')}}" alt="student" />
                <h3>Student</h3>
                <p>
                    Result computation is automatic,
                    Performance Charts,
                    Attendance history,
                    <br>
                    Promote student to the next class with just a click
                </p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-secction">
                <img src="{{asset('files/edulite/svg/formula-pana.svg')}}" alt="student" />
                <h3>Teacher</h3>
                <p>Education needs wisdom, teacher handle humanly task while <span class="ed-color">Edu</span><span class="lite-color">Lite</span> takes care of the computatoins </p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-secction">
                <img src="{{asset('files/edulite/svg/height meter-amico.svg')}}" alt="student" />
                <h3>Parents</h3>
                <p>Track childrens performance easily anytime, anywhere conveniently</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card-secction">
                <img src="{{asset('files/edulite/svg/ride-amico.svg')}}" alt="student" />
                <h3>Portals/Pick up riders</h3>
                <p>Manage student hostel activities. <br> Parent/school keep track of who take children to/from school</p>
            </div>
        </div>

        <!-- <div class="col-md-12 mb-3">
            <div class="card-secction" style="padding: 20px!important; height:200px">

                <p>We've spent time building this APP with blood, sweat, and lots of resources.</p>
                <p>Real-life Human Beings
                    Tech veterans, geeks, and nerds are all standing by to optimize your experience.</p>
            </div>
        </div> -->

    </div>
</section>
<section class="card-section mb-4">

    <h2 class="text-center"> Frequently Asked Questions</h2>
    <p class="text-center">Have questions? We most likely have answered.</p>
    <div class="accordion" id="faqAccordian">
        <div class="accordion-item">
            <h2 class="accordion-header" id="h1">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                    <b> Is {{env('APP_NAME')}} software installed on a computer?</b>
                </button>
            </h2>
            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="h1" data-bs-parent="#faqAccordian">
                <div class="accordion-body p-4">
                    No, {{env('APP_NAME')}} is a cloud based software so it can be accessed from anywhere at any time and with any device that has internet accessibility.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <b>Does the portal accept excel upload?</b>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordian">
                <div class="accordion-body p-4">
                    Yes, excel can be used to compute students' results in bulk, register multiple Students, Staff and Parents.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <b>When sending results to parents do they get results for the whole class or get for their child/children?</b>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordian">
                <div class="accordian-body p-4">
                    Parents would only gain access to their child/children's result and records.
                </div>
            </div>
        </div>

        <div class="accordion-item">
            <h2 class="accordion-header" id="headingCreateSchool">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#createSchool" aria-expanded="false" aria-controls="createSchool">
                    <b> How Flexible is the software?</b>
                </button>
            </h2>
            <div id="createSchool" class="accordion-collapse collapse" aria-labelledby="createSchool" data-bs-parent="#faqAccordian">
                <div class="accordion-body p-4">
                    {{env('APP_NAME')}} is so flexible that reports and features can be customized to meet the needs and peculiarities of the school.
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <div class="album text-muted">
    <div class="container">
        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="route('login')">Create an account</a></p>
        </div>
    </div>
</div> -->
@endsection