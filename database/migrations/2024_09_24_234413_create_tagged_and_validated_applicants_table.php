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
        Schema::create('tagged_and_validated_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('civil_status_id')->constrained('civil_statuses')->onDelete('cascade');
            $table->foreignId('tribe_id')->constrained('tribes')->onDelete('cascade');
            $table->foreignId('religion_id')->constrained('religions')->onDelete('cascade');
            $table->foreignId('living_situation_id')->constrained('living_situations')->onDelete('cascade');
            $table->foreignId('case_specification_id')->constrained('case_specifications')->onDelete('cascade');
            $table->foreignId('government_program_id')->constrained('government_programs')->onDelete('cascade');
            $table->foreignId('living_status_id')->constrained('living_statuses')->onDelete('cascade');
            $table->foreignId('roof_type_id')->constrained('roof_types')->onDelete('cascade');
            $table->foreignId('wall_type_id')->constrained('wall_types')->onDelete('cascade');
            $table->text('full_address')->nullable();
            $table->char('sex', 6);
            $table->date('date_of_birth');
            $table->string('occupation', 255);
            $table->integer('monthly_income');
            $table->integer('family_income');
            $table->date('tagging_date');
            $table->integer('rent_fee')->nullable();
            $table->string('tagger_name', 100)->nullable();
            $table->text('remarks')->nullable();
            $table->json('photos')->nullable();
            $table->boolean('tagged')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagged_and_validated_applicants');
    }
};
