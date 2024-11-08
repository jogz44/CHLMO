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
        Schema::create('shelter_spouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profiled_tagged_applicant_id')->constrained('profiled_tagged_applicants')->onDelete('cascade');
            $table->string('spouse_first_name', 50);
            $table->string('spouse_middle_name', 50)->nullable();
            $table->string('spouse_last_name', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_spouses');
    }
};
