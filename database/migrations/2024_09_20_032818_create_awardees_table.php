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
        Schema::create('awardees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained()->onDelete('cascade');
            $table->string('lot_size_allocated', 255)->nullable();
            $table->string('letter_of_intent_photo', 255)->nullable();
            $table->string('voters_id_photo', 255)->nullable();
            $table->string('valid_id_photo', 255)->nullable();
            $table->string('certificate_of_no_land_holding_photo', 255)->nullable();
            $table->string('marriage_certificate_photo', 255)->nullable();
            $table->string('birth_certificate_photo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awardees');
    }
};
