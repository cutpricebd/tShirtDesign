<?php

namespace App\Http\Controllers;

use App\Models\PreUser;
use App\Models\User;
use App\Notifications\EmailVerificationMail;
use App\Repositories\CartRepo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('redirect', 'emailVerifyCheck');
    }

    // Login
    public function login()
    {
        return view('front.auth.login');
    }

    public function register()
    {
        return view('front.auth.register');
    }

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
        ], [
            'regex' => 'Please insert strong password. Example: AAbb!!33'
        ]);

        $user = new PreUser;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->token = Hash::make(time());

        $user->save();

        $user->notify(new EmailVerificationMail($user->id));

        return redirect()->route('homepage')->with('success-alert2', 'Email verification link sent successful.');
    }

    public function emailVerify($id)
    {
        $user = PreUser::findOrFail($id);

        if($user->email_verified_at){
            return redirect()->route('login')->with('error-alert', 'Your email has already verified!');
        }

        return view('front.auth.emailVerify', compact('user'));
    }

    public function resendVerifyLink($id)
    {
        $user = PreUser::findOrFail($id);

        if($user->email_verified_at){
            return redirect()->route('login')->with('error-alert', 'Your email has already verified!');
        }

        $user->notify(new EmailVerificationMail($id));

        return redirect()->back()->with('success-alert', 'Email verification link send successful.');
    }

    public function emailVerifyCheck($id)
    {
        $session_id = Session::getId();

        $pre_user = PreUser::findOrFail($id);

        if($pre_user->email_verified_at){
            return redirect()->route('login')->with('error-alert', 'Your email has already verified');
        }

        $user = new User;
        $user->last_name = $pre_user->name;
        $user->email = $pre_user->email;
        $user->mobile_number = $pre_user->mobile_number;
        $user->password = $pre_user->password;
        $user->country = 'Canada';
        $user->save();

        // Delete History
        DB::table('pre_users')->where('email', $pre_user->email)->update([
            'email_verified_at' => Carbon::now(),
            'user_id' => $user->id
        ]);
        // DB::table('pre_users')->where('mobile_number', $pre_user->mobile_number)->delete();

        Auth::login($user);

        CartRepo::updateRelation($session_id);

        return redirect()->route('userDashboard');
    }

    public function redirect()
    {
        if (auth()->check()) {
            if (auth()->user()->type == 'admin') {
                return redirect()->intended(route('dashboard'));
            }
            return redirect()->intended(route('userDashboard'));
        }

        return redirect()->route('homepage');
    }
}
