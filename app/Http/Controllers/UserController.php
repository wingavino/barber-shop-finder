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
use Infobip\Configuration;
use Infobip\Api\TfaApi;
use Infobip\Model\TfaApplicationRequest;
use Infobip\Model\TfaCreateMessageRequest;
use Infobip\Model\TfaPinType;
use Infobip\Model\TfaStartAuthenticationRequest;
use Infobip\Model\TfaVerifyPinRequest;
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

    public function sendMobileOTP()
    {
      /*$sms_active = env('SMS_ACTIVE');

      if(!$sms_active)
      {
        return back();
      }*/

      //$mobile = Auth::user()->mobile;

      /*$configuration = new Configuration(
        host: env('INFOBIP_BASE_URL'),
        apiKey: env('INFOBIP_API_KEY')
      );
      $tfaApi = new TfaApi(config: $configuration);
      $appId = env('INFOBIP_2FA_APPID');
      $messageId = env('INFOBIP_2FA_MESSAGEID');

      $sendCodeResponse = $tfaApi
        ->sendTfaPinCodeOverSms(
          new TfaStartAuthenticationRequest(
              applicationId: $appId,
              messageId: $messageId,
              to: $mobile,
              from: 'ServiceSMS',
          )
      );

      $isSuccessful = $sendCodeResponse->getSmsStatus() === "MESSAGE_SENT";
      $pinId = $sendCodeResponse->getPinId();*/
		//$pinId = "122";
		//return redirect()->route('verify.mobile')->with(['message' => 'Code sent. Please check your phone.', 'pinId' => $pinId]);
		
		Log::info('Controller method reached!');
		return 'Check log file.';
	
    }

    public function verifyMobile(Request $request, $pinId)
    {
      $data = $request->validate([
        'verification_code' => ['required', 'numeric'],
        'mobile' => ['required', 'string'],
      ]);

      $sms_active = env('SMS_ACTIVE');

      if(!$sms_active)
      {
        return back();
      }

      $configuration = new Configuration(
        host: env('INFOBIP_BASE_URL'),
        apiKey: env('INFOBIP_API_KEY')
      );      
      $tfaApi = new TfaApi(config: $configuration);

      $verifyResponse = $tfaApi->verifyTfaPhoneNumber($pinId, new TfaVerifyPinRequest(pin: $data['verification_code']));
      $verified = $verifyResponse->getVerified();

      if ($verified) {
        $user = tap(User::where('mobile', $data['mobile']))->update(['mobile_verified_at' => Carbon::now()]);
        return redirect()->route('home')->with(['message' => 'Phone number verified']);
      }

      return back()->with(['mobile' => $data['mobile'], 'error' => 'Invalid code entered']);
    }

    public function createTfaMessageTemplate()
    {
      $configuration = new Configuration(
        host: env('INFOBIP_BASE_URL'),
        apiKey: env('INFOBIP_API_KEY')
      );      
      $tfaApi = new TfaApi(config: $configuration);

      $appId = env('INFOBIP_2FA_APPID');

      $tfaMessageTemplate = $tfaApi
        ->createTfaMessageTemplate(
          $appId,
          new TfaCreateMessageRequest(
              messageText: 'Your pin is {{pin}}',
              pinType: TfaPinType::NUMERIC,
              pinLength: 4
          )
      );
      $messageId = $tfaMessageTemplate->getMessageId();

      return redirect()->route('home', ['messageId' => $messageId]);
    }
}
