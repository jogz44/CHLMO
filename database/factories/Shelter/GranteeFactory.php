<?php

namespace Database\Factories\Shelter;

use App\Models\Shelter\Material;
use App\Models\Shelter\ProfiledTaggedApplicant;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\GranteeAttachmentList;
use Illuminate\Database\Eloquent\Factories\Factory;

class GranteeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Grantee::class;

    public function definition()
    {
        static $profiledTaggedApplicantIds;
        static $materialIds;

        if (!$profiledTaggedApplicantIds) {
            $profiledTaggedApplicantIds = ProfiledTaggedApplicant::pluck('id')->shuffle()->toArray();
        }

        if (!$materialIds) {
            $materialIds = Material::pluck('id')->shuffle()->toArray();
        }

        return [
            'profiled_tagged_applicant_id' => $this->faker->randomElement($profiledTaggedApplicantIds),
            'material_id' => $this->faker->randomElement($materialIds),
            'grantee_quantity' => $this->faker->numberBetween(100, 10000),
            'date_of_delivery' => $this->faker->dateTime(),
            'date_of_ris' => $this->faker->dateTime(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the grantee has attachments.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function withAttachments()
    {
        return $this->afterCreating(function (Grantee $grantee) {
            // Insert the attachments into the `grantee_attachment_lists` table
            GranteeAttachmentList::insert([
                [
                    'grantee_id' => $grantee->id,
                    'attachment_name' => 'Request Letter Address to City Mayor (photo)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'grantee_id' => $grantee->id,
                    'attachment_name' => 'Certificate of Indigency (photo)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'grantee_id' => $grantee->id,
                    'attachment_name' => 'Consent Letter (if the land is not theirs) (photo)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'grantee_id' => $grantee->id,
                    'attachment_name' => 'Photocopy of ID from the Land Owner (if the land is not theirs) (photo)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        });
    }
}
