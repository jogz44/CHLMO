<?php

namespace App\Livewire;

use App\Models\Applicant;
use Illuminate\Support\Carbon;
use Livewire\Component;

class WalkinTransaction extends Component
{
    public $date_applied;
    public $first_name;
    public $middle_name;
    public $last_name;
    public $suffix_name;

    public function mount()
    {
        $this->date_applied = Carbon::now()->format('Y-m-d');
        // Optionally initialize other fields if needed
        $this->first_name = '';
        $this->middle_name = '';
        $this->last_name = '';
        $this->suffix_name = '';
        $this->region_text = '';
    }
    public function createNewApplicant()
    {
        Applicant::create([
            'date_applied' => $this->date_applied,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'suffix_name' => $this->suffix_name,
            'region_text' => $this->region_text,
        ]);
    }

    public function render()
    {
        return view('livewire.walkin-transaction');
    }
}
