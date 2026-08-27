<?php

namespace App\Livewire;

use App\Models\Shelter\ShelterApplicant;
use App\Models\Shelter\Grantee;
use App\Models\Shelter\OriginOfRequest;
use App\Models\Shelter\ProfiledTaggedApplicant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShelterDashboard extends Component
{
    public $years = [], $selectedYear, $totalShelterApplicants = 0, $totalTagged = 0, $totalGrantees = 0;
    public $shelterApplicantsData, $originOfRequestData, $barangayData;

    public function mount()
    {
        $this->fetchYears();
        $this->updateCounts();
        $this->shelterApplicantsData = $this->getApplicantsData();
        $this->originOfRequestData = $this->getOriginOfRequestData();
        $this->barangayData = $this->getBarangayData();
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

    /**
     * Number of ShelterApplicant records per barangay, via
     * ShelterApplicant -> Address (address_id) -> Barangay (barangay_id).
     * Filtered by date_request year, same as the rest of this dashboard.
     */
    public function getBarangayData(): array
    {
        $query = ShelterApplicant::query()
            ->join('addresses', 'shelter_applicants.address_id', '=', 'addresses.id')
            ->join('barangays', 'addresses.barangay_id', '=', 'barangays.id')
            ->select('barangays.name as barangay_name', DB::raw('count(*) as total'))
            ->groupBy('barangays.name');

        if ($this->selectedYear !== 'Overall Total') {
            $query->whereYear('shelter_applicants.date_request', $this->selectedYear);
        }

        $results = $query->orderByDesc('total')->get();

        return [
            'labels' => $results->pluck('barangay_name')->toArray(),
            'counts' => $results->pluck('total')->toArray(),
        ];
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
        $this->years = ShelterApplicant::selectRaw($this->yearSelectExpression('date_request'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        array_unshift($this->years, 'Overall Total');
        $this->selectedYear = $this->years[0];
    }

    protected function yearSelectExpression(string $column): string
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return "strftime('%Y', {$column}) as year";
        }

        return "YEAR({$column}) as year";
    }

    public function updatedSelectedYear(): void
    {
        $this->updateCounts();
        $this->shelterApplicantsData = $this->getApplicantsData();
        $this->originOfRequestData = $this->getOriginOfRequestData();
        $this->barangayData = $this->getBarangayData();
    }

    public function render()
    {
        return view('livewire.shelter-dashboard');
    }
}