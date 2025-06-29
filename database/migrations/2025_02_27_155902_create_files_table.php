<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\EnumClass;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string("url");
            $table->string("compressed_url");
            $table->enum('file_type', EnumClass::fileTypes());
            $table->string('mime_type');
            $table->string('filename');
            $table->string('original_filename');
            $table->string('extension');
            $table->bigInteger('size');
            $table->string('formatted_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
