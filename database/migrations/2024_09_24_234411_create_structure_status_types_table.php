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
        Schema::create('structure_status_types', function (Blueprint $table) {
            $table->id();
            $table->string('structure_status', 255);
            $table->timestamps();
        });
        // insert wall types
        $structureStatuses = [
            'Fully Damaged',
            'Partially Damaged',
            'No Damage',
            'Under Evaluation'
        ];

        foreach ($structureStatuses as $structureStatus) {
            DB::table('structure_status_types')->insert([
                'structure_status' => $structureStatus,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('structure_status_types');
    }
};
