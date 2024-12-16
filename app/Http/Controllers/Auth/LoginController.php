<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Repositories\CartRepo;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    public function login(Request $request)
    {
        // $request->validate([
        //     'email' => 'required',
        //     'password' => 'required'
        // ]);
        $session_id = Session::getId();

        $auth = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        if (!$auth) {
            return redirect()->back()->withInput()->with('error-alert', 'Email or Password Wrong!');
        }

        CartRepo::updateRelation($session_id);

        if($request->type == 'checkout'){
            return redirect()->route('cart');
        }else{
            if (auth()->user()->type == 'admin') {
                return redirect()->intended(route('dashboard'));
            } else {
                return redirect()->intended(route('auth.dashboard'));
            }
        }
    }

    public function logout(){
        $user_id = auth()->user()->id;

        Auth::logout();
        CartRepo::updateRelation($user_id, 'logout');

        return redirect()->route('homepage');
    }
}
