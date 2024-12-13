<?php

namespace Alabapay\AlabapayLivestream;

use Alabapay\AlabapayLivestream\Exceptions\InvalidAccessKeyException;
use Alabapay\AlabapayLivestream\Models\LivestreamUser;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AlabapayLivestream
{
    private string $baseApiUrl = "";

    public function __construct()
    {
        $this->baseApiUrl =
            config("alabapay-livestream.alabapay_url") .
            "api/merchant/livestream/";
    }

    private function apiClient(): PendingRequest
    {
        $headers = [
            "Authorization" => config("alabapay-livestream.access_key"),
            "Content-Type" => "application/json",
        ];
        return Http::withHeaders($headers);
    }

    /**
     * Lấy danh sách người dùng đang livestream
     *
     * @return void
     */
    public function getActiveLivestreams(int $pageSize)
    {
        return LivestreamUser::with("user")
            ->where("status", "active")
            ->select("collected_diamond", "watching_count", "comment_count")
            ->paginate($pageSize);
    }

    /**
     * Lấy token livestream từ alabapay
     *
     * @return string
     */
    public function generateToken(string $channelName)
    {
        $apiUrl = $this->baseApiUrl . "generate-token";
        $requestBody = compact("channelName");

        try {
            $response = $this->apiClient()->post($apiUrl, $requestBody);
            // get the token from alabapay api
        } catch (\Throwable $th) {
            return false;
        }

        // check if the access_key seen as valid
        if ($response->unauthorized()) {
            throw new InvalidAccessKeyException();
        }

        // handle failed token generate request
        if (!$response->successful()) {
            return false;
        }

        $token = $response->json("token");

        // return the agora token
        return $token;
    }

    /**
     * Kết thúc livestream
     *
     * @return bool
     */
    public function endLivestream(
        string $agora_token,
        int $watching_count,
        int $comment_count,
        int $collected_diamond
    ): bool {
        $apiUrl = $this->baseApiUrl . "end";

        $requestBody = compact(
            "agora_token",
            "watching_count",
            "comment_count",
            "collected_diamond"
        );

        try {
            $response = $this->apiClient()->post($apiUrl, $requestBody);
        } catch (\Throwable $th) {
            return false;
        }

        if ($response->unauthorized()) {
            throw new InvalidAccessKeyException();
        }

        // return true if successful
        if ($response->successful()) {
            return true;
        }

        return false;
    }
}
