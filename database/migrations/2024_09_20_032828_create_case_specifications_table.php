<?php

use App\Models\CaseSpecification;
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
        Schema::create('case_specifications', function (Blueprint $table) {
            $table->id();
            $table->string('case_specification_name', 255);
            $table->timestamps();
        });

        // Insert initial data
        DB::table('case_specifications')->insert([
            ['case_specification_name' => 'Creekside'],
            ['case_specification_name' => 'Riverside'],
            ['case_specification_name' => 'NPC Line'],
            ['case_specification_name' => 'Landslide Prone Area'],
            ['case_specification_name' => 'Identified Flood Prone Area'],
        ]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_specifications');
    }
};
