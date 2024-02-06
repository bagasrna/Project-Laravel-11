<?php

namespace App\Traits;

use App\Domain\Admin\Admin;
use App\Domain\Customer\Customer;
use Illuminate\Foundation\Auth\User;

trait AuthorizationCheck
{
    function checkAuthorization($authorizationRule, User $user, $resourceOwnerId = null): bool
    {
        return  $user->can($authorizationRule) &&
            ($resourceOwnerId ? $resourceOwnerId === $user->id : true);
    }

    function checkMultiRoleAuthorization($authorizationRule, User $user, $resourceOwnerId = null): bool
    {
        if ($user instanceof Admin) {
            return $user->can($authorizationRule);
        } elseif ($user instanceof Customer) {
            return $this->checkAuthorization(
                $authorizationRule,
                $user,
                $resourceOwnerId
            );
        }
    }
}
