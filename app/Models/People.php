<?php

namespace App\Models;

use App\Models\Shelter\ShelterApplicant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class People extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'suffix_name',
        'contact_number',
        'application_type'
    ];

    protected $casts = [
        'id' => 'integer'
    ];
    // Helper method to get full name
    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', [
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->suffix_name
        ]));
    }
    public function getFirstLastNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Check for existing applications with accurate application type checking
     *
     * @param string $firstName
     * @param string $lastName
     * @param string|null $middleName
     * @param string $applicationType Current application being attempted ('Housing Applicant' or 'Shelter Applicant')
     * @return array
     */
    public function checkExistingApplications($firstName, $lastName, string $middleName = null, $applicationType)
    {
        $query = self::where('first_name', 'LIKE', $firstName)
            ->where('last_name', 'LIKE', $lastName);

        if ($middleName) {
            $query->where('middle_name', 'LIKE', $middleName);
        }

        $existingPeople = $query->get();

        if ($existingPeople->isEmpty()) {
            return [
                'exists' => false,
                'applications' => []
            ];
        }

        $applications = [
            'housing' => false,
            'shelter' => false
        ];

        foreach ($existingPeople as $person) {
            if ($person->application_type === 'Housing Applicant') {
                $applications['housing'] = true;
            }
            if ($person->application_type === 'Shelter Applicant') {
                $applications['shelter'] = true;
            }
        }

        // Determine the appropriate message based on existing applications
        $message = '';
        if ($applicationType === 'Housing Applicant') {
            if ($applications['housing']) {
                $message = 'This person already has a Housing application. You cannot proceed with this transaction.';
            } elseif ($applications['shelter']) {
                $message = 'This person already has a Shelter application. Would you like to proceed with adding a Housing application?';
            }
        } else { // Shelter Applicant
            if ($applications['shelter']) {
                $message = 'This person already has a Shelter application. You cannot proceed with this transaction.';
            } elseif ($applications['housing']) {
                $message = 'This person already has a Housing application. Would you like to proceed with adding a Shelter application?';
            }
        }

        return [
            'exists' => true,
            'applications' => $applications,
            'message' => $message,
            'canProceed' => ($applicationType === 'Housing Applicant' && !$applications['housing']) ||
                ($applicationType === 'Shelter Applicant' && !$applications['shelter'])
        ];
    }
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'person_id');
    }

    public function shelterApplicants(): HasMany
    {
        return $this->hasMany(ShelterApplicant::class, 'person_id');
    }
}
