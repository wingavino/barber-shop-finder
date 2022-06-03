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
    public function __construct($email, $queue_position)
    {
        $this->email = $email;
        $this->queue_position = $queue_position;
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
          ->markdown('emails.queue-notification-current');
          break;

        case 'on_hold':
          return $this
          ->subject('Saber Queue Update')
          ->markdown('emails.queue-notification-on-hold');
          break;

        default:
          return $this
          ->subject('Saber Queue Update')
          ->markdown('emails.queue-notification');
          break;
      }      
    }
}
