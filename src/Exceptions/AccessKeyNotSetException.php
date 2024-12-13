<?php
namespace Alabapay\AlabapayLivestream\Exceptions;

use Exception;

class AccessKeyNotSetException extends Exception
{
    public function render($request)
    {
        return response()->json(
            [ "message" => "Access key chưa được thiết lập. Hãy gán giá trị cho biến môi trường 'ALABAPAY_LIVESTREAM_KEY'", "success" => false ],
            400
        );
    }
}
