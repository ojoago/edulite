<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class SeasonalGreetingController extends Controller
{
    private $birthday = [];
    public static function seasonalGreeting()
    {
        $users = (new self)->loadUsers();
        $data = [
            'message' => 'Democracy is not just a system of governance; it is a shared commitment to upholding the values of equality, inclusivity, and respect for fundamental human rights. 
            It is an opportunity for every Nigerian voice to be heard and every citizen to contribute to the nation’s growth.

Let us strive for unity amidst our diversity, embracing dialogue and peaceful coexistence as we work towards a better Nigeria. Together, we can overcome challenges, bridge divides, and foster an environment where every Nigerian can thrive.

Happy Democracy Day Nigerians💚! ',
            'blade' => 'greeting',
            'subject' => 'Democracy Day',
            // 'name' => 'Hassan',
            // 'email' => 'ojoago247@gmail.com'
        ];
        // sendMail($data);
        foreach($users as $user){
            $data['email']= $user->email;
            $data['name']= $user->username;
            sendMail($data);
        }
    }
    public static function customGreeting()
    {
        $users = (new self)->loadUsers();
        $data = [
            'message' => " <b>Greetings To Schools, Students, Teachers And Parents </b> <br>

It is no more news that our children resumed to school, to every pupils and students, welcome back from the holidays, it is time to dust the books, open to new chapters and begin another path on your journey to greatness. <br>
We thank every Teachers, for their contributions to building a better society. <br>
We use this opportunity to extend our prayers and support to parents and guardians for the sacrifices and commitment for our wards and kids. 
We pray that our labours, investments and sacrifices on our children will yield good results. <br>

We wish you all happy resumption. We wish everyone an exciting and productive school 2024 second term.",
            'blade' => 'greeting',
            'subject' => 'Welcome to Second term 2024',
            // 'name' => 'Hassan',
            // 'email' => 'ojoago247@gmail.com'
        ];
//         sendMail($data);
// return ;
        foreach($users as $user){
            $data['email']= $user->email;
            $data['name']= $user->username;
            sendMail($data);
        }
    }

    public static function birthdays()
    {
        try {
            $users = DB::table('users as u')->join('user_details as d', 'd.user_pid', 'u.pid')->select('u.email', 'u.username')->whereMonth('d.dob', '=', date('m'))->whereDay('d.dob', '=', date('d'))->get();
            $data = [
                'message' => 'It truly is a pleasure to be wishing you
                                a happy birthday on what is such a
                                special day today.

                                May only the greatest things come your
                                way, lining the path for what will hopefully
                                be a wonderful year ahead.. 
                            ',
                'blade' => 'greeting',
                'subject' => 'HAPPY BIRTHDAY',
            ];

            foreach ($users as $user) {
                $data['email'] = $user->email;
                $data['name'] = $user->username;
                sendMail($data);
            }
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }
    public static function tgif()
    {
        $messages = [
            'TGIF – Thank God it’s Friday! Friday is universal favorite day for everyone. 
            Friday is great because it’s a day we can reflect on an awesome week that was. 
            It also ushers in the weekend, where we don’t have to worry about work or school. 
            We all look forward for Fridays after hectic working weekdays.
            ENJOY YOUR WEEKEND. ',
            'Finally the hustle and bustle of this week comes to an end. Look forward to a beautiful weekend. 
            May it be a restful one for you.
            <br>Happy Friday, this is wishing you a fun filled weekend. ',
            'May the Lord fill your heart with peace this weekend. May He surround you with rest on every side.',
            'This Friday, may you find the grace to pursue and overtake every blessing that has eluded you this week. Amen.',
            'Stay focused on your dreams, it’s not over until you win. Have a great Friday.',
            'It’s not too late to be what you want to be. Believe! Happy Friday.',
            'Count your blessings. Be thankful for what you have as you work towards achieving more.',
            'May every of your expectations for the week that is yet to be met be fulfilled today. Have a very happy Friday.',
            'Hope you had a pleasant week. Here’s wishing that your Friday launches you into a beautiful weekend.',
            'Happy Friday! May this Friday bring you happiness and cheer. May you be surrounded by blessings.',
            'Have a wonderful Friday. I hope this Friday finds you with everything good and nice.',
            'It feels good to be alive to see one more Friday in life. I know you love the day just as much as I do. Happy Friday! Have a great time!',
            'Don’t forget to take time on your Friday to say thanks to God for the life you are living. May you have a blessed Friday!',
            'Fridays are so fantastic that they can be celebrated every day of the week. Wishing you a day filled with joy and happiness with your loved ones!',
            'It is time to have fun since it’s finally Friday! Give your buddies a call, go out, and relax with your favorite people to get rid of all the tension from the week.',
            'I hope God gives you His blessings to have a recharging Friday that gives you strength to get through the next week as.
            It is time to let go of all the stress and frustration from the week on Friday. 
            I hope you are enjoying this glorious Friday morning and coming up with some fantastic plans for the upcoming weekend.',
            'Friday has arrived, the end of the week. Let’s smile, wave, and rejoice. The weekend awaits, with fun and delight. So, let’s welcome it in, with all of our might.',
            'A well-spent Friday will help you forget the long, cold week you’ve had to endure the previous seven days. So cheers.
            After all of your hard work this week, you deserve to have a good and happy Friday. Make the most of your Friday.',
            'I hope your Friday is filled with positivity and that this positivity lasts the entire week. Wishing you a very happy Friday.',
            'Every day in the week is a nightmare except Friday, in which our sweetest dreams come alive. Welcome to yet another Friday of your life!',
            'Let’s celebrate the end of the week with joy and positivity, and welcome the weekend with open arms. Wishing you all a happy Friday and a wonderful weekend.',
        ];
        try {
            //  
            $data = [
                'message' => $messages[rand(0, 17)],
                'blade' => 'greeting',
                'subject' => 'TGIF',
            ];
            $users = (new self)->loadUsers();

            // $data['email'] ='dhasmom01@gmail.com';
            // $data['name'] = 'OJOago';
            // sendMail($data);
            // return;
            foreach ($users as $user) {
                $data['email'] = $user->email;
                $data['name'] = $user->username;
                sendMail($data);
            }
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }
    public static function happyNewMonth()
    {
        $messages = [
            'Strive for excellence always. You deserve the best. Go for gold this new month.',
            'Aim for excellence always, and make the most of every opportunity. Wishing you a month full of success and achievement.',
            'May you have the wisdom to make the right decisions, the discernment to know your path, and the success to make your dreams a reality. Have a fantastic month ahead.',
            'Let this month be one of overcoming obstacles, realizing your potential, and achieving your goals. Here’s to a month of possibilities and success.',
            'May the angels of the Lord guide and protect you throughout the month, bringing you joy and peace. Happy new month!',
            'Wishing you mornings full of favor, afternoons with abundant harvests, and evenings of restful peace. Have a wonderful month ahead.',
            'May every aspect of your life experience healing and renewal, and may you enjoy a season of blessings and testimonies. Happy new month.',
            'May your  heart be filled with joy, your days be fruitful, and your blessings be abundant. Here’s to a month of joy and fulfillment.',
            'May you attract excellence in all that you do, matter among those who matter, and shine brilliantly throughout the month and beyond.',
            'Wishing you refreshing mornings, fruitful afternoons, relaxed evenings, and a month filled with beauty and bliss.',
            'May this new month be a time of growth, learning, and standing out among your peers. Have a great month ahead.',
            'May you weather any storm that comes your way and glide gracefully into success. Cheers to a new month!',
            'May every step you take be surrounded by beauty, favor, and success. Happy new month!',
            'May this month be full of blessings and untapped potential, bringing you prosperity and success. Here’s to a beautiful new month and a bright new day.',
            'Get ready to reap a great harvest of prosperity and success this month. It shall be well with you. Happy new month!',
            'Let go of the past and embrace the new month with open arms. May every day be filled with beauty and happiness.',
            'Make every moment count this month, embrace enthusiasm and excitement, and have a blissful and fulfilling month ahead.',
            'May your hard work be fruitful, your labor yield bountiful harvests, and your mouth be filled with laughter. Wishing you a super month.', '', '', ''
        ];
        try {
            //  
            $data = [
                'message' => $messages[rand(0, 17)],
                'blade' => 'greeting',
                'subject' => 'Happy New Month',
            ];
            
            // $data['email'] ='dhasmom01@gmail.com';
            // $data['name'] = 'OJOago';
            // sendMail($data);
            // return;
            $users = (new self)->loadUsers();
            foreach ($users as $user) {
                $data['email'] = $user->email;
                $data['name'] = $user->username;
                sendMail($data);
            }
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }

    public static function happyXmas()
    {
        $messages = 'Merry Christmas and Happy New Year! May this festive season fill your home with joy, peace, and love.';
        try {
            //  
            $data = [
                'message' => $messages,
                'blade' => 'greeting',
                'subject' => 'Happy Christmas',
            ];
            $users = (new self)->loadUsers();

            // $data['email'] ='dhasmom01@gmail.com';
            // $data['name'] = 'OJOago';
            // sendMail($data);
            // return;
            foreach ($users as $user) {
                $data['email'] = $user->email;
                $data['name'] = $user->username;
                sendMail($data);
            }
        } catch (\Throwable $e) {
            logError($e->getMessage());
        }
    }
    

    public static function setupReminder(){
      $messages =  "<b>Welcome to Second Term 2024 <b></b><br> 
        We are excited that you have signed up to use our platform to manage your school.
        We hope that you will find our platform easy to use and effective for your teaching and learning goals.
        However, we noticed that you have not completed your school setup process yet.
        To access all the features and benefits of our platform, you need to create your school head (Principal/Head teacher), Terms, Sessions, Categories,
        Classes, class arms, subject types, and subjects.
        the process is simplified, it won't take more 30 than minutes of your time and you can always reach out to our team.
        once you are through will the setup, our team will design a custom student report card for your school.";
        $data = [
            'message' => $messages,
            'blade' => 'greeting',
            'url' => 'login',
        ];
        $users = (new self)->loadSchoolAdmin();
        foreach ($users as $row) {
            $data['email'] = $row->email;
            $data['name'] = $row->fullname ?? $row->username;
            $data['subject'] = $row->school_name.', Setup Seminder';
            sendMail($data);
        }
    }

    private function loadUsers()
    {
        try {
            $users = DB::table('users as u')->select('email', 'username')->where('email', '<>', null)->get();
            return $users;
        } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
        }
    }

    private function loadSchoolAdmin(){
       try {
            $users = DB::table('users as u')->join('schools as s', 'u.pid', 's.user_pid')
                ->leftJoin('user_details as d', 'd.user_pid', 'u.pid')
                ->select('email', 'username', 'fullname', 'school_name')->where('u.email', '<>', null)->where('s.status', 2)->get();
        
         return $users;

       } catch (\Throwable $e) {
            logError($e->getMessage());
            return [];
       }
    }
}


// Here is a possible TGIF message for a teacher:

// Hello,

// You made it to the end of another week! Congratulations on your hard work and dedication to your students. You are doing an amazing job!

// We know that teaching can be challenging, especially in these uncertain times. But you have shown resilience, creativity, and compassion in your profession. You have inspired your students to learn, grow, and achieve their potential.

// We want to thank you for choosing our platform for your online education needs. We hope that you find our platform easy to use and effective for your teaching and learning goals. We are always here to support you and listen to your feedback.

// As you wrap up this week, we hope that you take some time to relax and recharge. You deserve it! Enjoy your weekend and celebrate your accomplishments. You are awesome!

// TGIF!

// Sincerely,
// The Our Platform Team