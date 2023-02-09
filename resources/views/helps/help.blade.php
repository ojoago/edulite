@extends('layout.mainlayout')
@section('title','Helps')
@section('content')
<div class="pagetitle">
    <h1>Helps</h1>
</div><!-- End Page Title -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Help</h5>

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
        <!-- Admin Help  -->
        @endif
        @if(getUserActiveRole() == 301)
        <!-- Admin help/guide  -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        My Student
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
                <h2 class="accordion-header" id="headingAssessment">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAssessment" aria-expanded="false" aria-controls="collapseAssessment">
                        Assessment #2
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
                        Extra Curricular Activities #3
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
                        Student Result #4
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
                        Comment #5
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