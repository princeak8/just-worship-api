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
        Schema::create('giving_partners', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('surname');
            $table->string('email');
            $table->string('phone');
            $table->foreignId('country_id');
            $table->foreignId('giving_option_id')->nullable();
            $table->boolean('recurrent')->default(false);
            $table->string('recurrent_type')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string("currency");
            $table->text('prayer_point')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('giving_partners');
    }
};
