<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('about', function (Blueprint $table) {
            $table->text("header")->nullable()->after("mission_photo_id");
            $table->text("content")->nullable()->after("header");
            $table->string("pastor_title")->default("Lead Pastor")->after("content");
            $table->text("pastor_bio")->nullable()->after("pastor_title");
            $table->string("pastor_photo_id")->nullable()->after("pastor_bio");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about', function (Blueprint $table) {
            //
        });
    }
};
