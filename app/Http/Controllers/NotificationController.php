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

        return new JsonResponse([
			'success' => true,
			'message' => 'Email sent'
		]);
      }
    }
	public function sms($no,$msg)
    {
		$apiKey = '6da0bb4a-ea5f-47a2-b364-5a6ff66162a8';
		$deviceId = '67f7e24ded94519e3b1bfe21';
		$recipients = [$no]; // Replace with actual recipient numbers
		$message = $msg;

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
    }
}
