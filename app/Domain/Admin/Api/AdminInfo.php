<?php

namespace App\Domain\Admin\Api;

use App\Domain\Admin\Admin;
use App\Domain\Admin\Resources\AdminResource;
use App\Traits\ApiResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;
use Lorisleiva\Actions\Concerns\AsObject;

class AdminInfo
{
    use AsObject, AsController, ApiResponse;

    public function handle(Admin $customer, ActionRequest $request)
    {
        return (new AdminResource($customer))->toArray($request);
    }

    public function asController(ActionRequest $request)
    {
        return $this->successResponse(
            'info',
            new AdminResource($request->user())
        );
    }
}
