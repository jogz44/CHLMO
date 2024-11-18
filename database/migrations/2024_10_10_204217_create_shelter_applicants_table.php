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
        Schema::create('shelter_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('person_id')->constrained('people')->onDelete('cascade');
            $table->foreignId('request_origin_id')->nullable()->constrained('origin_of_requests');
            $table->string('profile_no')->unique()->nullable();
            // $table->string('first_name', 50);
            // $table->string('middle_name', 50)->nullable();
            // $table->string('last_name', 50);
            $table->date('date_request');
            $table->boolean('is_tagged')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_applicants');
    }
};
