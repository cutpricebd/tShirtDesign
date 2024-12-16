<?php

//namespace App\Repositories;

use App\Models\Settings;

class Info {
    // Site Info
    public static function Settings($group, $name){
        $q = Settings::where('group', $group)->where('name', $name)->first();

        // Null Check
        if ($q){
            return $q->value;
        }else{
            return null;
        }
    }

    // Site Info by Group
    public static function SettingsGroup($group){
        return Settings::where('group', $group)->get();
    }

    // Site Info by Keys
    public static function SettingsGroupKey($group = 'general'){
        $query = Settings::where('group', $group)->get();

        // Generate Output
        $output = [];
        foreach($query as $data){
            if($data->name == 'logo' || $data->name == 'footer_logo' || $data->name == 'favicon' || $data->name == 'og_image' || $data->name == 'pm_image' || $data->name == 'homepage_banner_image'){
                $output[$data->name] = asset('uploads/info/' . $data->value);
            }else{
                $output[$data->name] = $data->value;
            }
        }

        // // Return Default
        // foreach($keys as $key){
        //     if(!isset($output[$key])){
        //         $output[$key] = null;
        //     }
        // }

        return $output;
    }

    // Tax Calculation
    public static function tax($amount){
        $tax = (new static)->Settings('general', 'tax');
        $tax_type = (new static)->Settings('general', 'tax_type');

        if($tax_type == 'Percent'){
            return ($amount * $tax) / 100;
        }

        return $tax;
    }
    public static function provinces(){
        $list = [
            'British Columbia',
            'Alberta',
            'Saskatchewan',
            'Manitoba',
            'Ontario',
            'Quebec',
            'New Brunswick',
            'Nova Scotia',
            'Prince Edward Island',
            'Newfoundland and Labrador',
            'Yukon',
            'Northwest Territories',
            'Nunavut',
        ];

        asort($list);

        return $list;
    }

    public static function usaStates(){
        $list = [
            'Alabama',
            'Alaska',
            'Arizona',
            'Arkansas',
            'California',
            'Colorado',
            'Connecticut',
            'Delaware',
            'District Of Columbia',
            'Florida',
            'Georgia',
            'Hawaii',
            'Idaho',
            'Illinois',
            'Indiana',
            'Iowa',
            'Kansas',
            'Kentucky',
            'Louisiana',
            'Maine',
            'Maryland',
            'Massachusetts',
            'Michigan',
            'Minnesota',
            'Mississippi',
            'Missouri',
            'Montana',
            'Nebraska',
            'Nevada',
            'New Hampshire',
            'New Jersey',
            'New Mexico',
            'New York',
            'North Carolina',
            'North Dakota',
            'Ohio',
            'Oklahoma',
            'Oregon',
            'Pennsylvania',
            'Rhode Island',
            'South Carolina',
            'South Dakota',
            'Tennessee',
            'Texas',
            'Utah',
            'Vermont',
            'Virginia',
            'Washington',
            'West Virginia',
            'Wisconsin',
            'Wyoming',
        ];

        asort($list);

        return $list;
    }
}

function settings($group, $name){
    return Info::Settings($group, $name);
}

