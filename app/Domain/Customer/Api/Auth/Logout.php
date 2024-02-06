<?php

namespace App\Domain\Customer\Api\Auth;

use App\Traits\ApiResponse;
use Lorisleiva\Actions\Concerns\AsController;

class Logout
{
    use AsController, ApiResponse;

    public function handle()
    {
        auth()->guard('api-admin')->logout();
        return $this->successResponse('Successfully logged out');
    }
}
