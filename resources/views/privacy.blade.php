@extends('layout.mainlayout')
@section('title','Privacy Policy')
@section('content')

<style>
   
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
    <div class="row ">
        <div class="col-md-6">
            <div class="hero_left mt-4">
                <h3 >
                    <span class="lite-color h2">Learning Today</span>, <br>
                    <span class="ed-color h2">Leading Tomorrow</span>
                </h3>
                <p>
                    Dear parent, guardian, teacher elders, it is our collective duty to give our children (the next generation) the best education they deserve in-order to make this world a better and safe place.
                </p>
                <h5 class="m-3 p-2">
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
<section class="container">
    Privacy Policy for {{env('APP_NAME', APP_NAME)}}

Introduction

- Briefly introduce your app and its purpose
- Explain that this policy applies to the use of Facebook Graph API in your app

Information Collection

- Describe the types of data your app collects from Facebook, such as:
    - User profile information (e.g., name, email, profile picture)
    - User friends and connections
    - User interactions (e.g., likes, comments, shares)
- Explain how you collect this data (e.g., through the Facebook Graph API)

Use of Information

- Describe how your app uses the collected data, such as:
    - To provide app functionality
    - To personalize user experience
    - To improve app performance
- Explain any other purposes for which you use the data

Data Sharing

- Describe if and how you share user data with third parties, such as:
    - Service providers
    - Partners
    - Advertisers
- Explain the circumstances under which data is shared

Data Security

- Describe your data security measures, such as:
    - Encryption
    - Access controls
    - Data storage practices

User Rights

- Explain users' rights regarding their data, such as:
    - Accessing their data
    - Correcting or deleting their data
    - Opting out of data collection

Compliance

- State your compliance with Facebook's Platform Policies and Developer Terms
- Explain your compliance with applicable data protection laws (e.g., GDPR, CCPA)

Changes to this Policy

- Explain how you will notify users of changes to this policy

Contact

- Provide contact information for users to reach out with questions or concerns

Please note that this is a basic outline and should be reviewed and customized according to your specific app's needs and legal requirements. It's recommended to consult with a legal expert to ensure compliance with all applicable laws and regulations.
</section>


<!-- <div class="album text-muted">
    <div class="container">
        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="route('login')">Create an account</a></p>
        </div>
    </div>
</div> -->
@endsection