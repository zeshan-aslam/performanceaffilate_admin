<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use DateTime;
use Illuminate\Support\Carbon;
use App\Activity;
use App\Utilities\SiteHelper;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    // protected $redirectTo = RouteServiceProvider::HOME;


    protected function authenticated($request, $user)
    {
        date_default_timezone_set('Europe/London');
        $res = DB::table('users')
            ->where('id', $user->id)
            ->limit(1)
            ->update([
                'ip' => $request->ip(),
                'lastlogin' => date("Y-m-d h:i:s", time()),
            ]);

        $activity = new Activity();
        $activity->url =  url()->current();
        $activity->ip =  SiteHelper::getIp();
        $activity->user_id = Auth::id();
        $activity->type = 'Auth';
        $activity->country = ' ';
        $activity->description = "User Logged in";
        $activity->save();

        if ($user->hasRole('superadministrator')) {
            return redirect()->intended('/admin');
        } elseif ($user->hasRole('administrator')) {
            return redirect()->intended('/user');
        } elseif ($user->hasRole('user')) {
            return redirect()->intended('/user');
        } else {
            return redirect()->intended('/home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // public function username(){
    //     return 'email';
    // }
}
