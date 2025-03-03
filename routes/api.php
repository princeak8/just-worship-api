<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\UserAuth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\AboutController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => '/auth'], function () {
    Route::post("/login", [AuthController::class, "login"]);
});

Route::middleware(UserAuth::class)->group(function () {
    Route::group(["prefix" => "slides"], function() {
        Route::post("", [SlideController::class, "save"]);
        Route::get("", [SlideController::class, "slides"]);
        Route::delete("/{slideId}", [SlideController::class, "delete"]);
    });

    Route::group(["prefix" => "about"], function() {
        Route::post("", [AboutController::class, "save"]);
        Route::get("", [AboutController::class, "about"]);
    });
});


