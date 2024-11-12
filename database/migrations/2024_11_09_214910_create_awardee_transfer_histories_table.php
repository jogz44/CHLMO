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
        Schema::create('awardee_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('previous_awardee_id')->constrained('awardees')
                ->onDelete('restrict'); // Prevent deletion of awardees with transfer history
//            $table->foreignId('new_awardee_id')->constrained('awardees')
//                ->onDelete('restrict');
            $table->dateTime('transfer_date');
            $table->string('transfer_reason');
            $table->string('relationship');
            $table->foreignId('processed_by')->constrained('users')
                ->onDelete('restrict');
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Add this if you want to keep transfer records even if deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awardee_transfer_histories');
    }
};
