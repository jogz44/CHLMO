<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CivilStatus;
use App\Models\Tribe;
use App\Models\Religion;
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
    ];

    public array $search = [];
    public array $newValue = [];

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