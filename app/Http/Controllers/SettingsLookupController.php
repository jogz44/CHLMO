<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\CivilStatus;
use App\Models\GovernmentProgram;
use App\Models\LivingSituation;
use App\Models\LivingStatus;
use App\Models\Purok;
use App\Models\Religion;
use App\Models\Tribe;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SettingsLookupController extends Controller
{
    private const LOOKUPS = [
        'civil-status' => [
            'model' => CivilStatus::class,
            'table' => 'civil_statuses',
            'column' => 'civil_status',
            'label' => 'Civil Status',
        ],
        'tribe' => [
            'model' => Tribe::class,
            'table' => 'tribes',
            'column' => 'tribe_name',
            'label' => 'Tribe/Ethnicity',
        ],
        'religion' => [
            'model' => Religion::class,
            'table' => 'religions',
            'column' => 'religion_name',
            'label' => 'Religion',
        ],
        'living-situation' => [
            'model' => LivingSituation::class,
            'table' => 'living_situations',
            'column' => 'living_situation_description',
            'label' => 'Living Situation',
        ],
        'case-specification' => [
            'model' => CaseSpecification::class,
            'table' => 'case_specifications',
            'column' => 'case_specification_name',
            'label' => 'Case Specification',
        ],
        'living-status' => [
            'model' => LivingStatus::class,
            'table' => 'living_statuses',
            'column' => 'living_status_name',
            'label' => 'Living Status',
        ],
        'barangay' => [
            'model' => Barangay::class,
            'table' => 'barangays',
            'column' => 'name',
            'label' => 'Barangay',
        ],
        'social-welfare-sector' => [
            'model' => GovernmentProgram::class,
            'table' => 'government_programs',
            'column' => 'program_name',
            'label' => 'Social Welfare Sector',
        ],
    ];

    public function store(Request $request, string $key): RedirectResponse
    {
        if ($key === 'purok') {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('puroks', 'name')->where('barangay_id', $request->input('barangay_id')),
                ],
                'barangay_id' => ['required', 'exists:barangays,id'],
            ]);

            Purok::create($validated);

            return back()->with('message', 'Purok added successfully.');
        }

        $lookup = $this->lookup($key);
        $column = $lookup['column'];

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique($lookup['table'], $column)],
        ]);

        $lookup['model']::create([
            $column => $validated['name'],
        ]);

        return back()->with('message', $lookup['label'] . ' added successfully.');
    }

    public function destroy(string $key, int $id): RedirectResponse
    {
        try {
            if ($key === 'purok') {
                Purok::findOrFail($id)->delete();

                return back()->with('message', 'Purok removed successfully.');
            }

            $lookup = $this->lookup($key);
            $lookup['model']::findOrFail($id)->delete();

            return back()->with('message', $lookup['label'] . ' removed successfully.');
        } catch (QueryException) {
            return back()->withErrors([
                'delete' => 'This record is already used by another part of the system and cannot be removed.',
            ]);
        }
    }

    private function lookup(string $key): array
    {
        abort_unless(array_key_exists($key, self::LOOKUPS), 404);

        return self::LOOKUPS[$key];
    }
}
