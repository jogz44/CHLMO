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
        Schema::create('shelter_living_situations', function (Blueprint $table) {
            $table->id();
            $table->text('living_situation_description');
            $table->timestamps();
        });

        DB::table('shelter_living_situations')->insert([
            ['living_situation_description' => 'Affected by Government Infrastructure Projects'],
            ['living_situation_description' => 'Government Property'],
            ['living_situation_description' => 'With Court Order of Demolition and Eviction'],
            ['living_situation_description' => 'With Notice to Vacate'],
            ['living_situation_description' => 'Private Property'],
            ['living_situation_description' => 'Private Construction Projects'],
            ['living_situation_description' => 'Alienable and Disposable Land'],
            ['living_situation_description' => 'Danger Zone'],
            ['living_situation_description' => 'Other cases'],
        ]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_living_situations');
    }
};
