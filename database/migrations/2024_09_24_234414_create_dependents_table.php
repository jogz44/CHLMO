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
        Schema::create('dependents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagged_and_validated_applicant_id')->constrained('tagged_and_validated_applicants')->onDelete('cascade');
            $table->foreignId('dependent_civil_status_id')->constrained('civil_statuses')->onDelete('cascade');
            $table->foreignId('dependent_relationship_id')->constrained('dependents_relationships')->onDelete('cascade');
            $table->string('dependent_first_name', 50);
            $table->string('dependent_middle_name', 50)->nullable();
            $table->string('dependent_last_name', 50);
            $table->char('dependent_sex', 6);
            $table->date('dependent_date_of_birth');
            $table->string('dependent_relationship', 255);
            $table->string('dependent_occupation');
            $table->integer('dependent_monthly_income');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependents');
    }
};
