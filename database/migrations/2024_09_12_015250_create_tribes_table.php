<?php

use App\Models\Tribe;
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
        Schema::create('tribes', function (Blueprint $table) {
            $table->id();
            $table->string('tribe_name', 255);
            $table->timestamps();
        });

        // insert tribes
        $tribes = [
            'N/A',
            'Mansaka',
            'Lumad',
            'Badjao',
        ];

        foreach ($tribes as $tribe) {
            DB::table('tribes')->insert([
                'tribe_name' => $tribe,
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
        Schema::dropIfExists('tribes');
    }
};
