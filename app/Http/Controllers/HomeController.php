<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    // In your controller method
public function show()
    {
        $isSearchOpen = false; // Set this to true or false based on your default state
        return view('your-view', compact('isSearchOpen'));
    }


    public function fourcards() {

        $data['fourcardspage'] =  DB::table('fourcardspage as fourcards')
        ->select('fourcards.*')
        ->get();
        


        return view('front.homepage', $data);
        
    }

}
