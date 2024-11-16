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
        Schema::create('grantee_documents_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profiled_tagged_applicant_id')
                ->constrained('profiled_tagged_applicants')
                ->onDelete('cascade')
                ->name('fk_tagged_applicant'); // Shorter name for the foreign key constraint
            $table->foreignId('attachment_id')
                ->constrained('grantee_attachment_lists')
                ->onDelete('cascade')
                ->name('fk_attachment'); // Shorter name for the foreign key constraint
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
        Schema::dropIfExists('grantee_documents_submissions');
    }
};
