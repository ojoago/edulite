<?php

namespace App\Http\Controllers\Advert;

use CURLFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FacebookApiController extends Controller
{
    const APPID = '2154995014842218';
    const APPSECRET = 'eab7fb42580d368c74a5a5a2f0702ea2';
    const URL = 'https://graph.facebook.com/v14.0/';
    // const TOKEN = 'EAAL0nNlMle0BAEYbQLd8vOfj2ZAWFPg7qsZAtpuZC7zWQ4MrfLcAOTc2hLFVUUQEApZC1GfARIsCQXlenxGxzoctZAwH447pDZCaYYbUkNglEVj9OHQSRB7XRoo5mC76L3V5mXHugWDqCHcZAkbVeTrPqerOObWomNZCD7oVB9ZBu5zx1bosBZCKo0GA2kpdy1ytoj8Evxbot6sAZDZD';
    // const APPID = '103454318924411/feed';
    const TOKEN = 'EAAHrCJiGppgBAD7UjHw50R1ytfZCI0GZAWYCvUtmYNXtnFRv77VvUbxOEDTiajpeFklVTtEIJqxZBluIZBZAb6oT1CZC4oFUxQ8emfEI7v07AjZAxTlApLRdn9qRq3uwADG8CvCcf5qMbxqNPis0eMSZCVzH45MA1qqN6cqcRbAQnUzU2HMZBWuWXqHTztahzO40ZD';
    // const APPID = '101600862694191/feed';
    const MATRIC = 'metric=post_reactions_by_type_total,page_actions_post_reactions_total';
    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
    }

    public static function getPageFeeds()
    {
        $data = self::getFeeds(self::APPID);
        if (is_string($data)) {
            return 'No Post Available';
        }
        $feeds = [];
        foreach ($data as $row) {
            $url = $row->id . '/insights?access_token=' . self::TOKEN . '&' . self::MATRIC;
            $result = self::getPostFeeds($url);
            $react = 0;
            if (is_string($result)) {
                $feeds[] = [
                    'feed_id' => $row->id,
                    'message' => $row->message,
                    'reactions' => 0,
                ];
            } else {
                foreach ($result as $k => $v) {
                    $react += $v;
                }
                $feeds[] = [
                    'feed_id' => $row->id,
                    'message' => $row->message,
                    'reactions' => $react,
                ];
            }
        }
        return $feeds;
    }
    public static function getPostDetailById($id)
    {

        $url = $id . '/insights?access_token=' . self::TOKEN . '&' . self::MATRIC;
        return $result = self::getInsight($url);
        $react = 0;
        if (is_string($result)) {
            $feeds = [
                'feed_id' => $id,
                'message' => 'Error Loading Post details',
                'reactions' => 0,
                'status' => 0
            ];
        } else {

            $feeds = [
                'feed_id' => $id,
                'message' => '$row->message',
                'reactions' => $result,
                'status' => 1
            ];
        }

        return $feeds;
    }
    public static function getPostFeeds($url)
    {
        return self::getInsight($url);
    }
    private static function getInsight($param)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL . "{$param}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch));
        $result = $result;
        if (curl_errno($ch)) {
            $result = 'Error:' . curl_error($ch);
            curl_close($ch);
            return $result;
        }
        curl_close($ch);
        return $result->data[0]->values[0]->value;
    }
    private static function getFeeds($param)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::URL . "{$param}?access_token=" . self::TOKEN);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = json_decode(curl_exec($ch));
        if (curl_errno($ch)) {
            $result = 'Error:' . curl_error($ch);
            curl_close($ch);
            return $result;
        }
        curl_close($ch);
        $result = $result->data;
        return $result;
    }

    public static function postFeed($data)
    {
        $ch = curl_init();
        $msg = str_replace(' ', '%20', $data);
        curl_setopt($ch, CURLOPT_URL, self::URL . "103454318924411/feed?message={$msg}&access_token=" . self::TOKEN);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($msg));
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $result = 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }



}



// Replace these with your values
$accessToken = 'YOUR_ACCESS_TOKEN';
$pageId = 'YOUR_PAGE_ID'; // Use "me" if posting to a user's profile
$imagePath = 'path/to/your/image.jpg'; // Path to your image file
$message = 'Your post text goes here'; // The message you want to post

// Create the cURL file for the image
$imageFile = new CURLFile($imagePath, mime_content_type($imagePath), basename($imagePath));

// The Graph API endpoint
$url = "https://graph.facebook.com/$pageId/photos";

// The POST data
$postData = [
    'message' => $message,
    'access_token' => $accessToken,
    'source' => $imageFile
];

// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the POST request
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    // Decode the response
    $result = json_decode($response, true);

    // Check if the post was successful
    if (isset($result['id'])) {
        echo 'Post was successful! Post ID: ' . $result['id'];
    } else {
        echo 'Post failed. Response: ' . $response;
    }
}

// Close cURL session
curl_close($ch);
