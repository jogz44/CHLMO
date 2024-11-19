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
//            $table->foreignId('address_id')->constrained('addresses')->onDelete('cascade');
            $table->foreignId('relocation_lot_id')->constrained('relocation_sites')->onDelete('cascade');
            $table->decimal('lot_size', 8, 2); // For the numeric value
//            $table->foreignId('lot_size_unit_id')->constrained('lot_size_units')->onDelete('cascade');
            $table->string('unit', 100);
            $table->dateTime('grant_date');
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
