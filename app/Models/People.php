<?php

namespace App\Models;

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
    // Controller method for autocomplete
    public function searchPeople(Request $request)
    {
        $search = $request->get('search');

        return People::where('first_name', 'LIKE', "%{$search}%")
            ->orWhere('last_name', 'LIKE', "%{$search}%")
            ->with(['housingApplications', 'shelterApplications'])
            ->get()
            ->map(function ($person) {
                return [
                    'id' => $person->id,
                    'full_name' => $person->full_name,
                    'has_housing_application' => $person->housingApplications->count() > 0,
                    'has_shelter_application' => $person->shelterApplications->count() > 0,
                    'applications' => [
                        'housing' => $person->housingApplications->map(function ($app) {
                            return [
                                'id' => $app->id,
                                'date_applied' => $app->date_applied,
                                'status' => $app->is_tagged
                            ];
                        }),
                        'shelter' => $person->shelterApplications->map(function ($app) {
                            return [
                                'id' => $app->id,
                                'date_request' => $app->date_request,
                                'status' => $app->is_tagged
                            ];
                        })
                    ]
                ];
            });
    }
    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class, 'person_id', 'id');
    }
}
