<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\PendingRequest;
use Carbon\Carbon;
use Auth;

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
        $this->middleware('guest')->except('logout');
    }

    //Overrides default authenticated() function
    protected function authenticated(Request $request, $user)
    {
      if ($user->banned) {
        Auth::logout();

        return back()->withErrors(['loginError'=>'Account is currently banned. You may contact saber.shop.finder@gmail.com if you have any questions.']);
      }

      return redirect()->intended($this->redirectPath());
    }

    //Google Authentication
    public function redirectToGoogle()
    {
      return Socialite::driver('google')->with(["prompt" => "select_account"])->stateless()->redirect();
    }

    //Google Callback
    public function handleGoogleCallback()
    {
      $user = Socialite::driver('google')->stateless()->user();
      $provider_id = 'google';
      $user = $this->_registerOrLoginUser($user, $provider_id);

      if ($user->banned) {
        Auth::logout();

        return redirect()->route('login')->withErrors(['loginError'=>'Account is currently banned. You may contact saber.shop.finder@gmail.com if you have any questions.']);
      }
      
      return redirect()->route('home');
    }

    protected function _registerOrLoginUser($data, $provider_id)
    {
      $user = User::where('email', '=', $data->email)->first();

      if (!$user) {
        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->provider_id = $provider_id;
        $user->email_verified_at = Carbon::now();
        //$user->avatar = $data->avatar;
        $user->save();
      }

      Auth::login($user);

      return $user;
    }
}
