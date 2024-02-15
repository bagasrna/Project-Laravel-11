<?php

namespace App\Domain\Customer\Actions;

use App\Domain\Customer\Customer;
use App\Domain\Customer\Data\CustomerCallbackData;
use App\Domain\Customer\Exceptions\SocialTypeException;
use App\Enums\RoleType;
use Lorisleiva\Actions\Concerns\AsObject;

class FindOrCreateCustomer
{
    use AsObject;

    public function handle(CustomerCallbackData $callbackData)
    {
        $customer = Customer::where('email', $callbackData->email)->first();

        if (!$customer) {
            $customer = Customer::create([
                'name' => $callbackData->givenName . $callbackData->familyName,
                'email' => $callbackData->email,
            ]);
            $customer->assignRole(RoleType::CUSTOMER);
            return [
                'customer' => $customer,
                'message' => 'User successfully registered, please continue the registration.'
            ];
        }

        return [
            'customer' => $customer,
            'message' => 'User successfully logged in.'
        ];
    }
}
