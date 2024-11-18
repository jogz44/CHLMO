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
        Schema::create('awardee_documents_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagged_applicant_id')->constrained('tagged_and_validated_applicants')->onDelete('cascade');
            $table->foreignId('attachment_id')->constrained('awardee_attachments_lists')->onDelete('cascade');
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
        Schema::dropIfExists('awardee_documents_submissions');
    }
};
