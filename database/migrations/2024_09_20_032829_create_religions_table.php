<?php

use App\Models\Religion;
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
        Schema::create('religions', function (Blueprint $table) {
            $table->id();
            $table->string('religion_name', 255);
            $table->timestamps();
        });

        // insert religions
        $religions = [
            'N/A',
            'Christianity',
            'Islam',
            'Hinduism',
            'Buddhism',
            'Judaism',
            'Sikhism',
            'Atheism',
            'Agnosticism',
            'Taoism',
            'Shintoism',
            'Zoroastrianism'
        ];

        foreach ($religions as $religion) {
            DB::table('religions')->insert([
                'religion_name' => $religion,
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
        Schema::dropIfExists('religions');
    }
};
