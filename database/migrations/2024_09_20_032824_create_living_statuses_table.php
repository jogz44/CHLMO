<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('living_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('living_status_name', 255);
            $table->timestamps();
        });

        // Insert initial data
        DB::table('living_statuses')->insert([
            ['living_status_name' => 'Renting'],
            ['living_status_name' => 'Own house but renting the land, without the owner\'s consent'],
            ['living_status_name' => 'Free to live in the house and land with the owner\'s permission'],
            ['living_status_name' => 'Free to live in the house and land without the owner\'s permission'],
            ['living_status_name' => 'Just staying in someone\'s house'],
        ]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('living_statuses');
    }
};
