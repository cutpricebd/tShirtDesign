<?php

namespace App\Repositories;

use Info;
use Illuminate\Support\Facades\Http;

class PaperflyRepo {
    public static function successRate($mobile_number){
        try{
            $basicAuth = "m10572:Cutpricebd";

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($basicAuth)
            ])->post('https://go-app.paperfly.com.bd/merchant/api/react/smart-check/list.php', [
                'search_text' => $mobile_number,
                'limit' => 50,
                'page' => 1,
            ]);

            $data = $response->json();
            if(isset($data['records'][0]['delivered']) && isset($data['records'][0]['returned'])){
                return [
                    'status' => true,
                    'total' => ($data['records'][0]['delivered'] + $data['records'][0]['returned']),
                    'delivered' => $data['records'][0]['delivered'],
                    'returned' => $data['records'][0]['returned']
                ];
            }else{
                return [
                    'status' => true,
                    'total' => 0,
                    'delivered' => 0,
                    'returned' => 0
                ];
            }
        }catch(\Exception $e){
            return [
                'status' => false
            ];
        }
    }
}
