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

class PendingRequestController extends Controller
{
  public function addPendingRequest($id, $request_type, $user_type)
  {
    $pending_request = PendingRequest::where('user_id', '=', $id)->
                                        where('request_type', '=', $request_type)->
                                        first();
	 
	 $user = User::where('id', $pending_request->user_id)->first(); 
	 
    if (!$pending_request) {
      $pending_request = new PendingRequest();
      if ($request_type == 'change-user-type') {
        $pending_request->user_id = $id;
        $pending_request->request_type = $request_type;
        $pending_request->change_to_user_type = $user_type;
        $pending_request->save();
		
		
      }
    }
		$notif = new NotificationController();
		$msg = "Your Request to $request_type has been Approved";
		$notif->sms($user->mobile,$msg);
		
    return redirect()->back();
  }

  public function rejectPendingRequest(Request $request, $request_type, $id)
  {
    $pending_request = PendingRequest::where('id', $id)->first();
    if($request_type == 'change-user-type')
    {
      $user = User::where('id', $pending_request->user_id)->first(); 
      if($user->shop)
      {
        $shop = $user->shop;
        $shop->hidden = true;
        $shop->save();
      }      
    }

    if($request_type == 'add-new-shop') {
      $shop = Shop::where('id', $pending_request->shop_id)->first();
      $shop->hidden = true;
      $shop->save();
    }
    $pending_request->approved = false;
    $pending_request->rejected = true;
    $pending_request->save();

    return redirect()->route('admin.pending-requests');
  }
}
