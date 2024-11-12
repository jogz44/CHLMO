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
        Schema::create('grantees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profiled_tagged_applicant_id')->constrained('profiled_tagged_applicants')->onDelete('cascade');
            $table->dateTime('date_of_delivery');
            $table->dateTime('date_of_ris');
            $table->boolean('is_granted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grantees');
    }
};
