<?php

use App\Models\Purok;
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
        Schema::create('puroks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id')->constrained('barangays')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        // Enable foreign key constraints before inserting the data
        Schema::enableForeignKeyConstraints();

        // Insert actual Purok data while linking it to corresponding Barangays
        DB::table('puroks')->insert([
            // Example data for Barangay 1
            ['name' => 'Purok 1A', 'barangay_id' => 1],  // Links to Barangay 1
            ['name' => 'Purok 1B', 'barangay_id' => 1],  // Links to Barangay 1

            // Example data for Barangay 2
            ['name' => 'Purok 2A', 'barangay_id' => 2],  // Links to Barangay 2
            ['name' => 'Purok 2B', 'barangay_id' => 2],  // Links to Barangay 2

            // Example data for Barangay 3
            ['name' => 'Purok 3A', 'barangay_id' => 3],  // Links to Barangay 3
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puroks');
    }
};
