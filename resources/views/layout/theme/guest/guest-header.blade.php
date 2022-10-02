 <style>
     * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
     }

     .ed-color {
         color: #00AFF0;
     }

     .lite-color {
         color: #FCBA03;

     }

     .bg-text {
         background-color: #000;
         color: #fff;
         border-radius: 10px;
     }

     .home_page {
         background-color: #fff;
         width: 100vw;
         padding: 0 40px;
         padding-bottom: 30px;
         position: relative;
     }

     .header {
         display: flex;
         align-items: center;
         justify-content: space-between;
         padding: 20px 40px;
         position: sticky;
         top: 0;
     }

     .header_left {
         display: flex;
         align-items: center;
     }

     .header_left>p {
         font-size: 16px;
         font-weight: 400;
         padding-right: 15px;
         color: #4f689d;
     }

     .header_center {
         font-size: 24px;
         font-weight: 600;
         color: #4f689d;
     }

     .login {
         background-color: #fff;
         border: none;
         padding: 10px;
         color: #4f689d;
     }

     .join {
         background-color: #00AFF0;
         color: #fff;
         border-radius: 8px;
         padding: 5px 10px;
         border: none;
     }

     .hero_right {
         width: 100%;
         height: auto;
     }

     .hero_right>img {
         width: 100%;
         height: auto;
         object-fit: cover;
     }

     .hero_left {
         display: flex;
         flex-direction: column;
         justify-content: center;
         padding-left: 40px;
     }

     .hero_left>h1 {
         font-size: 4rem;
         font-weight: 500;
     }

     .hero_left>h1>span {
         color: #c86351;
     }

     .hero_left>h5 {
         font-size: 2rem;
     }

     @media screen and (max-width: 760px) {
         .hero_left {
             padding-left: 0 !important;
             padding: 10px !important;
         }

         .hero_left>h1 {
             font-size: 2rem !important;
             font-weight: 400 !important;
         }

         .hero_left>h1>span {
             color: #c86351;
         }

         .hero_left>h5 {
             font-size: 2rem;
         }

     }

     #user-main {
         margin-top: 60px !important;
         padding: 20px 30px;
         transition: all 0.3s;
     }

     #footer {
         margin: 0 !important;
     }
 </style>


 <!-- header section -->
 <section>
     <div class="header">
         <div class="header_left">
             <div class="d-flex justify-content-center py-4">
                 <a href="{{url('/')}}" class="logo d-flex align-items-center w-auto">
                     <img src="{{asset('files/edulite/edulite logo.png')}}" alt="{{env('APP_NAME', APP_NAME)}}" style="height:auto;">
                     <span class="d-none d-lg-block">{{env('APP_NAME', APP_NAME)}}</span>
                 </a>
             </div>
         </div>
         <div class="header_right">
             <a href="{{route('login')}}"><button class="login">Login</button>
             </a>
             <a href="{{route('sign.up')}}"><button class="join">Sign Up</button></a>
         </div>
     </div>
 </section>
 <div class="container">