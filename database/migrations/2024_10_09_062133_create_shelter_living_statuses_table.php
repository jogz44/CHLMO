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
        Schema::create('shelter_living_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('shelter_living_status_name'); 
            $table->timestamps();
        });
    

     // Insert initial data
     DB::table('shelter_living_statuses')->insert([
        ['shelter_living_status_name' => 'Lot owner'],
        ['shelter_living_status_name' => 'Danger zone'],
        ['shelter_living_status_name' => 'Court Order'],
        ['shelter_living_status_name' => 'Government Property'],
        ['shelter_living_status_name' => 'Private Property'],
        ['shelter_living_status_name' => 'With Notice to Vacate'],
        ['shelter_living_status_name' => 'With Court Order of Demolition and Eviction'],
        ['shelter_living_status_name' => 'Affected by Government Infrastructure Projects'],
        ['shelter_living_status_name' => 'Private Construction Projects'],
        ['shelter_living_status_name' => 'Alienable and Disposable Land'],
        ['shelter_living_status_name' => 'Other cases'],
    ]);
    Schema::enableForeignKeyConstraints();
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shelter_living_statuses');
    }
};
