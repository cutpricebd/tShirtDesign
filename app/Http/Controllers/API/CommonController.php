<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    // Users
    public function users(Request $request){
        if($request->type){
            $type = $request->type;
        }else{
            $type = 'user';
        }

        $users = User::where('type', $type)->active()->get();

        return response()->json([
            'data' => $users
        ]);
    }
}
