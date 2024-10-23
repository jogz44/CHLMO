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
            $table->foreignId('awardee_id')->constrained('awardees')->onDelete('cascade');
            $table->foreignId('awardee_attachments_list_id')->constrained('awardee_attachments_lists')->onDelete('cascade');
            $table->text('description')->nullable();
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
