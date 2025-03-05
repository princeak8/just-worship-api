<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\UserAuth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContactController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => '/auth'], function () {
    Route::post("/login", [AuthController::class, "login"]);
});

//Public Routes
Route::group(["prefix" => "slides"], function() {
    Route::get("", [SlideController::class, "slides"]);
});

Route::group(["prefix" => "about"], function() {
    Route::get("", [AboutController::class, "about"]);
});

Route::group(["prefix" => "contact"], function() {
    Route::get("", [ContactController::class, "contactInfo"]);
});

Route::group(["prefix" => "team"], function() {
    Route::get("", [TeamController::class, "team"]);
    Route::get("/member/{id}", [TeamController::class, "teamMember"]);
});


//Protected Routes
Route::middleware(UserAuth::class)->group(function () {
    Route::group(["prefix" => "slides"], function() {
        Route::post("", [SlideController::class, "save"]);
        Route::delete("/{slideId}", [SlideController::class, "delete"]);
    });

    Route::group(["prefix" => "about"], function() {
        Route::post("", [AboutController::class, "save"]);
    });

    Route::group(["prefix" => "contact"], function() {
        Route::post("", [ContactController::class, "save"]);
    });

    Route::group(["prefix" => "team"], function() {
        Route::post("", [TeamController::class, "addMember"]);
        Route::post("/member/{id}", [TeamController::class, "updateMember"]);
        Route::delete("/member/{id}", [TeamController::class, "removeMember"]);
    });
});


