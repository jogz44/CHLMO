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
            $table->foreignId('living_situation_id')->constrained('living_situations')->onDelete('cascade');
            $table->foreignId('case_specification_id')->nullable()->constrained('case_specifications')->onDelete('cascade');
            $table->text('living_situation_case_specification')->nullable();
            $table->foreignId('government_program_id')->constrained('government_programs')->onDelete('cascade');
            $table->foreignId('living_status_id')->constrained('living_statuses')->onDelete('cascade');
            $table->foreignId('roof_type_id')->constrained('roof_types')->onDelete('cascade');
            $table->foreignId('wall_type_id')->constrained('wall_types')->onDelete('cascade');
            $table->foreignId('structure_status_id')->constrained('structure_status_types')->onDelete('cascade');
            $table->text('full_address')->nullable();
            $table->char('sex', 6);
            $table->date('date_of_birth');
            $table->string('tribe', 255);
            $table->string('religion', 255);
            $table->string('occupation', 255);
            $table->integer('monthly_income');
            $table->date('tagging_date');
            $table->integer('rent_fee')->nullable();
            $table->string('landlord', 255)->nullable();
            $table->string('house_owner', 255)->nullable();
            $table->string('relationship_to_house_owner', 255)->nullable();
            $table->string('tagger_name', 100)->nullable();
            $table->integer('years_of_residency');
            $table->text('remarks')->nullable();
            $table->boolean('is_tagged')->default(false);
            $table->boolean('is_awarding_on_going')->default(false);
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
