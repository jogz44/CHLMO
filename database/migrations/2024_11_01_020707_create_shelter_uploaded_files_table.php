<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('shelter_uploaded_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grantee_id')->constrained('grantees')->onDelete('cascade');
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
        Schema::dropIfExists('shelter_uploaded_files');
    }
};
