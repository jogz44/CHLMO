<?php

namespace App\Livewire;

use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Support\Carbon;
use Livewire\Component;

class ShelterDashboard extends Component
{
    public $years = [], $selectedYear, $totalShelterApplicants = 0, $totalTagged = 0, $totalGrantees = 0;
    public $shelterApplicantsData, $originOfRequestData;

    public function mount()
    {
        $this->fetchYears();
        $this->updateCounts();
        $this->shelterApplicantsData = $this->getApplicantsData();
        $this->originOfRequestData = $this->getOriginOfRequestData();
    }

    public function getApplicantsData(): array
    {
        return [
            'labels' => $this->years,
            'shelterApplicants' => $this->getTotalByYear(ShelterApplicant::class, 'date_request'),
            'totalTagged' => $this->getTotalByYear(ProfiledTaggedApplicant::class, 'date_tagged', ['is_tagged' => true]),
            'grantees' => $this->getTotalByYear(Grantee::class, 'date_of_delivery'),
        ];
    }

    public function getOriginOfRequestData(): array
    {
        $originOfRequestIds = OriginOfRequest::whereIn('name', [
            'CMO',
            'SPMO',
            'Walk-in',
            'Referral',
            'Barangay'
        ])->pluck('id', 'name');

        $data = [];
        foreach ($originOfRequestIds as $name => $id) {
            // Applicants per origin
            $applicantsCount = ShelterApplicant::when($this->selectedYear !== 'Overall Total', function ($query) {
                $query->whereYear('date_request', $this->selectedYear);
            })
                ->where('request_origin_id', $id)
                ->count();

            // Awarded applicants per origin
            $granteesCount = Grantee::when($this->selectedYear !== 'Overall Total', function ($query) {
                $query->whereYear('date_of_delivery', $this->selectedYear);
            })
                ->whereHas('profiledTaggedApplicant', function ($query) use ($id) {
                    $query->whereHas('shelterApplicant', function ($query) use ($id) {
                        $query->where('request_origin_id', $id);
                    });
                })
                ->count();

            $data[$name] = [
                'applicants' => $applicantsCount,
                'grantees' => $granteesCount,
            ];
        }

        return $data;
    }



    protected function getTotalByYear($model, $dateField, $filters = [])
    {
        $query = $model::when($this->selectedYear !== 'Overall Total', function ($query) use ($dateField) {
            $query->whereYear($dateField, $this->selectedYear);
        });

        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->count();
    }

    protected function updateCounts()
    {
        $this->totalShelterApplicants = $this->getTotalByYear(ShelterApplicant::class, 'date_request');
        $this->totalTagged = $this->getTotalByYear(ShelterApplicant::class, 'date_request', ['is_tagged' => true]);
        $this->totalGrantees = $this->getTotalByYear(Grantee::class, 'date_of_delivery');
    }

    protected function fetchYears(): void
    {
        $this->years = ShelterApplicant::selectRaw('YEAR(date_request) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        array_unshift($this->years, 'Overall Total');
        $this->selectedYear = $this->years[0];
    }

    public function updatedSelectedYear(): void
    {
        $this->updateCounts();
        $this->shelterApplicantsData = $this->getApplicantsData();
        $this->originOfRequestData = $this->getOriginOfRequestData();
    }

    public function render()
    {
        return view('livewire.shelter-dashboard');
    }
}
