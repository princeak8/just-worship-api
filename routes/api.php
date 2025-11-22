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
use App\Http\Controllers\EventController;
use App\Http\Controllers\LiveController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\GivingController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\OnlineAccountController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CenterController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\VolunteeringTeamController;
use App\Http\Controllers\GivingPartnerController;
use App\Http\Controllers\DiscipleshipController;

use App\Http\Controllers\UtilityController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => '/auth'], function () {
    Route::post("/login", [AuthController::class, "login"]);
});

//Public Routes
Route::group(["prefix" => "slides"], function() {
    Route::get("", [SlideController::class, "slides"]);
    Route::get("/{slideId}", [SlideController::class, "slide"]);
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

Route::group(["prefix" => "events"], function() {
    Route::get("", [EventController::class, "events"]);
    Route::get("/{id}", [EventController::class, "event"]);
    Route::post("/book", [EventController::class, "book"]);
});

Route::group(["prefix" => "live"], function() {
    Route::get("", [LiveController::class, "lives"]);
    Route::get("/{id}", [LiveController::class, "live"]);
    Route::post("/book", [LiveController::class, "book"]);
});

Route::group(["prefix" => "store"], function() {
    Route::get("", [StoreController::class, "store"]);
    Route::get("/{id}", [StoreController::class, "storeItem"]);
});

Route::group(["prefix" => "giving"], function() {
    Route::get("/modes", [GivingController::class, "givingModes"]);
    Route::get("/options", [GivingController::class, "givingOptions"]);
});

Route::group(["prefix" => "bank_accounts"], function() {
    Route::get("", [BankAccountController::class, "accounts"]);
    Route::get("/{bankAccountId}", [BankAccountController::class, "account"]);
});

Route::group(["prefix" => "online_accounts"], function() {
    Route::get("", [OnlineAccountController::class, "accounts"]);
    Route::get("/{onlineAccountId}", [OnlineAccountController::class, "account"]);
});

Route::group(["prefix" => "music"], function() {
    Route::get("", [MusicController::class, "all"]);
    Route::get("/{musicId}", [MusicController::class, "music"]);
});

Route::group(["prefix" => "centers"], function() {
    Route::get("", [CenterController::class, "centers"]);
    Route::get("/{centerId}", [CenterController::class, "center"]);
});

Route::group(["prefix" => "stories"], function() {
    Route::get("", [StoryController::class, "stories"]);
    Route::get("/{storyId}", [StoryController::class, "story"]);
});

Route::group(["prefix" => "volunteering_teams"], function() {
    Route::get("", [VolunteeringTeamController::class, "teams"]);
    Route::get("/{teamId}", [VolunteeringTeamController::class, "team"]);
});

Route::group(["prefix" => "volunteers"], function() {
    Route::get("", [VolunteerController::class, "volunteers"]);
    Route::get("/{volunteerId}", [VolunteerController::class, "getVolunteer"]);
});

Route::group(["prefix" => "giving_partners"], function() {
    Route::post("", [GivingPartnerController::class, "store"]);
});

Route::post("/subscribe", [SubscriberController::class, "subscribe"]);
Route::post("/members/register", [MembershipController::class, "save"]);

//Discipleship Class
Route::group(["prefix" => "discipleship"], function() {
    Route::get("/current", [DiscipleshipController::class, "currentDiscipleship"]);
    Route::post("/join/{id}", [DiscipleshipController::class, "join"]);
});


Route::get("/countries", [UtilityController::class, "countries"]);
Route::get("/banks", [UtilityController::class, "banks"]);

//Protected Routes
Route::middleware(UserAuth::class)->group(function () {
    Route::group(['prefix' => '/profile'], function () {
        Route::get("", [ProfileController::class, "profile"]);
    });

    Route::group(["prefix" => "slides"], function() {
        Route::post("", [SlideController::class, "save"]);
        Route::post("/{slideId}", [SlideController::class, "update"]);
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

    Route::group(["prefix" => "events"], function() {
        Route::post("", [EventController::class, "save"]);
        Route::post("/{eventId}", [EventController::class, "update"]);
        Route::delete("/{id}", [EventController::class, "delete"]);
    });

    Route::group(["prefix" => "live"], function() {
        Route::post("", [LiveController::class, "save"]);
        Route::post("/{id}", [LiveController::class, "update"]);
        Route::delete("/{id}", [LiveController::class, "delete"]);
    });

    Route::group(["prefix" => "store"], function() {
        Route::post("", [StoreController::class, "addToStore"]);
        Route::post("/{id}", [StoreController::class, "editItem"]);
        Route::delete("/{id}", [StoreController::class, "deleteItem"]);
    });

    Route::group(["prefix" => "giving"], function() {
        Route::post("/save_giving_account", [GivingController::class, "linkGivingAccount"]);
    });

    Route::group(["prefix" => "bank_accounts"], function() {
        Route::post("", [BankAccountController::class, "save"]);
        Route::post("/{bankAccountId}", [BankAccountController::class, "update"]);
        Route::delete("/{bankAccountId}", [BankAccountController::class, "delete"]);
    });
    
    Route::group(["prefix" => "online_accounts"], function() {
        Route::post("", [OnlineAccountController::class, "save"]);
        Route::post("/{onlineAccountId}", [OnlineAccountController::class, "update"]);
        Route::delete("/{onlineAccountId}", [OnlineAccountController::class, "delete"]);
    });

    Route::group(["prefix" => "music"], function() {
        Route::post("", [MusicController::class, "save"]);
        Route::post("/{musicId}", [MusicController::class, "update"]);
        Route::delete("/{musicId}", [MusicController::class, "delete"]);
    });
    
    Route::group(["prefix" => "centers"], function() {
        Route::post("", [CenterController::class, "save"]);
        Route::post("/{centerId}", [CenterController::class, "update"]);
        Route::delete("/{centerId}", [CenterController::class, "delete"]);
    });
    
    Route::group(["prefix" => "stories"], function() {
        Route::post("", [StoryController::class, "save"]);
        Route::post("/{storyId}", [StoryController::class, "update"]);
        Route::delete("/{storyId}", [StoryController::class, "delete"]);
    });

    Route::group(["prefix" => "volunteering_teams"], function() {
        Route::post("", [VolunteeringTeamController::class, "save"]);
        Route::post("/{teamId}", [VolunteeringTeamController::class, "update"]);
        Route::delete("/{teamId}", [VolunteeringTeamController::class, "delete"]);
    });
    
    Route::group(["prefix" => "volunteers"], function() {
        Route::post("", [VolunteerController::class, "save"]);
        Route::post("/{volunteerId}", [VolunteerController::class, "update"]);
        Route::delete("/{volunteerId}", [VolunteerController::class, "delete"]);
    });

    Route::group(["prefix" => "giving_partners"], function() {
        Route::get("", [GivingPartnerController::class, "index"]);
        Route::get("/statistics", [GivingPartnerController::class, "statistics"]);
        Route::get("/{givingPartner}", [GivingPartnerController::class, "show"]);
        Route::put("/{givingPartner}", [GivingPartnerController::class, "update"]);
        Route::delete("/{givingPartner}", [GivingPartnerController::class, "destroy"]);
    });

    //Discipleship Class
    Route::group(["prefix" => "discipleships"], function() {
        Route::get("", [DiscipleshipController::class, "discipleships"]);
        Route::get("/{id}", [DiscipleshipController::class, "discipleship"]);
        Route::post("", [DiscipleshipController::class, "create"]);
        Route::post("/{id}", [DiscipleshipController::class, "update"]);
        Route::post("/open/{id}", [DiscipleshipController::class, "open"]);
        Route::post("/close/{id}", [DiscipleshipController::class, "close"]);

    });

    Route::get("/subscribers", [SubscriberController::class, "subscribers"]);

    Route::get("/members", [MembershipController::class, "members"]);
});


