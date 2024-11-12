<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dependents_relationships', function (Blueprint $table) {
            $table->id();
            $table->string('relationship', 255);
            $table->timestamps();
        });
        Schema::enableForeignKeyConstraints();

        // insert relationships
        $dependentRelationships = [
            'Child (Biological)',
            'Mother',
            'Father',
            'Grandparent',
            'Domestic Partner'
        ];

        foreach ($dependentRelationships as $dependentRelationship) {
            DB::table('dependents_relationships')->insert([
                'relationship' => $dependentRelationship,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
    public function down(): void
    {
        Schema::dropIfExists('dependents_relationships');
    }
};
