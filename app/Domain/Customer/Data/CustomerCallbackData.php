<?php

namespace App\Domain\Customer\Data;

use Spatie\LaravelData\Data;

class CustomerCallbackData extends Data
{
    public function __construct(
        public string $email,
        public string $givenName,
        public string $familyName,
    ) {
    }
}
