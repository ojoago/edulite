@extends('layout.mainlayout')
@section('title','Helps')
@section('content')
<div class="pagetitle">
    <h1>Helps</h1>
</div><!-- End Page Title -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Help</h5>
        @guest
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        System flow
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Create School</strong><br> Click on create school and fill the form with school details then click on create, wait for few seconds if everything is entered correctly, your school will be created.
                        school component
                        <ol>
                            <li>Sign up</li>
                            <li>Verify Account</li>
                            <li>Login</li>
                            <li>Create A school</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        How to Sign Up
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Sign up & Verification Step by step guide.</strong>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/hnT04nynb7Y">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        How to Login
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Login Step by step guide.</strong>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/_kFTF09sgBk">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCreateSchool">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#createSchool" aria-expanded="false" aria-controls="createSchool">
                        How to Create A School
                    </button>
                </h2>
                <div id="createSchool" class="accordion-collapse collapse" aria-labelledby="createSchool" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Creating School step by step guide.</strong>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/g6eyJnMsuZ8">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
        @endguest
        @if(getUserActiveRole() == 205)
        <!-- Admin help/guide  -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        System flow
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Create School</strong><br> Click on create school and fill the form with school details then click on create, wait for few seconds if everything is entered correctly, your school will be created.
                        school component
                        <ol>
                            <li data-bs-toggle="collapse" data-bs-target="#collapseTwo" class="pointer">School Head/Principal/Head Teacher</li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapseCategory" class="pointer">School Category | e.g Primary, Secondary etc</li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapseClass" class="pointer">Classes | e.g Primary 1, 2, 3 etc</li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapseClassArm" class="pointer">Class Arms | e.g Primary 1 A, 1 B ,1 C etc</li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapsesubjectType" class="pointer">
                                Subjects | e.g English
                                <ol>
                                    <li data-bs-toggle="collapse" data-bs-target="#collapsesubjectType" class="pointer">Subject Types</li>
                                    <li data-bs-toggle="collapse" data-bs-target="#collapsesubject" class="pointer">Subjects</li>
                                </ol>
                            </li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapseterm" class="pointer">Terms | e.g First Term</li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapsesession" class="pointer">Sessions | e.g 2022/2023 Session</li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapseassessment" class="pointer">Assessment
                                <ol>
                                    <li data-bs-target="#collapseassessment" class="pointer">Assessment Title</li>
                                    <li data-bs-toggle="collapse" data-bs-target="#collapsescore" class="pointer">Score Setting</li>
                                </ol>
                            </li>
                            <li data-bs-toggle="collapse" data-bs-target="#collapsegrade" class="pointer">School Grade</li>
                        </ol>
                        <strong>Setting UP, <small>Framework</small></strong><br>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Users Account
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>First after creating a school, proceed to create school head I.e Principal or Head Teacher etc as the case maybe, Under Account Menu</strong>
                        <ul><strong>Account</strong>
                            <li>Staff</li>
                            <li>Student</li>
                            <li>Parent</li>
                            <li>Pick Riders</li>
                        </ul>
                        <p>After Clicking on Staff it will open a page for Staff account. Same goes for Students, Parents and Riders</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/RtrzvczZjlU">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="categoryHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                        School Category
                    </button>
                </h2>
                <div id="collapseCategory" class="accordion-collapse collapse" aria-labelledby="categoryHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Create School Category</strong>
                        <p>School Category is an important aspect because classes fall under category, e.g Secondary, Primary, Nursary etc</p>
                        <p>To create School Category, Click on Class Under Framework, a page will open in few seconds,
                            click on the create Category Button, a modal form will be displayed, fill the form accordingly and click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/ALokq6LoyYI">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="classHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClass" aria-expanded="false" aria-controls="collapseClass">
                        School Class
                    </button>
                </h2>
                <div id="collapseClass" class="accordion-collapse collapse" aria-labelledby="classHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>School Class</strong>
                        <p>School Class is the second tab under class page, and each class falls under a category. e.g jss 1 under Secondary, primary 1 under Primary, nursery 1 under Nursery etc</p>
                        <p>To create School Class, Click on Class tab Under Framework, a page will open in few seconds, click on class next to class category, then click on create Class Button, a modal form will be display, fill the form accordingly and click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/nXklwUVRwRw">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="classArmHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClassArm" aria-expanded="false" aria-controls="collapseClassArm">
                        School Class Arm
                    </button>
                </h2>
                <div id="collapseClassArm" class="accordion-collapse collapse" aria-labelledby="classArmHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Class Arm</strong>
                        <p>Class Arm is the Third tab under class page, and each class arm falls under a class. e.g JSS 1A under Jss 1, primary 1A under Primary 1, nursery 1A under Nursery 1 etc</p>
                        <p>To create a Class Arm, Click on Class Under Framework, a page will open in few seconds, click on Class Arm tab next to class tab,
                            then click on create Class Arm Button, a modal form will be displayed, fill the form accordingly by selecting a category and a
                            class then enter the name of of class arm accordingly click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/PCng-q2PQSE">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="subjectTypeHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesubjectType" aria-expanded="false" aria-controls="collapsesubjectType">
                        School Subject Type
                    </button>
                </h2>
                <div id="collapsesubjectType" class="accordion-collapse collapse" aria-labelledby="subjectTypeHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Subject Type</strong>
                        <p>Subject type is the first tab on subject page, Subject type is a way of grouping more than subject result into one on student report card, e.g
                            in some private school subject like English language will be divided into (composition, comprehension, grammer and spelling)
                            but at the end of termly result it will be desired to appear under one heading which english language</p>

                        <p>To create Subject type, Click on Subjects Under Framework, a page will open in few seconds,
                            then click on create Subject Type Button, a modal form will be displayed, fill the form accordingly by entering the name of the subject type and click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/TnbbMRLIT-w">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="subjectHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesubject" aria-expanded="false" aria-controls="collapsesubjectType">
                        School Subject
                    </button>
                </h2>
                <div id="collapsesubject" class="accordion-collapse collapse" aria-labelledby="subjectHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Subject </strong>
                        <p>Subject is the second tab on subject page, subjects are grouped under subject type, if the school chooses to have more than one subject grouped on a student report card</p>

                        <p>To create Subject, Click on Subjects Under Framework, a page will open in few seconds,
                            then click on create Subject Button, a modal form will be displayed, select the subject type that the subject belongs to and enter the subject name and click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/TnbbMRLIT-w">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="sessionHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesession" aria-expanded="false" aria-controls="collapsesession">
                        School Session
                    </button>
                </h2>
                <div id="collapsesession" class="accordion-collapse collapse" aria-labelledby="sessionHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>School Session </strong>
                        <p>Every school has an academic callender that fall within session</p>

                        <p>To create Session, Click on Sessions Under Framework, a page will open in few seconds,
                            then click on New Session Button, a modal form will be displayed, Enter the name of the session as you want it to appear click on submit</p>
                        <!-- <iframe class="iframe-video" src="https://www.youtube.com/embed/hnT04nynb7Y">
                        </iframe> -->
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="termHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseterm" aria-expanded="false" aria-controls="collapseterm">
                        School Term
                    </button>
                </h2>
                <div id="collapseterm" class="accordion-collapse collapse" aria-labelledby="termHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>School Term </strong>
                        <p>School term could first, second third term or whatever the school choose to call it.</p>

                        <p>To create Term, Click on Terms Under Framework, a page will open in few seconds,
                            then click on New Term Button, a modal form will be displayed, Enter the name of the Term as you want it to appear click on submit</p>
                        <!-- <iframe class="iframe-video" src="https://www.youtube.com/embed/hnT04nynb7Y">
                        </iframe> -->
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="assessmentHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseassessment" aria-expanded="false" aria-controls="collapseassessment">
                        School Assessment Title
                    </button>
                </h2>
                <div id="collapseassessment" class="accordion-collapse collapse" aria-labelledby="assessmentHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Assessment Title</strong>
                        <p>Assessment Title is the first tab under assessment page, and it is where you create assessment name e.g first CA, second CA, test, exam etc as the case maybe.</p>

                        <p>To create Assessment Title, Click on Assessment Under Framework, a page will open in few seconds,
                            then click on Create Assessment Button, a modal form will be displayed, Enter the name of the Assessment as many as you want and as you want it to appear on student report card and click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/c3VjNilbkbE">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="scoreHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsescore" aria-expanded="false" aria-controls="collapsescore">
                        School Assessment Score Settings
                    </button>
                </h2>
                <div id="collapsescore" class="accordion-collapse collapse" aria-labelledby="scoreHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Score Settings</strong>
                        <p>Score Setting is the second tab under assessment page, and it is where you define maximum obtainable score for each assessment type, e.g exam 70 mark, test 10 mark, CA1 t10 mark, c2 10 as the case maybe and everything must sum to 100.</p>

                        <p>To setup Score Settings, Click on Assessment Under Framework, a page will open in few seconds,
                            then click on Score Setting tab next to Assessment and click on Create Score Settings Button, a modal form will be displayed, Enter the name of the Assessment as many as you want and as you want it to appear on student report card and click on submit</p>
                        <iframe class="iframe-video" src="https://www.youtube.com/embed/c3VjNilbkbE">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="gradeHeading">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsegrade" aria-expanded="false" aria-controls="collapsescore">
                        School Grade
                    </button>
                </h2>
                <div id="collapsegrade" class="accordion-collapse collapse" aria-labelledby="gradeHeading" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Grade Settings</strong>
                        <p>Grade Setting is the First tab under grade page, and it is where you define corresponding grade for student subject score, e.g 70-100 A,60-69 B,50-59 C, 40-49 D, 35 -39 E, less than 35 F etc as the case maybe.</p>

                        <p>To setup Score Grade, Click on Grade Under Framework, a page will open in few seconds,
                            then click on Create Grade Button , a modal form will be displayed, Enter the grade, grade title, minimum and maximum score for each grade and click on the red button above to add more, as many as you want and as you want it to appear on student report card and click on submit</p>
                        <!-- <iframe class="iframe-video" src="https://www.youtube.com/embed/hnT04nynb7Y">
                        </iframe> -->
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Accordion Item #3
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow. -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Admin Help  -->
        @endif
        @if(getUserActiveRole() == 301)
        <!-- Admin help/guide  -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Class Teacher Menus
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <!-- <strong>My Student</strong> Menu<br> Comprises of  -->
                        <strong>Class Teacher Activities</strong> Menu<br> Comprises of
                        <ol>
                            <li>My Student
                                <ol>
                                    <li>Student Class</li>
                                    <li>Assignment</li>
                                    <li>
                                        Attendance
                                        <ol>
                                            <li>Take Attendance</li>
                                            <li>Attendance Count</li>
                                            <li>Attendance History</li>
                                        </ol>
                                    </li>
                                    <li>Time-table</li>
                                    <li>Invoices</li>
                                </ol>
                            </li>
                            <li>Promotion
                                <ol>
                                    <li>Swap</li>
                                    <li>Promote</li>
                                </ol>
                            </li>
                            <li>Assessement
                                <ol>
                                    <li>Record CA's</li>
                                    <li>View CA's</li>
                                </ol>
                            </li>
                            <li>Psychomotor
                                <ol>
                                    <li>Psychomotor Assessment</li>
                                    <li>View Psychomotor Assessment</li>
                                </ol>
                            </li>
                            <li>Student Result
                                <ol>
                                    <li>View Result</li>
                                </ol>
                            </li>
                            <li>Comment
                                <ol>
                                    <li>Comment </li>
                                    <li>Automated Comment </li>
                                </ol>
                            </li>

                        </ol>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingAssessment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAssessment" aria-expanded="false" aria-controls="collapseAssessment">
                        My Student
                    </button>
                </h2>
                <div id="collapseAssessment" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingExtra">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExtra" aria-expanded="false" aria-controls="collapseExtra">
                        Promotion
                    </button>
                </h2>
                <div id="collapseExtra" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingResult">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResult" aria-expanded="false" aria-controls="collapseThree">
                        Assessment
                    </button>
                </h2>
                <div id="collapseResult" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingComment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComment" aria-expanded="false" aria-controls="collapseThree">
                        Psychomotor
                    </button>
                </h2>
                <div id="collapseComment" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingComment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComment" aria-expanded="false" aria-controls="collapseThree">
                        Student Result
                    </button>
                </h2>
                <div id="collapseComment" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingComment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseComment" aria-expanded="false" aria-controls="collapseThree">
                        Comment
                    </button>
                </h2>
                <div id="collapseComment" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
        </div>
        <!-- Admin Help  -->
        @endif
        @if(getUserActiveRole() == 300)
        <!-- Admin help/guide  -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Assessment
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Create School</strong><br> Click on create school and fill the form with school details then click on create, wait for few seconds if everything is entered correctly, your school will be created.
                        school component
                        <ol>
                            <li>School Head Principal/Head Teacher</li>
                            <li>School Category | e.g Primary, Secondary etc</li>
                            <li>Terms | e.g First Term</li>
                            <li>Sessions | e.g 2022/2023 Session</li>
                            <li>Classes | e.g Primary 1, 2, 3 etc</li>
                            <li>Class Arms | e.g Primary 1 A, 1 B ,1 C etc</li>
                            <li>
                                Subjects | e.g English
                                <ol>
                                    <li>Subject Types</li>
                                    <li>Subjects</li>
                                </ol>
                            </li>
                            <li>Assessment
                                <ol>
                                    <li>Assessment Title</li>
                                    <li>Score Setting</li>
                                </ol>
                            </li>
                            <li>School Grade</li>
                        </ol>
                        <strong>Setting UP, <small>Framework</small></strong><br>
                    </div>
                </div>
            </div>

        </div>
        <!-- Admin Help  -->
        @endif
        @if(getUserActiveRole() == 303)
        <!-- Admin help/guide  -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Assessment
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Create School</strong><br> Click on create school and fill the form with school details then click on create, wait for few seconds if everything is entered correctly, your school will be created.
                        school component
                        <ol>
                            <li>School Head Principal/Head Teacher</li>
                            <li>School Category | e.g Primary, Secondary etc</li>
                            <li>Terms | e.g First Term</li>
                            <li>Sessions | e.g 2022/2023 Session</li>
                            <li>Classes | e.g Primary 1, 2, 3 etc</li>
                            <li>Class Arms | e.g Primary 1 A, 1 B ,1 C etc</li>
                            <li>
                                Subjects | e.g English
                                <ol>
                                    <li>Subject Types</li>
                                    <li>Subjects</li>
                                </ol>
                            </li>
                            <li>Assessment
                                <ol>
                                    <li>Assessment Title</li>
                                    <li>Score Setting</li>
                                </ol>
                            </li>
                            <li>School Grade</li>
                        </ol>
                        <strong>Setting UP, <small>Framework</small></strong><br>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Admission #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Payment Collection #2
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Admin Help  -->
        @endif

        <!-- Admin help/guide  -->
        @if(getUserActiveRole() ==600)
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        System flow
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>Create School</strong><br> Click on create school and fill the form with school details then click on create, wait for few seconds if everything is entered correctly, your school will be created.
                        school component
                        <ol>
                            <li>School Head Principal/Head Teacher</li>
                            <li>School Category | e.g Primary, Secondary etc</li>
                            <li>Terms | e.g First Term</li>
                            <li>Sessions | e.g 2022/2023 Session</li>
                            <li>Classes | e.g Primary 1, 2, 3 etc</li>
                            <li>Class Arms | e.g Primary 1 A, 1 B ,1 C etc</li>
                            <li>
                                Subjects | e.g English
                                <ol>
                                    <li>Subject Types</li>
                                    <li>Subjects</li>
                                </ol>
                            </li>
                            <li>Assessment
                                <ol>
                                    <li>Assessment Title</li>
                                    <li>Score Setting</li>
                                </ol>
                            </li>
                            <li>School Grade</li>
                        </ol>
                        <strong>Setting UP, <small>Framework</small></strong><br>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Accordion Item #2
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Accordion Item #3
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                    </div>
                </div>
            </div>
        </div>
        <!-- Student Help -->
        @endif
    </div>
</div>


<script src="{{asset('js/jquery.3.6.0.min.js')}}"></script>

@endsection