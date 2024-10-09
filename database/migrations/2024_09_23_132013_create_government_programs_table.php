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
        Schema::create('government_programs', function (Blueprint $table) {
            $table->id();
            $table->string('program_name', 255);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        // Insert initial data
        DB::table('government_programs')->insert([
            ['program_name' => 'N/A'],
            ['program_name' => 'Pantawid Pamilyang Pilipino Program (4Ps)'],
            ['program_name' => 'TESDA Scholarship Programs'],
            ['program_name' => 'PhilHealth Indigent Program'],
            ['program_name' => 'TUPAD (Emergency Employment Program)'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('government_programs');
    }
};
