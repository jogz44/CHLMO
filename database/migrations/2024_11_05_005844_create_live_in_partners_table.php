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
        Schema::create('live_in_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagged_and_validated_applicant_id')->constrained('tagged_and_validated_applicants')->onDelete('cascade');
            $table->string('partner_first_name', 50);
            $table->string('partner_middle_name', 50)->nullable();
            $table->string('partner_last_name', 50);
            $table->string('partner_occupation');
            $table->integer('partner_monthly_income');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_in_partners');
    }
};
