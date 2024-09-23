<?php

use App\Models\WallType;
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
        Schema::create('wall_types', function (Blueprint $table) {
            $table->id();
            $table->string('wall_type_name', 255);
            $table->timestamps();
        });

        // insert wall types
        $wallTypes = [
            'Amakan / Plywood',
            'Semento',
            'Trapal',
        ];

        foreach ($wallTypes as $wallType) {
            DB::table('wall_types')->insert([
                'wall_type_name' => $wallType,
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
        Schema::dropIfExists('wall_types');
    }
};
