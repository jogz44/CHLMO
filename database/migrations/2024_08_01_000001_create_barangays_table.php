<?php

use App\Models\Barangay;
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
        Schema::create('barangays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();

        $barangayLists = [
            'Apokon', 'Bincungan', 'Busaon', 'Canocotan', 'Cuambogan', 'La Filipina', 'Liboganon', 'Madaum', 'Magdum',
            'Magugpo East', 'Magugpo North', 'Magugpo Poblacion', 'Magugpo South', 'Magugpo West', 'Mankilam', 'New Balamban',
            'Nueva Fuerza', 'Pagsabangan', 'Pandapan', 'San Agustin', 'San Isidro', 'San Miguel', 'Visayan Village',
        ];

        // Prepare data for insertion
        $barangayData = [];
        foreach ($barangayLists as $barangayName) {
            $barangayData[] = ['name' => $barangayName];
        }

        // Insert Barangay data
        DB::table('barangays')->insert($barangayData);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangays');
    }
};
