<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Info;
use View;

class Controller extends BaseController
{
    public function __construct() {
        $data = cache()->remember('general_settings', (60 * 60 * 24 * 90), function()
        {
            return Info::SettingsGroupKey('general');
        });
        View::share ('settings_g', $data);
        $states = cache()->remember('usaStates', (60 * 60 * 24 * 90), function()
        {
            return Info::usaStates();
        });
        View::share ('usaStates', $states);

        $provinces = cache()->remember('provinces', (60 * 60 * 24 * 90), function()
        {
            return Info::provinces();
        });
        View::share ('provinces', $provinces);
    }

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
