<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\UserAuth;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\YoutubeController;
use App\Http\Controllers\GalleryController;

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

Route::group(["prefix" => "contact_messages"], function() {
    Route::post("", [ContactMessageController::class, "save"]);
});

Route::group(["prefix" => "youtube"], function() {
    Route::get("", [YoutubeController::class, "youtubeVid"]);
});

Route::group(["prefix" => "gallery"], function() {
    Route::get("", [GalleryController::class, "gallery"]);
    Route::get("/{id}", [GalleryController::class, "galleryPhoto"]);
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

    Route::group(["prefix" => "contact_messages"], function() {
        Route::get("", [ContactMessageController::class, "messages"]);
        Route::get("/unread", [ContactMessageController::class, "unreadMessages"]);
        Route::get("/{messageId}", [ContactMessageController::class, "message"]);
    });

    Route::group(["prefix" => "youtube"], function() {
        Route::post("", [YoutubeController::class, "save"]);
    });

    Route::group(["prefix" => "gallery"], function() {
        Route::post("add_photo", [GalleryController::class, "save"]);
        Route::post("update_photo/{id}", [GalleryController::class, "update"]);
        Route::delete("delete_photo/{id}", [GalleryController::class, "deleteGalleryPhoto"]);
    });
});


