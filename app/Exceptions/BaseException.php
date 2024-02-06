<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;

class BaseException extends Exception
{
    use ApiResponse;
    private $errorType;

    public function __construct(string $message, string $errorType, int $errorCode)
    {
        $this->errorType = $errorType;
        parent::__construct($message, $errorCode);
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return $this->errorResponse($this->getMessage(), $this->errorType, $this->getCode());
    }

    public function report()
    {
        return false;
    }

    public function getErrorType()
    {
        return $this->errorType;
    }
}
