<?php

use Alabapay\AlabapayLivestream\Controllers\API\LivestreamController;
use Illuminate\Support\Facades\Route;

Route::prefix("api/livestream")
    ->name("alabapay.livestream.")
    ->group(function () {
        Route::get("/", [
            LivestreamController::class,
            "getLivestreamingUsers",
         ])->name("livestreaming-users");

        Route::post("generate-token", [
            LivestreamController::class,
            "tokenGenerate",
         ])->name("generate-token");

        Route::post("end", [ LivestreamController::class, "livestreamEnd" ])->name(
            "end"
        );
    });
