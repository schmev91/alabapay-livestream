<?php
namespace Alabapay\AlabapayLivestream\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivestreamUser extends Model
{
    use HasFactory;

    protected $table = "alabapay_livestream_live_stream_users";

    /**
     * @var array fillable fields
     */
    protected $fillable = [
        "agora_token",
        "collected_diamond",
        // "fullname",
        "host_identity",
        "joined_users",
        "user_id",
        "watching_count",
        "status",
        "comment_count",
     ];

    protected $casts = [
        "joined_users" => "array",
     ];

    public function user()
    {
        return $this->belongsTo(
            config("alabapay-livestream.user_class"),
            "user_id",
            "id"
        );
    }
}
