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
        Schema::create('lot_size_units', function (Blueprint $table) {
            $table->id();
            $table->string('lot_size_unit_name', 50); // For the unit
            $table->string('lot_size_unit_short_name', 50); // For the unit
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('lot_size_units')->insert([
            ['lot_size_unit_name' => 'Square Meters ()', 'lot_size_unit_short_name' => 'sq meters'],
            ['lot_size_unit_name' => 'Square Feet', 'lot_size_unit_short_name' => 'sq ft'],
            ['lot_size_unit_name' => 'Acres', 'lot_size_unit_short_name' => 'acres'],
            ['lot_size_unit_name' => 'Hectares', 'lot_size_unit_short_name' => 'hectares'],
            ['lot_size_unit_name' => 'Square Kilometers', 'lot_size_unit_short_name' => 'sq kilometers'],
            ['lot_size_unit_name' => 'Square Miles', 'lot_size_unit_short_name' => 'sq miles'],
            ['lot_size_unit_name' => 'Square Yards', 'lot_size_unit_short_name' => 'sq yards'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_size_units');
    }
};
