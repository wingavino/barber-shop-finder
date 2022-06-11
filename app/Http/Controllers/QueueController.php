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
    $current_ticket = Ticket::where('queue_id', $queue_id)->where('on_hold', false)->first();
    if ($current_ticket) {
      $user = User::where('id', $current_ticket->user_id)->first();
    }

    $on_hold_tickets = Ticket::where('queue_id', $queue_id)->where('on_hold', true)->get();
    $queue_length = Ticket::where('queue_id', $queue_id)->where('on_hold', false)->get()->count();
    if($request->ajax()){
      if ((Auth::user()->type == 'shopowner' && Auth::user()->shop->id == $queue->shop->id) OR Employee::where('user_id', Auth::user()->id)->where('shop_id', $queue->shop->id)->first()) {
        return response()->json(array('queue'=>$queue, 'current_ticket'=>$current_ticket, 'on_hold_tickets' => $on_hold_tickets, 'user'=>$user));
      }else {
        return response()->json(array('queue'=>$queue, 'queue_length' => $queue_length));
      }
    }

    return route('home');
  }

  public function openShopQueue(Request $request)
  {
    if (Auth::user()->type == 'shopowner') {
      $shop = Auth::user()->shop;
      $shop->queue->is_closed = false;
      $shop->queue->save();
    }elseif (Auth::user()->type == 'user') {
      $employee = Employee::where('user_id', Auth::user()->id)->first();
      $shop = Shop::where('id', $employee->shop_id)->first();
      $shop->queue->is_closed = false;
      $shop->queue->save();
    }
    return back();
  }

  public function closeShopQueue(Request $request)
  {
    if (Auth::user()->type == 'shopowner') {
      $shop = Auth::user()->shop;
      $shop->queue->is_closed = true;
      $shop->queue->save();
    }elseif (Auth::user()->type == 'user') {
      $employee = Employee::where('user_id', Auth::user()->id)->first();
      $shop = Shop::where('id', $employee->shop_id)->first();
      $shop->queue->is_closed = true;
      $shop->queue->save();
    }
    return back();
  }
}
