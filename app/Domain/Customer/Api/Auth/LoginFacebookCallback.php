<?php

namespace App\Domain\Customer\Api\Auth;

use App\Domain\Customer\Actions\FindOrCreateCustomer;
use App\Domain\Customer\Data\CustomerCallbackData;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Lorisleiva\Actions\Concerns\AsController;

class LoginFacebookCallback
{
    use AsController, ApiResponse;

    public function handle(Request $request)
    {
        Log::info(1);
        Log::info($request);
        $request->merge([
            'code' => urldecode($request->code)
        ]);

        $facebookData = Socialite::driver('facebook')->stateless()->user();
        $callbackData = new CustomerCallbackData(
            $facebookData['email'],
            $facebookData['given_name'],
            $facebookData['family_name']
        );
        $customerData = FindOrCreateCustomer::run($callbackData);
        $userToken = auth()->guard('api-customer')->login($customerData);
        $data = [
            'token' => $userToken
        ];
        $this->successResponse($customerData['message'], $data);
    }
}
