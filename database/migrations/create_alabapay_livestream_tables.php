<?php

use Alabapay\AlabapayLivestream\AlabapayLivestreamServiceProvider;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private string $tablePrefix = "alabapay_livestream_";

    public function up()
    {
        // Kiểm tra table có tồn tại hay không và tạo table nếu không tồn tại
        if (!Schema::hasTable($this->tablePrefix . "live_stream_users")) {
            Schema::create($this->tablePrefix . "live_stream_users", function (
                Blueprint $table
            ) {
                $table->id();

                $table->bigInteger("user_id")->nullable();
                $table->string("host_identity", 255)->nullable();

                $table->string("agora_token", 255)->nullable();

                $table->string("status", 255)->default("active");
                $table->jsonb("joined_users")->nullable();

                $table->integer("watching_count")->default(0);
                $table->integer("comment_count")->default(0);
                $table->integer("collected_diamond")->default(0);

                $table->timestamps();
            });
        }
    }

    public function down()
    {
        // Kiểm tra table có tồn tại không và xóa nếu tồn tại
        if (Schema::hasTable($this->tablePrefix . "live_stream_users")) {
            Schema::drop($this->tablePrefix . "live_stream_users");
        }
    }
};
