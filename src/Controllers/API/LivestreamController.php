<?php
namespace Alabapay\AlabapayLivestream\Controllers\API;

use Alabapay\AlabapayLivestream\AlabapayLivestream;
use Alabapay\AlabapayLivestream\Exceptions\AccessKeyNotSetException;
use Alabapay\AlabapayLivestream\Models\LivestreamUser;

class LivestreamController extends ApiController
{
    public function __construct(private AlabapayLivestream $alabapayLivestream)
    {
        // Kiểm tra access key đã được set hay chưa
        if (!config("alabapay-livestream.access_key")) {
            throw new AccessKeyNotSetException();
        }
        $this->alabapayLivestream = new AlabapayLivestream();
    }

    /**
     * Lấy danh sách người dùng livestream
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function getLivestreamingUsers()
    {
        $validated = request()->validate([
            "pageSize" => "nullable|integer",
        ]);
        $pageSize = $validated["pageSize"] ?? 10;

        $result = LivestreamUser::with("user")
            ->where("status", "active")
            ->paginate($pageSize);

        return $this->sendResponse($result);
    }

    /**
     * Lấy token agora
     *
     * @return Illuminate\Http\JsonResponse
     */
    public function tokenGenerate()
    {
        $validated = request()->validate(["channelName" => "required|string"]);

        $user = optional(request()->user())->getUser();
        $userId = $user->id ?? null;

        $isLivestreamExists = LiveStreamUser::where("user_id", $userId)
            ->where("status", "active")
            ->first();

        // Kiểm tra livestream đã tồn tại hay chưa
        if ($isLivestreamExists) {
            return $this->sendError("Livestream đã tồn tại.");
        }

        // Gọi dịch vụ tạo token
        $agoraToken = $this->alabapayLivestream->generateToken(
            $validated["channelName"]
        );

        // Kiểm tra token có được tạo thành công hay không
        if (!$agoraToken) {
            return $this->sendError(
                "Đã có lỗi xảy ra trong quá trình tạo token.",
                500
            );
        }

        // Tạo record LiveStreamUser
        LiveStreamUser::create([
            "agora_token" => $agoraToken,
            // "fullname"      => $user->fullname ?? "Anonymous",
            "host_identity" => $userId ?? "Host",
            "joined_users" => [],
            "user_id" => $userId,
        ]);

        return $this->sendResponse(["token" => $agoraToken]);
    }

    public function livestreamEnd()
    {
        $validated = request()->validate([
            "watching_count" => "required|integer|min:0",
            "comment_count" => "required|integer|min:0",
            "collected_diamond" => "required|integer|min:0",
        ]);

        $user = optional(request()->user())->getUser();
        $userId = $user->id ?? null;

        try {
            $livestreamRecord = LivestreamUser::where("user_id", $userId)
                ->where("status", "active")
                ->firstOrFail();
        } catch (\Throwable $th) {
            return $this->sendError("Livestream không tồn tại.");
        }

        // Lấy agora token từ record
        $token = $livestreamRecord->agora_token;

        $isEndRemoteStreamSuccess = $this->alabapayLivestream->endLivestream(
            $token,
            ...$validated
        );

        // Kiểm tra đã kết thúc livestream trên server thành công chưa
        if (!$isEndRemoteStreamSuccess) {
            return $this->sendError(
                "Có lỗi xảy ra trong quá trình kết thúc livestream.",
                500
            );
        }

        $livestreamRecord->update(["status" => "ended", ...$validated]);

        return $this->sendResponse(
            $livestreamRecord,
            "Kết thúc livestream thành công."
        );
    }
}
