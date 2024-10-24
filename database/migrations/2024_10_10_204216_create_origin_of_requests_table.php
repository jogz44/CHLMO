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
        Schema::create('origin_of_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('origin_of_requests')->insert([
            ['name' => 'N/A'],
            ['name' => 'CMO'],
            ['name' => 'SPMO'],
            ['name' => 'Walk-in'],
            ['name' => 'Referral'],
            ['name' => 'Barangay'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('origin_of_requests');
    }
};
