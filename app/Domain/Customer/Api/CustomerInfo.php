<?php

namespace App\Domain\Customer\Api;

use App\Domain\Customer\Customer;
use App\Domain\Customer\Resources\CustomerResource;
use App\Traits\ApiResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;
use Lorisleiva\Actions\Concerns\AsObject;

class CustomerInfo
{
    use AsObject, AsController, ApiResponse;

    public function handle(Customer $customer, ActionRequest $request)
    {
        return (new CustomerResource($customer))->toArray($request);
    }

    public function asController(ActionRequest $request)
    {
        return $this->successResponse(
            'info',
            new CustomerResource($request->user())
        );
    }
}
