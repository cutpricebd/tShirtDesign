<?php

namespace App\Repositories;

use App\Models\Provinces;
use Info;

class eShipperRepo {
    public static function create($address, $city, $state, $zip, $phone_number, $email, $shipping_weight = 1){
        $state_query = Provinces::where('name', $state)->first();
        if(!$state_query){
            return [
                'status' => false,
                'message' => 'No State Found!'
            ];
        }

        $username = env('E_SHIPPER_USERNAME');
        $password = env('E_SHIPPER_PASSWORD');
        $from_company = Info::Settings('general', 'title');
        $from_address = '272 1/2 Coxwell Ave';
        $from_city = 'Toronto';
        $from_zip = 'M4L 3B6';
        $from_mobile_number = Info::Settings('general', 'mobile_number');
        $from_email = Info::Settings('general', 'email');

        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?>
        <EShipper xmlns="http://www.eshipper.net/XMLSchema" username="'. $username .'" password="'. $password .'" version="3.0.0">
        <QuoteRequest serviceId="0" stackable="true">
            <From company="'. $from_company .'" address1="'. $from_address .'" city="'. $from_city .'" state="ON" zip="'. $from_zip .'" country="CA" phone="'. $from_mobile_number .'" email="'. $from_email .'" />

            <To company="" address1="'. $address .'" city="'. $city .'" state="'. $state_query->short_form .'" zip="'. $zip .'" country="CA" phone="'. $phone_number .'" email="'. $email .'" />

            <Packages type="Package">
                <Package length="10" width="8" height="8" weight="'. ($shipping_weight == 0 ? 1 : $shipping_weight) .'" type="Package"  description=""/>
            </Packages>
        </QuoteRequest>
        </EShipper>';

        $curl = curl_init();

        if(env('E_SHIPPER_PRODUCTION')){
            curl_setopt($curl, CURLOPT_URL,            "https://web.eshipper.com/rpc2" );
        }else{
            curl_setopt($curl, CURLOPT_URL,            "https://test.eshipper.com/rpc2" );
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_POST,           1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS,     $xmlRequest );
        curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

        $output = curl_exec($curl);
        $string = simplexml_load_string($output);
        $output_json = json_encode($string);
        $output_arr = json_decode($output_json, true);

        curl_close($curl);

        if(isset($output_arr['ErrorReply'])){
            return [
                'status' => false,
                'message' => 'Request error',
                'data' => $output_arr['ErrorReply']
            ];
        }
        return [
            'status' => true,
            'message' => 'Request success',
            'data' => $output_arr['QuoteReply']
        ];
    }

    public static function label($order){
        $state_query = Provinces::where('name', $order->shipping_state)->first();
        if(!$state_query){
            return [
                'status' => false,
                'message' => 'No State Found!'
            ];
        }

        $username = env('E_SHIPPER_USERNAME');
        $password = env('E_SHIPPER_PASSWORD');
        $from_company = Info::Settings('general', 'title');
        $from_address = '272 1/2 Coxwell Ave';
        $from_city = 'Toronto';
        $from_zip = 'M4L 3B6';
        $from_mobile_number = Info::Settings('general', 'mobile_number');
        $from_email = Info::Settings('general', 'email');

        $xmlRequest = '<?xml version="1.0" encoding="UTF-8"?>
                        <EShipper xmlns="http://www.eshipper.net/XMLSchema" username="'. $username .'" password="'. $password .'" version="3.0.0">
                            <ShippingRequest serviceId="'. $order->shipping_id .'" stackable="true" >
                                <From company="'. $from_company .'" address1="'. $from_address .'" city="'. $from_city .'" state="ON" zip="'. $from_zip .'" country="CA" phone="'. $from_mobile_number .'" email="'. $from_email .'" attention="'. $from_company .'" />

                                <To company="'. $order->shipping_full_name .'" address1="'. $order->shipping_street .'" city="'. $order->shipping_city .'" state="'. $state_query->short_form .'" zip="'. $order->shipping_post_code .'" country="CA" phone="'. $order->shipping_mobile_number .'" email="'. $order->shipping_email .'" attention="'. $order->shipping_full_name .'" />

                                <Packages type="Package">
                                    <Package length="10" width="8" height="8" weight="'. ($order->shipping_weight_kg == 0 ? 1 : $order->shipping_weight_kg) .'" type="Package"  description=""/>
                                </Packages>

                                <Payment type="3rd Party" />
                            </ShippingRequest>
                        </EShipper>';

        $curl = curl_init();

        if(env('E_SHIPPER_PRODUCTION')){
            curl_setopt($curl, CURLOPT_URL,            "https://web.eshipper.com/rpc2" );
        }else{
            curl_setopt($curl, CURLOPT_URL,            "https://test.eshipper.com/rpc2" );
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($curl, CURLOPT_POST,           1 );
        curl_setopt($curl, CURLOPT_POSTFIELDS,     $xmlRequest );
        curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));

        $output = curl_exec($curl);
        $string = simplexml_load_string($output);
        $output_json = json_encode($string);
        $output_arr = json_decode($output_json, true);

        curl_close($curl);

        if(isset($output_arr['ErrorReply'])){
            return [
                'status' => false,
                'message' => 'Request error',
                'data' => $output_arr['ErrorReply']
            ];
        }
        
        return [
            'status' => true,
            'message' => 'Request success',
            'data' => $output_arr['ShippingReply']
        ];
    }
}
