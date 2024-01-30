<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\Twilio\PhoneNumberLookupService;


class PhoneNumberController extends Controller
{
    private $service;

    public function __construct(PhoneNumberLookupService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request)
    {
        $lookupService = new PhoneNumberLookupService(
            env('TWILIO_SID'), 
            env('TWILIO_AUTH_TOKEN')
        );

        $validated = $request->validate([
            'phone_number' => [
                'required', 
                'string', 
                new PhoneNumber($this->service)
            ],
        ]);        
    }

}
