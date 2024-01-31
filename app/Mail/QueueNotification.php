<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueueNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $queue_position, $shop_name)
    {
        $this->email = $email;
        $this->queue_position = $queue_position;
        $this->shop_name = $shop_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      switch ($this->queue_position) {
        case 'current':
          return $this
          ->subject('Saber Queue Update')
          ->markdown('emails.queue-notification-current')
          ->with([
              'shop_name' => $this->shop_name,
          ]);
          break;

        case 'on_hold':
          return $this
          ->subject('Saber Queue Update')
          ->markdown('emails.queue-notification-on-hold')
          ->with([
              'shop_name' => $this->shop_name,
          ]);
          break;

        default:
          return $this
          ->subject('Saber Queue Update')
          ->markdown('emails.queue-notification')
          ->with([
              'shop_name' => $this->shop_name,
          ]);
          break;
      }
    }
}
