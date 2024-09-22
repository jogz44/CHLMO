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
        Schema::create('civil_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('civil_status', 50);
            $table->timestamps();
        });

        // insert civil statuses
        $civilStatuses = [
            'Single',
            'Married',
            'Divorced',
            'Widowed',
            'Separated'
        ];

        foreach ($civilStatuses as $civilStatus) {
            DB::table('civil_statuses')->insert([
                'civil_status' => $civilStatus,
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
        Schema::dropIfExists('civil_statuses');
    }
};
