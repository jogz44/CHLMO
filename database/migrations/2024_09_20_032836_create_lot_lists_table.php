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
        Schema::create('lot_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barangay_id')->constrained('barangays')->onDelete('cascade'); // For the unit
            $table->string('lot_name', 255);
            $table->timestamps();
        });

        // Enable foreign key constraints before inserting the data
        Schema::enableForeignKeyConstraints();

        // Inserting Lots for each Barangay
        $this->seedLots();
    }

    private function seedLots(): void
    {
        $barangays = [
            1 => [
                'Purok 1 Relocation Site', 'Purok 1-B Relocation Site', 'Purok 1-C Relocation Site', 'Purok 1-D Relocation Site', 'Purok 1-E Relocation Site',
                'Purok 2 Relocation Site', 'Purok 2-A Relocation Site', 'Purok 3 Relocation Site', 'Purok 3-A Relocation Site', 'Purok 3-B Relocation Site',
                'Purok 3-C Relocation Site', 'Purok 3-E Relocation Site',
            ],
            2 => [
                'Purok Daisy Relocation Site', 'Purok Diamante Relocation Site',
            ],
            3 => [
                'Purok 6 Relocation Site'
            ],
            4 => [
                'Purok 2-Tandang Sora Relocation Site', 'Purok 3-Dagohoy San Vic. Relocation Site',
                'Purok 4-A Relocation Site',
            ],
            5 => [
                'Purok Bagani Relocation Site', 'Purok Caimito Relocation Site', 'Purok Humabon Relocation Site', 'Purok Liwliwa Relocation Site',
            ],
            6 => [
                'Purok 5 Relocation Site',
            ],
            7 => [
                'Purok 1 Relocation Site', 'Purok 2 Relocation Site', 'Purok 3 Relocation Site',
            ],
            8 => [
                'Purok 1 Relocation Site', 'Purok 1-A Relocation Site', 'Purok 1-C Relocation Site', 'Purok 1-D Relocation Site', 'Purok 1-E Relocation Site',
                'Purok 2 Relocation Site', 'Purok 3 Relocation Site', 'Purok 4 Relocation Site', 'Purok 5 Relocation Site', 'Purok 6 Relocation Site',
            ],
            9 => [
                'Purok 1 Relocation Site', 'Purok 1-A Relocation Site', 'Purok 2 Relocation Site', 'Purok 2-A Relocation Site', 'Purok  Relocation Site', 'Purok 4 Relocation Site', 'Purok 4-A Relocation Site',
                'Purok 5 Relocation Site', 'Purok 5-A Relocation Site', 'Purok 6 Relocation Site', 'Purok 6-A Relocation Site', 'Purok 7 Relocation Site', 'Purok 8 Relocation Site', 'Purok 8-Relocation Site',
                'Purok 8-B Relocation Site', 'Purok 8-C Relocation Site', 'Purok 9 Relocation Site', 'Purok 10 Relocation Site',
            ],
            10 => [
                'Purok Barabad/Durian Relocation Site, Maximina Relocation Site',
            ],
            11 => [
                'Purok Bougainvilla Relocation Site', 'Purok Bulaklak 1 Relocation Site', 'Purok Bulaklak 2 Relocation Site',
                'Purok Bulaklak 3 Relocation Site', 'Purok Bulaklak 4 Relocation Site', 'Purok Camia Relocation Site',
            ],
            12 => [
                'Purok Arellano Relocation Site', 'Purok Calachuchi Relocation Site', 'Purok Cristo Rey Relocation Site',
            ],
            13 => [
                'Purok Almasiga Relocation Site', 'Purok Castrince Relocation Site',
            ],
            14 => [
                'Purok Bayanihan Relocation Site', 'Purok Bagong Lipunan Relocation Site', 'Purok Busilak Relocation Site',
                'Purok Cristo Rey 1-B Relocation Site', 'Purok Cristo Rey Phase II Relocation Site',
            ],
            15 => [
                'Purok Aala Relocation Site', 'Purok Abaca Relocation Site', 'Purok Banana Relocation Site',
            ],
            16 => [
                'Purok 1-Mangga Relocation Site', 'Purok 2-Mansanitas Relocation Site', 'Purok 3 Relocation Site', 'Purok 4-Bayabas Relocation Site',
            ],
            17 => [
                'Purok 1 Relocation Site', 'Purok 2 Relocation Site', 'Purok 3 Relocation Site', 'Purok 4 Relocation Site'
            ],
            18 => [
                'Purok Alvarida Relocation Site', 'Purok Bagong Silang Relocation Site',
            ],
            19 => [
                'Purok Durian Relocation Site', 'Purok Lansones Relocation Site', 'Purok Lemon Relocation Site', 'Purok Mangga Relocation Site', 'Purok Marang Relocation Site',
            ],
            20 => [
                'Purok Dancing Lady Relocation Site', 'Purok Gumamela Relocation Site', 'Purok Ilang-Ilang Relocation Site',
            ],
            21 => [
                'Purok 1-Makabayan Village Relocation Site', 'Purok 2-Makabayan Village Relocation Site', 'Purok 3-Makabayan Village Relocation Site',
            ],
            22 => [
                'Purok 1 Relocation Site', 'Purok 1-A Relocation Site', 'Purok 1-B Narisma Comp. Relocation Site', 'Purok 2 Relocation Site', 'Purok 2-A Suico Comp. Relocation Site',
            ],
            23 => [
                'Purok Anahaw Relocation Site', 'Purok Aquarius Relocation Site',
            ]
        ];

        foreach ($barangays as $barangayId => $lots) {
            foreach ($lots as $lot) {
                DB::table('lot_lists')->insert([
                    'barangay_id' => $barangayId,
                    'lot_name' => $lot,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lot_lists');
    }
};
