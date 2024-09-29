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

        // Inserting Puroks for each Barangay
        $this->seedPuroks();
    }

    private function seedPuroks()
    {
        $barangays = [
            1 => [
                'Purok 1', 'Purok 1-B', 'Purok 1-C', 'Purok 1-D', 'Purok 1-E',
                'Purok 2', 'Purok 2-A', 'Purok 3', 'Purok 3-A', 'Purok 3-B',
                'Purok 3-C', 'Purok 3-E', 'Purok 3-F', 'Purok 3-G', 'Purok 3-H',
                'Purok 4-A', 'Purok 4-B', 'Purok 4-C', 'Purok 4-D', 'Purok 4-E',
                'Purok 4-F', 'Purok 4-G', 'Purok 4-H', 'Purok 5', 'Purok 5-A',
                'Purok 6', 'Purok 6-A', 'Purok 6-B', 'Purok 7'
            ],
            2 => [
                'Purok Daisy', 'Purok Diamante', 'Purok Euphorbia', 'Purok Everlasting',
                'Purok Gumamela', 'Purok Ilang-Ilang', 'Purok Mangga', 'Purok Orchids',
                'Purok Rosal', 'Purok Rose', 'Purok Sampaguita', 'Purok Santan',
                'Purok Sunflower', 'Purok Daisy', 'Purok Waling-Waling'
            ],
            3 => [
                'Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6'
            ],
            4 => [
                'Purok 1-Rizal', 'Purok 1-Rizal/Tiongko Village', 'Purok 1-B Velasco Urban',
                'Purok 2-Tandang Sora', 'Purok 3-Dagohoy San Vic.', 'Purok 3-A Dagohoy',
                'Purok 4.', 'Purok 4-A', 'Purok 5-Mabini.', 'Purok 5-A Dagohoy',
                'Purok 6-', 'Purok 6-A '
            ],
            5 => [
                'Purok Bagani', 'Purok Caimito', 'Purok Humabon', 'Purok Liwliwa',
                'Purok Maharlika', 'Purok Mercury', 'Purok Namnama', 'Purok Narra',
                'Purok Pagkakaisa', 'Purok San Antonio', 'Purok Satum', 'Purok Santo Nino'
            ],
            6 => [
                'Purok 1', 'Purok 2', 'Purok 2-B', 'Purok 3', 'Purok 3-A',
                'Purok 4', 'Purok 5', 'Purok 6', 'Purok 7', 'Purok 8',
                'Purok 9', 'Purok 10'
            ],
            7 => [
                'Purok 1', 'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6'
            ],
            8 => [
                'Purok 1', 'Purok 1-A', 'Purok 1-C', 'Purok 1-D', 'Purok 1-E',
                'Purok 2', 'Purok 3', 'Purok 4', 'Purok 5', 'Purok 6',
                'Purok 7', 'Purok 8', 'Purok 9', 'Purok 10', 'Purok 11',
                'Purok 12', 'Purok 13', 'Purok 14', 'Purok 15', 'Purok 16',
                'Purok 17', 'Purok 18-A', 'Purok 18-B', 'Purok 19', 'Purok 20',
                'Purok 21', 'Purok 22', 'Purok 23', 'Purok 24', 'Purok 25',
                'Purok 26', 'Purok 27', 'Purok 28-A', 'Purok 28-B', 'Purok 28-C', 'Purok 29'
            ],
            9 => [
                'Purok 1', 'Purok 1-A', 'Purok 2', 'Purok 2-A', 'Purok 3', 'Purok 4', 'Purok 4-A',
                'Purok 5', 'Purok 56-A', 'Purok 6', 'Purok 6-A', 'Purok 7', 'Purok 8', 'Purok 8-A',
                'Purok 8-B', 'Purok 8-C', 'Purok 9', 'Purok 10',
            ],
            10 => [
                'Purok Barabad/Durian, Maximina', 'Purok Catiben', 'Purok Cherry Blossom',
                'Purok DANECO Village', 'Purok Doctolero', 'Purok Durian',
                'Purok Ferraren Shineville', 'Purok Liwayway', 'Purok Lorenzo Village',
                'Purok Maharlika', 'Purok Malinawon', 'Purok Malinawon Homes',
                'Purok Melendres', 'Purok Mencidor', 'Purok Mencidor Village',
                'Purok Nangka', 'Purok Narra', 'Purok Popular',
                'Purok RJP II', 'Purok Rupenta 1', 'Purok Rupenta 2',
                'Purok Talisay 55', 'Purok Talisay 56', 'Purok Talisay Zafra',
                'Purok Tipaz'
            ],
            11 => [
                'Purok Bougainvilla', 'Purok Bulaklak 1', 'Purok Bulaklak 2',
                'Purok Bulaklak 3', 'Purok Bulaklak 4', 'Purok Camia',
                'Purok Delfina', 'Purok Diamond 1', 'Purok Diamond 2',
                'Purok Durian', 'Purok Everlasting', 'Purok Gumamela',
                'Purok Kalamboan', 'Purok Matinabangon', 'Purok Orchids',
                'Purok Pine Tree', 'Purok Poinsettia', 'Purok Sampaguita',
                'Purok Santan', 'Purok Suaybagiuo-A', 'Purok Suaybaguio-B',
                'Purok Suaybagiuo-C', 'Talisay'
            ],
            12 => [
                'Purok Arellano', 'Purok Calachuchi', 'Purok Cristo Rey',
                'Purok Dagohoy', 'Purok Gumamela', 'Purok Kayumanggi',
                'Purok Lapu-lapu', 'Purok Malinawon 1', 'Purok Marilag 1',
                'Purok Marilag 2', 'Purok Orchids', 'Purok Paraiso',
                'Purok Sampaguita', 'Purok Matinabangon', 'Purok Pine Tree',
                'Purok Poinsettia', 'Purok Sulgreg', 'Purok Sunflower',
                'Purok Talisay', 'Purok Tandang Sora'
            ],
            13 => [
                'Purok Almasiga', 'Purok Castrince', 'Purok Cervantes',
                'Purok Durian 205', 'Purok Emil Sison', 'Purok Exodus',
                'Purok Kalayaan', 'Purok Katuparan', 'Purok Liwayway',
                'Purok Luzvimin', 'Purok Maalam', 'Purok Malinawon',
                'Purok Malinis', 'Purok Marangal', 'Purok Mauswagon',
                'Purok Orange Valley', 'Purok Pag-asa', 'Purok Pag-ibig 1',
                'Purok na Rafael', 'Purok Sunflower', 'Purok Villa Rosal'
            ],
            14 => [
                'Purok Bayanihan', 'Purok Bagong Lipunan', 'Purok Busilak',
                'Purok Cristo Rey 1-B', 'Purok Cristo Rey Phase II',
                'Purok De Oro', 'Purok Durian B', 'Purok Gulayan',
                'Purok Kaunlaran', 'Purok Kawayan', 'Purok Liwanag',
                'Purok Mahusay', 'Purok Malipayon', 'Purok Mansanitas',
                'Purok Masagana', 'Purok Pag-asa', 'Purok Pagkakaisa',
                'Purok Panabang', 'Purok Sampaguita',
                'Purok Talisay Seminary', 'Purok Vitapil',
                'Purok Visayas', 'Purok Waling-waling'
            ],
            15 => [
                'Purok Aala', 'Purok Abaca', 'Purok Banana',
                'Purok Bautista', 'Purok Cabanisas', 'Purok Caimito',
                'Purok Capitol', 'Purok Carig', 'Purok Country Homes',
                'Purok Dela Cruz', 'Purok Durian', 'Purok Galingan',
                'Purok Garcia', 'Purok Garciaville', 'Purok Greenland',
                'Purok Gulayan', 'Purok Ilocandia', 'Purok Kalubiran',
                'Purok Lemonsito', 'Purok Lumboy', 'Purok Lynville',
                'Purok Magkidong', 'Purok Magsanoc', 'Purok Magtalisay',
                'Purok Maligaya', 'Purok Mangga', 'Purok Margarita',
                'Purok Maximo', 'Purok Orchids', 'Purok Pag-ibig',
                'Purok Papaya', 'Purok Pioneer', 'Purok Tadena',
                'Purok Union Village', 'Purok Uraya', 'Purok Villa Cacacho',
                'Purok Villa Magsanoc', 'Purok Villa Patricia'
            ],
            16 => [
                'Purok 1-Mangga', 'Purok 2-Mansanitas', 'Purok 3', 'Purok 4-Bayabas',
                'Purok 5', 'Purok 6', 'Purok 7'
            ],
            17 => [
                'Purok 1', 'Purok 2', 'Purok 3', 'Purok 4'
            ],
            18 => [
                'Purok Alvarida', 'Purok Bagong Silang', 'Purok Bayanihan',
                'Purok Farm 3', 'Purok Ilvi', 'Purok Kalubihan', 'Purok Maduaw', 'Purok Pagkakaisa',
                'Purok Rancho', 'Purok San Isidro', 'Purok Sta Cruz', 'Purok Sto. Ninyo'
            ],
            19 => [
                'Purok Durian', 'Purok Lansones', 'Purok Lemon', 'Purok Mangga', 'Purok Marang',
                'Purok Nangka', 'Purok Santol'
            ],
            20 => [
                'Purok Dancing Lady', 'Purok Gumamela', 'Purok Ilang-Ilang',
                'Purok Ipil-Ipil', 'Purok Mangga', 'Purok Rosal', 'Purok Waling-Waling'
            ],
            21 => [
                'Purok 1-Makabayan Village', 'Purok 2-Makabayan Village', 'Purok 3-Makabayan Village',
                'Purok 4-Makabayan Village', 'Purok 5-Makabayan Village', 'Purok 15-Panaghiusa',
                'Purok Alambre', 'Purok Baluno', 'Purok Bang-gag', 'Purok Bantacan', 'Purok Cabadiangan',
                'Purok Durian', 'Purok Panitan', 'Purok Poblacion', 'Purok Sinalikway', 'Purok Tulay', 'Purok Wakan'
            ],
            22 => [
                'Purok 1', 'Purok 1-A', 'Purok 1-B Narisma Comp.', 'Purok 2', 'Purok 2-A Suico Comp.',
                'Purok 3-A Erlynville Subd.', 'Purok 3-B North Eagle\'s Home II', 'Purok 3-C Villa Verde Subd.',
                'Purok 3-D Abatayo Comp.', 'Purok 3-East Durian', 'Purok 3-West Durian', 'Purok 4-BLISS',
                'Purok 5', 'Purok 5-A', 'Purok 5-B North Eagle Home 4', 'Purok 6', 'Purok 6-A Estabillo Homes',
                'Purok 7', 'Purok 8', 'Purok 8-A Laureta Homes', 'Purok 9', 'Purok 10', 'Purok 10-A', 'Purok 11',
                'Purok 11-A', 'Purok 12', 'Purok 13', 'Purok 13-A', 'Purok 14'
            ],
            23 => [
                'Purok Anahaw', 'Purok Aquarius', 'Purok Basakan ', 'Purok Bayabas', 'Purok Bayanihan', 'Purok Budiongan',
                'Purok Buli', 'Purok Bunga', 'Purok Cabilto', 'Purok Cacao', 'Purok Cadena de Amor', 'Purok Cafe',
                'Purok Caimito', 'Purok Calachuchi', 'Purok Capagngan', 'Purok Cattleya', 'Purok Cebole', 'Purok C.E. Maurillo',
                'Purok Cogon', 'Purok Dahlia', 'Purok Daisy', 'Purok Dara', 'Purok Dreamville', 'Purok Durian', 'Purok Everlasting',
                'Purok Gabayan I', 'Purok Gabayan II', 'Purok Gementiza', 'Purok Ilang-Ilang', 'Purok Ipil-Ipil', 'Purok Jalandoni',
                'Purok Jeth Village', 'Purok kahayag', 'Purok Kalipay', 'Purok Landing', 'Purok Lanzones', 'Purok Libra', 'Purok Macopa',
                'Purok Maharlika', 'Purok Mahogany', 'Purok Malinawon', 'Purok Margarette', 'Purok Narra', 'Purok N.E. Baysa', 'Purok Nazareno',
                'Purok North Eagle', 'Purok Orchids', 'Purok Pag-asa', 'Purok Pagbati', 'Purok Pag-ibig 1', 'Purok Pag-ibig 2', 'Purok Pagkakaisa',
                'Purok paglaum', 'Purok Pagmamahal', 'Purok Pahiyum', 'Purok Palmera', 'Purok Pinya', 'Purok Pioneer', 'Purok Rambutan',
                'Purok Renzo', 'Purok Rosal', 'Purok Saging', 'Purok Sambag', 'Purok Sampaguita 1', 'Purok Sampaguita 2', 'Purok San Roque',
                'Purok Santan', 'Purok Sto. Nino', 'Purok Sudlon', 'Purok Sunshine 1', 'Purok Sunshine 2', 'Purok St. Therese', 'Purok Talisay 1',
                'Purok Talisay 2', 'Purok Timog', 'Purok Villa Paraiso', 'Purok Waling-waling', 'Purok White Dove'
            ]
        ];
        foreach ($barangays as $barangayId => $puroks) {
            foreach ($puroks as $purokName) {
                DB::table('puroks')->insert([
                    'barangay_id' => $barangayId,
                    'name' => $purokName,
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
        Schema::dropIfExists('puroks');
    }
};
