<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CivilStatus;
use App\Models\Tribe;
use App\Models\Religion;
use App\Models\LivingSituation;
use App\Models\CaseSpecification;
use App\Models\Barangay;
use App\Models\Purok;
use App\Models\GovernmentProgram;
use App\Livewire\Logs\ActivityLogs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ShelterSystemConfiguration extends Component
{
    private array $lookupConfig = [
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

    public array $search = [];
    public array $newValue = [];

    // purok
    public string $newPurok = '';
    public $barangay_id = '';
    public string $purokSearch = '';

    public bool $showConfirmModal = false;
    public ?string $confirmType = null;
    public ?int $confirmId = null;

    public function mount(): void
    {
        foreach (array_keys($this->lookupConfig) as $key) {
            $this->search[$key] = '';
            $this->newValue[$key] = '';
        }
    }

    private function config(string $type): array
    {
        abort_unless(array_key_exists($type, $this->lookupConfig), 404);

        return $this->lookupConfig[$type];
    }

    public function getCardsProperty()
    {
        return collect($this->lookupConfig)->map(function ($cfg, $key) {
            $term = trim($this->search[$key] ?? '');

            $query = $cfg['model']::query()
                ->select(['id', $cfg['column']])
                ->orderBy($cfg['column']);

            if ($term !== '') {
                $query->where($cfg['column'], 'like', "%{$term}%");
            }

            return [
                'key' => $key,
                'label' => $cfg['label'],
                'column' => $cfg['column'],
                'items' => $query->get(),
                'total' => $cfg['model']::count(),
            ];
        })->values();
    }

        public function getPuroksProperty()
    {
        $term = trim($this->purokSearch);

        $query = Purok::with('barangay')->orderBy('name');

        if ($term !== '') {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhereHas('barangay', fn ($b) => $b->where('name', 'like', "%{$term}%"));
            });
        }

        return $query->get();
    }

    public function getBarangaysProperty()
    {
        return Barangay::orderBy('name')->get(['id', 'name']);
    }

    public function addItem(string $type): void
    {
        $cfg = $this->config($type);

        $this->validate([
            "newValue.$type" => ['required', 'string', 'max:255', Rule::unique($cfg['table'], $cfg['column'])],
        ]);

        $cfg['model']::create([$cfg['column'] => $this->newValue[$type]]);

        (new ActivityLogs())->logActivity('Add New ' . $cfg['label'], Auth::user());

        $this->newValue[$type] = '';
        session()->flash('message', $cfg['label'] . ' added successfully.');
    }

        public function addPurok(): void
    {
        $this->validate([
            'newPurok' => [
                'required', 'string', 'max:255',
                Rule::unique('puroks', 'name')->where('barangay_id', $this->barangay_id),
            ],
            'barangay_id' => ['required', 'exists:barangays,id'],
        ]);

        Purok::create([
            'name' => $this->newPurok,
            'barangay_id' => $this->barangay_id,
        ]);

        (new ActivityLogs())->logActivity('Add New Purok', Auth::user());

        $this->newPurok = '';
        $this->barangay_id = '';
        session()->flash('message', 'Purok added successfully.');
    }

    public function confirmRemove(string $type, int $id): void
    {
        $this->confirmType = $type;
        $this->confirmId = $id;
        $this->showConfirmModal = true;
    }

    public function cancelRemove(): void
    {
        $this->reset(['confirmType', 'confirmId', 'showConfirmModal']);
    }

    public function removeConfirmed(): void
    {
        if (! $this->confirmType || ! $this->confirmId) {
            return;
        }

        try {
            $cfg = $this->config($this->confirmType);
            $cfg['model']::findOrFail($this->confirmId)->delete();

            (new ActivityLogs())->logActivity('Remove ' . $cfg['label'], Auth::user());
            session()->flash('message', $cfg['label'] . ' removed successfully.');
        } catch (\Illuminate\Database\QueryException) {
            session()->flash('error', 'This record is already used elsewhere and cannot be removed.');
        }

        $this->reset(['confirmType', 'confirmId', 'showConfirmModal']);
    }

    public function render()
    {
        return view('livewire.shelter-system-configuration');
    }
}