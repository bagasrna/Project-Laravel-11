<?php

namespace App\Domain\Customer\Api\Auth;

use App\Domain\Customer\Customer;
use App\Domain\Customer\Api\CustomerInfo;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsController;

class Login
{
    use AsController, ApiResponse;

    public function rules(): array
    {
        return [
            'email' => 'required',
            'password' => 'required'
        ];
    }

    public function handle(ActionRequest $request)
    {
        $user = Customer::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages(['email' => ['Credentials doesn\'t match with our records']]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Credential or password is not matched']]);
        }
        $userToken = auth()->guard('api-customer')->login($user);
        $request->merge([
            'jwt_token' => $userToken
        ]);

        return $this->successResponse(
            'You are successfully logged in',
            CustomerInfo::run($user, $request)
        );
    }
}
