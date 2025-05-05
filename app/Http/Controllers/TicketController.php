<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Queue;
use App\Models\Shop;
use App\Models\Ticket;
use App\Models\Employee;
use App\Models\User;
use App\Mail\QueueNotification;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;
use Infobip\ApiException;
use Infobip\Model\SmsRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsMessage;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsTextContent;
use Auth;

class TicketController extends Controller
{
    public function getTicket(Request $request, $id)
    {
      $shop = Shop::where('id', '=', $id)->first();
      if ($shop) {
        if (!Auth::user()->ticket->where('queue_id', $shop->queue->id)->first()) {

          if (!$shop->queue) {
            $queue = new Queue();
            $queue->shop_id = $shop->id;
            $queue->save();
            $shop = Shop::where('id', '=', $id)->first();
          }

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

            // Send Email Notification
            $this->sendNotification(Auth::user()->email, 'next', $shop);
          }
        }
      }
      return redirect()->back();
    }

    public function cancelTicket(Request $request, $id)
    {
      $shop = Shop::where('id', '=', $id)->first();
      if (Auth::user()->ticket->where('queue_id', $shop->queue->id)->first()) {
        if (Auth::user()->ticket->where('queue_id', $shop->queue->id)->first()->queue->shop_id == $id) {
          $ticket = Auth::user()->ticket->where('queue_id', $shop->queue->id)->first();
          if ($shop->queue->current_ticket == $ticket->ticket_number) {
            $shop->queue->current_ticket = null;
          }
          $ticket->delete();
          $last_ticket = $shop->queue->ticket->last();
          if ($last_ticket) {
            $shop->queue->next_ticket = $last_ticket->ticket_number;
          }else {
            $shop->queue->next_ticket = null;
          }
          $shop->queue->save();
        }
      }
      return redirect()->back();
    }

    public function cancelCurrentTicket(Request $request)
    {
      $shop = Auth::user()->shop;

      if ($shop->queue->current_ticket) {        
        $ticket = $shop->queue->ticket->where('ticket_number', $shop->queue->current_ticket)->first();
        if ($ticket) {
          $this->sendNotification($ticket->user->email, 'cancel', $shop);
          $shop->queue->current_ticket = null;
          $ticket->delete();

          $last_ticket = $shop->queue->ticket->last();
          if ($last_ticket) {
            $shop->queue->next_ticket = $last_ticket->ticket_number;
            //$this->sendNotification($last_ticket->user->email, 'next', $shop);
          }else {
            $shop->queue->next_ticket = null;
          }
        }
        $shop->queue->save();
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

          // Send Email Notification
          $this->sendNotification($next_ticket->user->email, 'current', $shop);
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
        // Checks if the finished ticket is set as the current ticket to be serviced
        $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->current_ticket)->first();
        if ($current_ticket) {
          $this->sendNotification($current_ticket->user->email, 'finished', $shop);
          $current_ticket->delete();
          $shop->queue->current_ticket = null;
        }

        // If there is no ticket in queue to set as current ticket, this checks for tickets in the Hold Queue
        $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->next_ticket)->first();
        if ($current_ticket) {
          $shop->queue->current_ticket = $current_ticket->ticket_number;
          $this->sendNotification($current_ticket->user->email, 'current', $shop);
        }else {
          $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', true)->first();
          if ($next_ticket) {
            $next_ticket->on_hold = false;
            $shop->queue->current_ticket = $next_ticket->ticket_number;
            $next_ticket->save();
            $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->current_ticket)->first();
            // Send email notification to current ticket
            $this->sendNotification($current_ticket->user->email, 'current', $shop);
          }
        }
        // if (!$shop->queue->current_ticket = $shop->queue->next_ticket) {
        // }

        $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', false)->where('ticket_number', '!=', $shop->queue->current_ticket)->first();
        $shop->queue->next_ticket = null;

        if ($next_ticket) {
          $shop->queue->next_ticket = $next_ticket->ticket_number;

          // Send email notification to next in line
          $this->sendNotification($next_ticket->user->email, 'next', $shop);
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
          if ($current_ticket->user) {
            // Send notification to ticket placed on hold
            $this->sendNotification($current_ticket->user->email, 'on_hold', $shop);
          }
        }
        $shop->queue->current_ticket = null;
        $shop->queue->save();

      }
      return redirect()->back();
    }

    public function notifyQueue(Request $request)
    {
      if (Auth::user()->type == 'shopowner') {
        $shop = Auth::user()->shop;
      }else {
        $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
      }

      if ($shop) {
        if($shop->queue->current_ticket)
        {
          $current_ticket = Ticket::where('queue_id', $shop->queue->id)->where('ticket_number', $shop->queue->current_ticket)->first();
          $this->sendNotification($current_ticket->user->email, 'current', $shop);
        }

        $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', false)->first();
        if ($next_ticket) {
          // Send email notification to current ticket
          $this->sendNotification($next_ticket->user->email, 'next', $shop);
        }
      }
      return redirect()->back();
    }

    public function notifyNextInLine(Request $request, $id = null)
    {
      if (Auth::user()->type == 'shopowner') {
        $shop = Auth::user()->shop;
      }else {
        $shop = Employee::where('user_id', Auth::user()->id)->first()->shop;
      }

      if ($shop) {
        $next_ticket = Ticket::where('queue_id', $shop->queue->id)->where('on_hold', false)->first();
        if ($next_ticket) {
          // Send email notification to current ticket
          $this->sendNotification($next_ticket->user->email, 'next', $shop);
        }
      }
      return redirect()->back();
    }

    public static function sendNotification($email_address, $queue_position = 'next', $shop = null)
    {
      $user = User::where('email', $email_address)->first();
      if ($user->email_verified_at != null) {
        Mail::to($email_address)->send(new QueueNotification($email_address, $queue_position, $shop->name));
      }

      if ($user->mobile && $user->mobile_verified_at != null) {
        // Send SMS Notification
        // $sid = env('TWILIO_SID');
        // $token = env('TWILIO_AUTH_TOKEN');
        // $twilio_phone_number = env('TWILIO_PHONE_NUMBER');
        // $twilio = new Client($sid, $token);

        switch ($queue_position) {
          case 'current':
          $body = 'It is your turn to be serviced at '.$shop->name.'. Please try to arrive at the shop as soon as possible. ~Saber';
          break;

          case 'on_hold':
          $body = 'Your ticket has been placed on hold at '.$shop->name.'. Please try to arrive at the shop as soon as possible. ~Saber';
          break;

          case 'cancel':
          $body = 'Your ticket at '.$shop->name.' has been canceled. Please try to arrive at the shop as soon as possible next time. ~Saber';
          break;

          case 'finished':
          $body = 'Thank you for using Saber during your recent visit at '.$shop->name.'. ~Saber';
          break;

          default:
          $body = 'You are next in line to be serviced '.$shop->name.'. Please try to arrive at the shop as soon as possible. ~Saber';
          break;
        }
		
		$apiKey = '6da0bb4a-ea5f-47a2-b364-5a6ff66162a8';
		$deviceId = '67f7e24ded94519e3b1bfe21';
		$recipients = [$user->mobile]; // Replace with actual recipient numbers
		$message = $body;

		$url = "https://api.textbee.dev/api/v1/gateway/devices/{$deviceId}/send-sms";

		$data = [
			'sender' => 'TEXTBEE',
			'recipients' => $recipients,
			'message' => $message
		];

		$headers = [
			'Content-Type: application/json',
			'x-api-key: ' . $apiKey
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		curl_close($ch);
		
        /*$configuration = new Configuration(
          host: env('INFOBIP_BASE_URL'),
          apiKey: env('INFOBIP_API_KEY')
        );
        $sendSmsApi = new SmsApi(config: $configuration);

        $message = new SmsMessage(
            destinations: [
                new SmsDestination(
                    to: $user->mobile
                )
            ],
            content: new SmsTextContent(
                text: $body
            ),
            sender: 'ServiceSMS'
        );

        $request = new SmsRequest(messages: [$message]);

        try {
            $smsResponse = $sendSmsApi->sendSmsMessages($request);
        } catch (ApiException $apiException) {
            // HANDLE THE EXCEPTION
        }*/

        // $message = $twilio
        // ->messages
        // ->create(
        //   $user->mobile,
        //   [
        //     'body' => $body,
        //     'from' => $twilio_phone_number,
        //   ]
        // );
		

      }
    }
}
