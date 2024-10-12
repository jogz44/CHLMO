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
        Schema::create('images_for_housings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagged_and_validated_applicant_id')->constrained('tagged_and_validated_applicants')->onDelete('cascade');
            $table->string('image_path');
            $table->string('display_name')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images_for_housings');
    }
};
