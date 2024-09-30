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
        Schema::create('transaction_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name', 255);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Insert initial data
        DB::table('transaction_types')->insert([
            ['type_name' => 'Walk-in', 'description' => 'Walk-in applicants may go to the office directly to request relocation.'],
            ['type_name' => 'Request', 'description' => 'Requested applicants from the Sherif.'],
            ['type_name' => 'Shelter Assistance', 'description' => 'Shelter assistance applicants may go to the office directly to request shelter materials.'],
        ]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_types');
    }
};
