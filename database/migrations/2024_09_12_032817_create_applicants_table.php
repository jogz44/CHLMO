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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('transaction_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('civil_status_id')->constrained()->onDelete('cascade');
            $table->foreignId('tribe_id')->constrained()->onDelete('cascade');
            $table->string('first_name', 50);
            $table->string('middle_name', 50)->nullable();
            $table->string('last_name', 50);
            $table->integer('age');
            $table->string('phone', 20)->nullable();
            $table->string('sex', 50);
            $table->string('occupation', 255);
            $table->integer('income');
            $table->dateTime('date_applied');
            $table->string('initially_interviewed_by', 100);
            $table->string('status', 50)->nullable();
            $table->string('tagger_name', 100)->nullable();
            $table->dateTime('tagging_date')->nullable();
            $table->string('awarded_by', 100)->nullable();
            $table->dateTime('awarding_date')->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
