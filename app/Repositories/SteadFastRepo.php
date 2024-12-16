<?php

namespace App\Repositories;

use Info;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Facades\Log;

class SteadFastRepo {
    // https://docs.google.com/document/d/e/2PACX-1vTi0sTyR353xu1AK0nR8E_WKe5onCkUXGEf8ch8uoJy9qxGfgGnboSIkNosjQ0OOdXkJhgGuAsWxnIh/pub

    public static function createOrder($invoice, $recipient_name, $recipient_phone, $recipient_address, $cod_amount, $note = null){
        $request = array();

        $request['invoice'] = 'in-' . $invoice;
        $request['recipient_name'] = $recipient_name;
        $request['recipient_phone'] = $recipient_phone;
        $request['recipient_address'] = $recipient_address;
        $request['cod_amount'] = $cod_amount;
        $request['note'] = $note;

        return (new static)->curl($request, 'create_order', 'POST');
    }

    public static function status($tracking_code){
        $uel = 'status_by_trackingcode/' . $tracking_code;

        return (new static)->curl([], $uel, 'GET');
    }

    public static function curl($request, $url, $request_method){
        $courier_config = Info::SettingsGroupKey('courier');

        $body = json_encode($request);

        $full_url = 'https://portal.steadfast.com.bd/api/v1/' . $url;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL,            $full_url );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        if($request_method == 'POST'){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }else{
            curl_setopt($curl, CURLOPT_HTTPGET, 1);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Api-Key: ' . ($courier_config['steadfast_api_key'] ?? ''),
            'Secret-Key: ' . ($courier_config['steadfast_secret_key'] ?? ''),
        ));

        $output = curl_exec($curl);

        $error = curl_error($curl);

        $output_arr = json_decode($output, true);

        curl_close($curl);

        return $output_arr;
    }

    public static function successRate($mobile_number){
        try{
            if (Storage::exists('stead-fast-cookie.txt')) {
                // Retrieve the serialized CookieJar from the file
                $serializedCookieJar = Storage::get('stead-fast-cookie.txt');
                // Unserialize the CookieJar
                $cookieJar = unserialize($serializedCookieJar);
            }else{
                $cookieJar = new CookieJar();
            }

            $response = Http::withOptions(['cookies' => $cookieJar])->get('https://steadfast.com.bd/user/frauds/check/' . $mobile_number);
            $response_arr = (array)$response->json();

            if(count($response_arr) != 3){
                $cookieJar = new CookieJar();

                // URL of the login page
                $url = 'https://steadfast.com.bd/login';

                // Fetch the login page HTML
                $response = Http::withOptions(['cookies' => $cookieJar])->get($url);

                // Extract CSRF token from the HTML (if present)
                $html = $response->body();
                $dom = new \DOMDocument();
                @$dom->loadHTML($html);

                // Get all input elements
                $inputElements = $dom->getElementsByTagName('input');

                $csrfToken = '';
                // Loop through input elements to find CSRF token input
                foreach ($inputElements as $input) {
                    if ($input->getAttribute('name') === '_token') {
                        $csrfToken = $input->getAttribute('value');
                        break;
                    }
                }

                // Prepare form data
                $formData = array(
                    '_token' => $csrfToken, // CSRF token
                    'email' => 'cutpricebd@gmail.com', // Your email
                    'password' => 'Bangladesh1971' // Your password
                );

                // Submit the form
                $response = Http::withOptions(['cookies' => $cookieJar])->post($url, $formData);

                // Serialize the CookieJar
                $serializedCookieJar = serialize($cookieJar);

                // Store the serialized CookieJar in the file
                Storage::put('stead-fast-cookie.txt', $serializedCookieJar);

                $response = Http::withOptions(['cookies' => $cookieJar])->get('https://steadfast.com.bd/user/frauds/check/' . $mobile_number);
                $response_arr = (array)$response->json();
            }

            if(count($response_arr) == 3){
                return [
                    'status' => true,
                    'total_delivery' => $response_arr[0] + $response_arr[1],
                    'total_delivered' => $response_arr[0],
                    'total_cancelled' => $response_arr[1],
                ];
            }

            return [
                'status' => false
            ];
        }catch(\Exception $e){
            Log::error('An error occurred: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            return [
                'status' => false
            ];
        }
    }
}
