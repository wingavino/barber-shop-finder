<?php

namespace App\Service\Twilio;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class PhoneNumberLookupService
{
    private $client;

    public function __construct(string $authSID, string $authToken)
    {
        $this->client = new Client($authSID, $authToken);
    }

    public function validate(string $phoneNumber): bool
    {
        if (empty($phoneNumber)) {
            return false;
        }

        try {
            $this->client
                ->lookups
                ->v1
                ->phoneNumbers($phoneNumber)
                ->fetch();
        } catch (TwilioException $e) {
            return false;
        }

    return true;
    }
}
