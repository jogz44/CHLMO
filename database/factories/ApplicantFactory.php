<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Barangay;
use App\Models\CivilStatus;
use App\Models\People;
use App\Models\Purok;
use App\Models\Spouse;
use App\Models\TransactionType;
use App\Models\Tribe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Applicant;
use App\Models\User;
use RuntimeException;

class ApplicantFactory extends Factory
{
    protected $model = Applicant::class;

    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $transactionTypeIds = TransactionType::pluck('id')->toArray();

        // Fetch IDs only if not already cached and ensure addresses exist
        $addressIds = Address::exists() ? Address::pluck('id')->toArray() : [];

        if (empty($addressIds)) {
            throw new RuntimeException('No addresses available to assign to applicants. Please seed the addresses table first.');
        }

        return [
            'applicant_id' => Applicant::generateApplicantId(),
            'person_id' => People::factory(), // Generates a related People model
            'user_id' => 1, // Generates a related User model
            'transaction_type_id' => fake()->randomElement($transactionTypeIds), // Generates a related TransactionType model
            'address_id' => fake()->randomElement($addressIds),
            'date_applied' => $this->faker->dateTimeBetween('-1 year', 'now'), // Random date within the last year
            'initially_interviewed_by' => 1, // Assumes this is a User ID, could be another relation
            'is_tagged' => false
        ];
    }
}
