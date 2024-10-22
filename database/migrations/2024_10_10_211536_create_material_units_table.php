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
        Schema::create('material_units', function (Blueprint $table) {
            $table->id();
            $table->string('unit', 100);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('material_units')->insert([
            ['unit' => 'SHEETS'],
            ['unit' => 'BAGS'],
            ['unit' => 'PCS'],
            ['unit' => 'KLS'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_units');
    }
};
