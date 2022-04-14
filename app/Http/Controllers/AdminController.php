<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Shop;
use App\Models\PendingRequest;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class AdminController extends Controller
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
  protected $redirectTo = 'admin/admins';

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
          'type' => 'admin',
      ]);
  }

  public function index()
  {
    return view('admin/home');
  }

  public function admins()
  {
    $data = DB::table('users')->where('type', '=', 'admin')->get();
    return view('admin/admins', ['data' => $data]);
  }

  public function showAddAdmin()
  {
    return view('admin/admins-add');
  }

  public function addAdmin(Request $request)
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

  public function deleteAdmin($id, Request $request)
  {
    $admin = User::where('id', '=', $id)->where('type', '=', 'admin')->first();
    if ($admin) {
      $admin->delete();
    }
    return redirect()->route('admin.admins');
  }

  public function showPendingRequestsPage()
  {
    $data = DB::table('pending_requests')
                ->leftJoin('users', 'user_id', '=', 'users.id')
                ->leftJoin('shops', 'shop_id', '=', 'shops.id')
                ->select('pending_requests.*', 'users.name as name', 'users.email as email', 'users.email_verified_at as email_verified_at', 'users.mobile as mobile', 'users.type as user_type', 'shops.name as shop_name')
                ->where('pending_requests.approved', false)
                ->get();
    return view('admin/pending-requests', ['data' => $data]);
  }
}
