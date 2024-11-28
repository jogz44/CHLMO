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
        Schema::create('profiled_applicants_documents_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profiled_tagged_applicant_id')
                ->constrained('profiled_tagged_applicants')
                ->onDelete('cascade')
                ->index('profiled_applicant_id'); 
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->bigInteger('file_size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiled_applicants_documents_submissions');
    }
};
