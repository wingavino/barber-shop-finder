<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Shop;
use App\Models\Ticket;
use Auth;

class QueueController extends Controller
{
  public function getCurrentTicket(Request $request, $queue_id)
  {
    $queue = Queue::where('id', $queue_id)->first();
    $current_ticket = $queue->current_ticket;

    if($request->ajax()){
       return response()->json(array('current_ticket'=>$current_ticket));
    }

    return route('home');
  }
}
