<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grantee_attachment_lists', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_name', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('grantee_attachment_lists')->insert([
            ['attachment_name' => 'Request Letter Address to City Mayor (photo)'],
            ['attachment_name' => 'Certificate of Indigency (photo)'],
            ['attachment_name' => 'Consent Letter (if the land is not theirs) (photo)'],
            ['attachment_name' => 'photocopy of ID from the Land Owner (if the land is not theirs) (photo)'],
            ['attachment_name' => 'Profiling Form (photo)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grantee_attachment_lists');
    }
};
