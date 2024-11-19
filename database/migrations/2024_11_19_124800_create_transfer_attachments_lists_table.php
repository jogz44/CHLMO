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
        Schema::create('transfer_attachments_lists', function (Blueprint $table) {
            $table->id();
            $table->string('attachment_name', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('transfer_attachments_lists')->insert([
            ['attachment_name' => 'Original Copy of Notice of Award'],
            ['attachment_name' => 'Death Certificate'],
            ['attachment_name' => 'Marriage Certificate'],
            ['attachment_name' => 'Valid Id 1'],
            ['attachment_name' => 'Valid Id 2'],
            ['attachment_name' => 'Voter\'s Certificate'],
            ['attachment_name' => 'Birth Certificate'],
            ['attachment_name' => 'Extrajudicial Settlement/Waiver of Rights'],
            ['attachment_name' => 'Certificate of No Land Holding'],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_attachments_lists');
    }
};
