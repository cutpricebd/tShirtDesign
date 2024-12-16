<?php

namespace App\Repositories;

class Generate {
    // Generate Slug
    public static function slug($string){
        return urlencode(strtolower(str_replace(' ', '-', str_replace('/', '', str_replace('- ', '', $string)))));
    }
}
