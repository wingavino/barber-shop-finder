<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\Employee;
use Auth;

class TicketController extends Controller
{
    public function getTicket(Request $request, $id)
    {
      $shop = Shop::where('id', '=', $id)->first();
      if (!Auth::user()->ticket) {
        $last_ticket = $shop->queue->ticket->last();
        $ticket = new Ticket;
        $ticket->queue_id = $shop->queue->id;
        $ticket->user_id = Auth::user()->id;
        $ticket->ticket_number = 1;
        if ($last_ticket) {
          $ticket->ticket_number = $last_ticket->ticket_number + 1;
        }
        $ticket->save();

        if (!$shop->queue->next_ticket) {
          $shop->queue->next_ticket = $ticket->ticket_number;
          $shop->queue->save();
        }
      }
      return redirect()->back();
    }

    public function cancelTicket(Request $request, $id)
    {
      $shop = Shop::where('id', '=', $id)->first();
      if (Auth::user()->ticket) {
        if (Auth::user()->ticket->queue->shop_id == $id) {
          $ticket = Auth::user()->ticket;
          $ticket->delete();
        }
      }
      return redirect()->back();
    }

    public function setNextTicket(Request $request, $id)
    {
      if (Auth::user()->type == 'shopowner') {
        $shop = Auth::user()->shop;
      }else {
        $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
      }

      if ($shop) {
        $next_ticket = Ticket::where('id', $id)->first();
        if ($next_ticket) {
          $shop->queue->current_ticket = $next_ticket->ticket_number;
          $next_ticket->on_hold = false;
          $next_ticket->save();
        }
        $shop->queue->save();
      }
      return redirect()->back();
    }

    public function setNextTicketFromOnHold(Request $request)
    {
      if (Auth::user()->type == 'shopowner') {
        $shop = Auth::user()->shop;
      }else {
        $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
      }

      if ($shop) {
        $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->current_ticket)->first();
        if ($current_ticket) {
          $current_ticket->delete();
        }
        $shop->queue->current_ticket = null;

        $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', true)->first();
        if ($next_ticket) {
          $shop->queue->current_ticket = $next_ticket->ticket_number;
          $next_ticket->on_hold = false;
          $next_ticket->save();
        }
        $shop->queue->save();
      }
      return redirect()->back();
    }

    public function finishCurrentTicket(Request $request)
    {
      if (Auth::user()->type == 'shopowner') {
        $shop = Auth::user()->shop;
      }else {
        $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
      }

      if ($shop) {
        $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->current_ticket)->first();
        if ($current_ticket) {
          $current_ticket->delete();
        }

        if (!$shop->queue->current_ticket = $shop->queue->next_ticket) {
          $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', true)->first();
          if ($next_ticket) {
            $shop->queue->current_ticket = $next_ticket->ticket_number;
            $next_ticket->on_hold = false;
            $next_ticket->save();
          }
        }

        $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', false)->where('ticket_number', '!=', $shop->queue->current_ticket)->first();
        $shop->queue->next_ticket = null;

        if ($next_ticket) {
          $shop->queue->next_ticket = $next_ticket->ticket_number;
        }

        $shop->queue->save();
      }
      return redirect()->back();
    }

    public function holdCurrentTicket(Request $request)
    {
      if (Auth::user()->type == 'shopowner') {
        $shop = Auth::user()->shop;
      }else {
        $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
      }

      if ($shop) {
        $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->current_ticket)->first();
        if ($current_ticket) {
          $current_ticket->on_hold = true;
          $current_ticket->save();
        }
        $shop->queue->current_ticket = null;
        $shop->queue->save();
      }
      return redirect()->back();
    }
}
