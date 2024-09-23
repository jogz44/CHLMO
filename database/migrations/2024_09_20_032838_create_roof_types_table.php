<?php

use App\Models\RoofType;
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
        Schema::create('roof_types', function (Blueprint $table) {
            $table->id();
            $table->string('roof_type_name', 255);
            $table->timestamps();
        });

        // insert roof types
        $roofTypes = [
            'Kawayan / Sawali / Cogon / Nipa',
            'Asbeston / Sin',
            'Improvised Materials',
            'Trapal',
        ];

        foreach ($roofTypes as $roofType) {
            DB::table('roof_types')->insert([
                'roof_type_name' => $roofType,
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
        Schema::dropIfExists('roof_types');
    }
};
