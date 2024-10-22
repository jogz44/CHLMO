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
        Schema::create('awardee_attachments_lists', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_name', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('awardee_attachments_lists')->insert([
            ['attachment_name' => 'Letter of Intent (photo)'],
            ['attachment_name' => 'Voter\'s ID (photo)'],
            ['attachment_name' => 'Valid ID (photo)'],
            ['attachment_name' => 'Certificate of No Land Holding (photo)'],
            ['attachment_name' => 'Marriage Certificate (photo)'],
            ['attachment_name' => 'Birth Certification (photo)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('awardee_attachments_lists');
    }
};
