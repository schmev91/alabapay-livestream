<?php
namespace Alabapay\AlabapayLivestream\Controllers\API;

use Alabapay\AlabapayLivestream\Controllers\Controller;

class ApiController extends Controller
{
    public function sendResponse(
        mixed $data,
        string $message = "Success",
        int $status = 200
    ) {
        return response()->json(compact("data", "message", "status"), $status);
    }

    public function sendError(
        string $message = "Bad Request",
        int $status = 400,
        mixed $data = null
    ) {
        return response()->json(compact("data", "message", "status"), $status);
    }
}
