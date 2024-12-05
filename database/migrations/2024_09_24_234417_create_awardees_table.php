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
        Schema::create('awardees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagged_and_validated_applicant_id')->constrained('tagged_and_validated_applicants')->onDelete('cascade');
            $table->foreignId('assigned_relocation_site_id')->constrained('relocation_sites')->onDelete('cascade');
            $table->foreignId('previous_awardee_id')->nullable()->constrained('awardees')->nullOnDelete();
            $table->string('assigned_lot', 100);
            $table->string('assigned_block', 100);
            $table->decimal('assigned_relocation_lot_size', 8, 2); // For the numeric value
            $table->string('unit', 100);
            $table->foreignId('actual_relocation_site_id')->nullable()->constrained('relocation_sites')->onDelete('cascade');
            $table->string('actual_lot', 100)->nullable();
            $table->string('actual_block', 100)->nullable();
            $table->decimal('actual_relocation_lot_size', 8, 2)->nullable(); // For the numeric value
            $table->dateTime('grant_date')->nullable();
            $table->string('previous_awardee_name')->nullable();
            $table->boolean('has_assigned_relocation_site')->default(false);
            $table->boolean('documents_submitted')->default(false);
            $table->boolean('is_awarded')->default(false);
            $table->boolean('is_blacklisted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awardees');
    }
};
