<?php

namespace App\Domain\Admin\Api\Auth;

use App\Domain\Admin\Admin;
use App\Domain\Admin\Api\AdminInfo;
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
        $user = Admin::where('email', $request->email)->first();
        if (!$user) {
            throw ValidationException::withMessages(['email' => ['Credentials doesn\'t match with our records']]);
        }

        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['Credential or password is not matched']]);
        }
        $userToken = auth()->guard('api-admin')->login($user);
        $request->merge([
            'jwt_token' => $userToken
        ]);

        return $this->successResponse(
            'You are successfully logged in',
            AdminInfo::run($user, $request)
        );
    }
}
