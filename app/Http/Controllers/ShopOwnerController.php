<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use App\Models\PendingRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class ShopOwnerController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Register Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles the registration of new users as well as their
  | validation and creation. By default this controller uses a trait to
  | provide this functionality without requiring any additional code.
  |
  */
  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = 'home';

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'name' => ['required', 'string', 'max:255'],
          'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\User
   */
  protected function create(array $data)
  {
      return User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => Hash::make($data['password']),
          'mobile' => $data['mobile'],
      ]);
  }

  public function index()
  {
    return view('home');
  }

  public function showShopPage()
  {
    $shop = DB::table('shops')->where('owner_id', '=', Auth::user()->id)->get();
    return view('shopowner/shop', ['shop' => $shop]);
  }

  public function showShopAddPage()
  {
    return view('shopowner/shop-add');
  }

  public function addShop(Request $request)
  {
    return redirect()->route('shopowner.home');
  }

  public function showRegistrationForm()
  {
    return view('auth/register-shopowner');
  }

  public function showShopOwners()
  {
    $data = DB::table('users')
      ->where('type' , '!=', 'admin')
      ->leftJoin('shops', 'shops.owner_id', '=', 'users.id')
      ->select('users.*', 'shops.id as shop_id', 'shops.name as shop_name', 'shops.address as shop_address')
      ->get();
    return view('admin/shop-owners', ['data' => $data]);
  }

  public function showShopOwnersAdd()
  {
    return view('admin/shop-owners-add');
  }

  public function addShopOwner(Request $request)
  {
    $user = User::where('email', '=', $request->email)->first();

    if (!$user) {
      $user = new User();
      $user->name = $request->name;
      $user->mobile = $request->mobile;
      $user->email = $request->email;
      //$user->avatar = $data->avatar;
      $user->save();
    }
  }

  public function showEditShopOwners($id, $type)
  {
    $user = User::where('id', '=', $id)->first();
    return view('admin/shop-owners-edit', ['user' => $user, 'type' => $type]);
  }

  //Google Authentication
  public function redirectToGoogle()
  {
    config(['services.google.redirect' => 'http://localhost:8000/register/shopowner/google/callback']);
    return Socialite::driver('google')->with(["prompt" => "select_account"])->redirect();
  }

  //Google Callback
  public function handleGoogleCallback()
  {
    config(['services.google.redirect' => 'http://localhost:8000/register/shopowner/google/callback']);
    $user = Socialite::driver('google')->user();
    $provider_id = 'google';
    $this->_registerOrLoginUser($user, $provider_id);
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
      //$user->avatar = $data->avatar;
      $user->type = 'shopowner';
      $user->save();

      // Creates Request to change Account Type to Shop Owner
      // $pending_request = new PendingRequest();
      // $pending_request->user_id = $user->id;
      // $pending_request->request_type = 'change-user-type';
      // $pending_request->change_to_user_type = 'shopowner';
      // $pending_request->save();
    }

    Auth::login($user);
  }
}
