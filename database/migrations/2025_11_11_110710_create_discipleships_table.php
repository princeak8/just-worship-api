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
        Schema::create('discipleships', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string("name")->default("Discipleship with Pastor Chidi Ani");
            $table->tinyInteger("month");
            $table->integer("year");
            $table->foreignId("photo_id")->nullable();
            $table->foreignId("country_id")->nullable();
            $table->string("venue")->nullable();
            $table->boolean("online")->default(false);
            $table->string("link")->nullable();
            $table->boolean("open")->default(false);
            $table->date("deadline")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discipleships');
    }
};
