<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
use Cache;

class AnonymousController extends Controller
{
    public static function LoadMyIp(){

        $ip = env('APP_ENV') == 'local' ? env('DEMO_IP') : \Request::ip();

        // if(!Cache::has($ip)){

            $client = New GuzzleHttp\Client();

            //https://ipapi.com/-----------------------------

            // $key = env('IPAPI_KEY','38a480a0ab939c084bf8db0d91d84c23');
    
            // $endpoint = 'http://api.ipapi.com/'.$ip.'?access_key='.$key.'';
            // // dd($endpoint);
    
            // $response = $client->request('GET',$endpoint);
    
            // $result = json_decode($response->getBody(), JSON_OBJECT_AS_ARRAY);


            //http://ip-api.com/-----------------------------

                
            $endpoint = 'http://ip-api.com/json/'.$ip;

            $response = $client->request('GET',$endpoint);
    
            $result = json_decode($response->getBody());
            

            Cache::put($ip, $result, 1440);

        // }

    }
}
