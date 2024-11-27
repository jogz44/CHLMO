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
            ['living_status_name' => 'ROOM RENTER'],
            ['living_status_name' => 'HOUSE RENTER'],
            ['living_status_name' => 'LOT RENTER'],
            ['living_status_name' => 'HOUSE OWNER'],
            ['living_status_name' => 'LOT SQUATTER'],
            ['living_status_name' => 'FREE OCCUPANT'],
            ['living_status_name' => 'SQUATTER'],
            ['living_status_name' => 'SHARER'],
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
