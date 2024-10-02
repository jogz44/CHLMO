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
            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('religion_id')->constrained('religions')->onDelete('cascade');
            $table->foreignId('spouse_id')->constrained('spouses')->onDelete('cascade');
            $table->foreignId('dependent_id')->constrained('dependents')->onDelete('cascade');
            $table->foreignId('living_situation_id')->constrained('living_situations')->onDelete('cascade');
            $table->foreignId('case_specification_id')->constrained('case_specifications')->onDelete('cascade');
            $table->foreignId('living_status_id')->constrained('living_statuses')->onDelete('cascade');
            $table->foreignId('wall_type_id')->constrained('wall_types')->onDelete('cascade');
            $table->text('full_address')->nullable();
            $table->char('sex', 6);
            $table->date('date_of_birth')->nullable();
            $table->string('occupation', 255)->nullable();
            $table->integer('monthly_income')->nullable();
            $table->integer('family_income')->nullable();
            $table->dateTime('awarding_date')->nullable();
            $table->integer('rent_fee')->nullable();

            $table->string('status', 50)->nullable();
            $table->string('tagger_name', 100)->nullable();
            $table->dateTime('tagging_date')->nullable();
            $table->string('awarded_by', 100)->nullable();
            $table->string('photo', 255)->nullable();
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
