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
}
