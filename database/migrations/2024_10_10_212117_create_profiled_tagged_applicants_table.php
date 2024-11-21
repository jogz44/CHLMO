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
        Schema::create('profiled_tagged_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_no')->constrained('shelter_applicants')->onDelete('cascade');
            $table->foreignId('civil_status_id')->constrained('civil_statuses')->onDelete('cascade');
            $table->foreignId('government_program_id')->constrained('government_programs')->onDelete('cascade');
            $table->foreignId('structure_status_id')->nullable()->constrained('structure_status_types')->onDelete('cascade');
            $table->foreignId('living_situation_id')->constrained('living_situations')->onDelete('cascade');
            $table->foreignId('case_specification_id')->nullable()->constrained('case_specifications')->onDelete('cascade');
            $table->text('living_situation_case_specification')->nullable();
            $table->text('full_address')->nullable();
            $table->string('tribe', 255);
            $table->string('religion', 255);
            $table->integer('age');
            $table->char('sex', 6);
            $table->string('occupation', 255);
            $table->integer('year_of_residency');
            $table->string('contact_number');
            $table->dateTime('date_tagged');
            $table->boolean('is_tagged')->default(false);
            $table->boolean('is_awarding_on_going')->default(false);
            $table->text('remarks', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiled_tagged_applicants');
    }
};
