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
        Schema::create('shelter_images_for_housings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profiled_tagged_applicant_id')->constrained('profiled_tagged_applicants')->onDelete('cascade');
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
        Schema::dropIfExists('shelter_images_for_housings');
    }
};
