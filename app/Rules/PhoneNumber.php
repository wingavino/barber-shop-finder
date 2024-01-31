<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Service\Twilio\PhoneNumberLookupService;


class PhoneNumber implements Rule
{
    private $service;

    public function __construct(PhoneNumberLookupService $phoneNumberLookupService)
    {
        $this->service = $phoneNumberLookupService;
    }

    public function passes($attribute, $value): bool
    {
        return $this->service->validate($value);
    }

    public function message()
    {
        return 'The phone number has to be in the international format.';
    }

}
