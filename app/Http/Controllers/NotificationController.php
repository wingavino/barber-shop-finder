<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\QueueNotification;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function email($email_address)
    {
      if ($email_address) {
        Mail::to($email_address)->send(new QueueNotification($email_address));

        return new JsonResponse(
          [
            'success': => true,
            'message': => 'Email sent'
          ]
        );
      }
    }
}
