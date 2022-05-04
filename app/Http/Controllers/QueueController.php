<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Employee;
use Auth;

class QueueController extends Controller
{
  public function getCurrentTicket(Request $request, $queue_id)
  {
    $queue = Queue::where('id', $queue_id)->first();
    $current_ticket = Ticket::where('queue_id', $queue_id)->first();
    if ($current_ticket) {
      $user = User::where('id', $current_ticket->user_id)->first();
    }

    if($request->ajax()){
      if ((Auth::user()->type == 'shopowner' && Auth::user()->shop->id == $queue->shop->id) OR Employee::where('user_id', Auth::user()->id)->where('shop_id', $queue->shop->id)->first()) {
        return response()->json(array('queue'=>$queue, 'current_ticket'=>$current_ticket, 'user'=>$user));
      }else {
        return response()->json(array('queue'=>$queue));
      }
    }

    return route('home');
  }
}
