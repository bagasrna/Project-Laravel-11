<?php

namespace App\Domain\Customer\Api\Auth;

use App\Traits\ApiResponse;
use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsController;

class LoginFacebook
{
    use AsController, ApiResponse;

    public function handle()
    {
        return $this->successResponse(
            'Facebook Sign-In Link',
            Socialite::driver('facebook')->stateless()->redirect()->getTargetUrl()
        );
    }
}