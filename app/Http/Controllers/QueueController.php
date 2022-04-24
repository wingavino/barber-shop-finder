<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\User;
use Auth;

class QueueController extends Controller
{
  public function getCurrentTicket(Request $request, $queue_id)
  {
    $queue = Queue::where('id', $queue_id)->first();
    $current_ticket = Ticket::where('queue_id', $queue_id)->first();
    $user = User::where('id', $current_ticket->user_id)->first();

    if($request->ajax()){
      if (Auth::user()->type == 'user') {
        return response()->json(array('queue'=>$queue));
      }else {
        return response()->json(array('queue'=>$queue, 'current_ticket'=>$current_ticket, 'user'=>$user));
      }
    }

    return route('home');
  }
}
