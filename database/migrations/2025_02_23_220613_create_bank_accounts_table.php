<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\BankAccountType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string("type")->default(BankAccountType::LOCAL->value);
            $table->foreignId("country_id")->nullable();
            $table->string("currency")->nullable();
            $table->foreignId("bank_id")->nullable();
            $table->string("name");
            $table->string("number");
            $table->string("swift_bic")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
