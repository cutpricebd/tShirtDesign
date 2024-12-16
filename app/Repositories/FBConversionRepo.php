<?php

namespace App\Repositories;
use Illuminate\Support\Facades\Http;
use Info;

class FBConversionRepo {
    public static function track($track_type, $data = null, $em = null){
        if(Info::Settings('fb_api', 'pixel_id') && Info::Settings('fb_api', 'access_token')){
            $request_data = [
                'action_source' => 'website',
                'event_name' => $track_type,
                'event_time' => time(),
                'user_data' => [
                    'client_ip_address' => request()->ip(),
                    'client_user_agent' => request()->userAgent(),
                    'em' => $em,
                ]
            ];

            if($data){
                $data = (array)$data;
                $request_data = array_merge($request_data, $data);
            }

            $response = Http::post(('https://graph.facebook.com/v18.0/'. Info::Settings('fb_api', 'pixel_id') .'/events'), [
                'data' => [$request_data],
                'access_token' => Info::Settings('fb_api', 'access_token'),
            ]);

            $data = $response->json();
            if(isset($data['events_received']) && $data['events_received'] == 1){
                return 'true';
            }

            return 'false';
        }

        return 'false';
    }
}
