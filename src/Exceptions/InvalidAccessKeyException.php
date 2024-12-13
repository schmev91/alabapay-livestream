<?php
namespace Alabapay\AlabapayLivestream\Exceptions;

use Exception;

class InvalidAccessKeyException extends Exception
{
    public function render($request)
    {
        return response()->json(
            ["message" => "Access key không hợp lệ.", "success" => false],
            401
        );
    }
}
