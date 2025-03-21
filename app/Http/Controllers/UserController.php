<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PendingRequest;
use App\Models\Shop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Twilio\Rest\Client;
use Auth;

class UserController extends Controller
{
    // User
    public function index(User $user)
    {
        return view('user');
    }

    public function showUsers()
    {
      $data = User::where('type', '!=', 'admin')->paginate(25);
      return view('admin/users', ['data' => $data]);
    }

    public function showUserEdit(User $user)
    {
      return view('user-edit');
    }

    public function showUserEditPassword(User $user)
    {
      return view('user-edit-password');
    }

    public function editUser(Request $request)
    {
      $user = Auth::user();
      $user->name = $request->name;
      $user->mobile = $request->mobile;
      // $user->email = $request->email;
      $user->save();
      return redirect('user');
    }

    public function editUserPassword(Request $request)
    {
      $user = Auth::user();
      $validated = $request->validate([
        'oldpassword' => 'nullable|current_password',
        'password' => 'required|string|min:8|confirmed'
      ]);
      $user->password = Hash::make($request->password);
      $user->save();
      return redirect('user');
    }

    public function changeUserType($id, $type, Request $request)
    {
      $user = User::where('id', '=', $id)->first();
      if ($user) {
        $user->type = $type;
        $user->save();
        $pending_request = PendingRequest::where('user_id', '=', $user->id)->where('request_type', 'change-user-type')->first();
        if ($pending_request) {
          $pending_request->rejected = false;
          $pending_request->approved = true;
          $pending_request->save();
          return redirect()->route('admin.pending-requests');
        }
      }
      return redirect()->route('admin.shopowners');
    }

    public function banUser($id, $ban, Request $request)
    {
      $user = User::where('id', '=', $id)->first();
      if ($user) {
        $user->banned = $ban;    
        $user->save();

        $shop = $user->shop;
        if($shop){
          $shop->hidden = $ban;
          $shop->save();
        }
      }
      return redirect()->route('admin.users');
    }

    public function verifyMobile(Request $request)
    {
      $data = $request->validate([
        'verification_code' => ['required', 'numeric'],
        'mobile' => ['required', 'string'],
      ]);

      $token = env('TWILIO_AUTH_TOKEN');
      $twilio_sid = env('TWILIO_SID');
      $twilio_verify_sid = env('TWILIO_VERIFY_SID');
      $twilio = new Client($twilio_sid, $token);
      $verification = $twilio->verify->v2->services($twilio_verify_sid)
        ->verificationChecks
        ->create($data['verification_code'], array('to' => $data['mobile']));
      if ($verification->valid) {
        $user = tap(User::where('mobile', $data['mobile']))->update(['mobile_verified_at' => Carbon::now()]);
        return redirect()->route('home')->with(['message' => 'Phone number verified']);
      }
      return back()->with(['mobile' => $data['mobile'], 'error' => 'Invalid code entered']);
    }

    public function sendMobileOTP()
    {
      // $data = $request->validate([
      //   'mobile' => ['required', 'string'],
      // ]);

      $twilio_active = env('TWILIO_ACTIVE');

      if(!$twilio_active)
      {
        return back();
      }

      $mobile = Auth::user()->mobile;

      $token = env('TWILIO_AUTH_TOKEN');
      $twilio_sid = env('TWILIO_SID');
      $twilio_verify_sid = env('TWILIO_VERIFY_SID');
      $twilio = new Client($twilio_sid, $token);

      $verification = $twilio->verify->v2->services($twilio_verify_sid)
        ->verifications
        ->create($mobile, 'sms');

      return redirect()->route('verify.mobile')->with(['message' => 'Code sent. Please check your phone.']);
    }
}
