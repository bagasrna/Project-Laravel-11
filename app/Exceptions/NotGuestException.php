<?php

namespace App\Exceptions;

class NotGuestException extends BaseException
{
    public function __construct()
    {
        parent::__construct('You are already logged in.', 'NOT_GUEST', 401);
    }
}
