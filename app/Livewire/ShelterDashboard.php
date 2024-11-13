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
        // Generate monthly labels
        $labels = array_map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)), range(1, 12));

        // Retrieve shelter applicants data for monthly count
        return [
            'labels' => $labels,
            'shelterApplicants' => $this->getMonthlyData(
                ShelterApplicant::whereNotNull('date_request')->select('date_request')->get(),
                $labels
            ),
            'totalTagged' => $this->getMonthlyData(
                ProfiledTaggedApplicant::where('is_tagged', true)->whereNotNull('date_tagged')->select('date_tagged')->get(),
                $labels
            ),
            'grantees' => $this->getMonthlyData(
                Grantee::whereNotNull('date_of_delivery')->select('date_of_delivery')->get(),
                $labels
            ),
        ];
    }


    protected function getMonthlyData($data, $labels): array
    {
        $monthlyData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $month = (int) date('m', strtotime($item->date_request)); // corrected field name
            $monthlyData[$month - 1]++;
        }
        return $monthlyData;
    }

    public function updatedSelectedYear(): void
    {
        $this->updateCounts();
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

    protected function updateCounts()
    {
        if ($this->selectedYear === 'Overall Total') {
            $this->totalShelterApplicants = ShelterApplicant::count();
            $this->totalTagged = ShelterApplicant::where('is_tagged', true)->count();
            $this->totalGrantees = Grantee::count();
        } else {
            $this->totalShelterApplicants = ShelterApplicant::whereYear('date_request', $this->selectedYear)->count();
            $this->totalTagged = ShelterApplicant::whereYear('date_request', $this->selectedYear)->where('is_tagged', true)->count();
            $this->totalGrantees = Grantee::whereYear('date_of_delivery', $this->selectedYear)->count();
        }
    }

    // public function getOriginOfRequestData(): array
    // {
    //     $labels = array_map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)), range(1, 12));

    //     // Get each origin of request by name and fetch monthly data separately for each
    //     $cmoData = $this->getMonthlyData(
    //         ShelterApplicant::whereHas('originOfRequest', fn($q) => $q->where('name', 'CMO'))->select('date_request')->get(),
    //         $labels
    //     );
    //     $spmoData = $this->getMonthlyData(
    //         ShelterApplicant::whereHas('originOfRequest', fn($q) => $q->where('name', 'SPMO'))->select('date_request')->get(),
    //         $labels
    //     );
    //     $walkInData = $this->getMonthlyData(
    //         ShelterApplicant::whereHas('originOfRequest', fn($q) => $q->where('name', 'Walk-in'))->select('date_request')->get(),
    //         $labels
    //     );
    //     $referralData = $this->getMonthlyData(
    //         ShelterApplicant::whereHas('originOfRequest', fn($q) => $q->where('name', 'Referral'))->select('date_request')->get(),
    //         $labels
    //     );
    //     $barangayData = $this->getMonthlyData(
    //         ShelterApplicant::whereHas('originOfRequest', fn($q) => $q->where('name', 'Barangay'))->select('date_request')->get(),
    //         $labels
    //     );

    //     return [
    //         'labels' => $labels,
    //         'CMO' => $cmoData,
    //         'SPMO' => $spmoData,
    //         'Walk-in' => $walkInData,
    //         'Referral' => $referralData,
    //         'Barangay' => $barangayData,
    //     ];
    // }
    public function getOriginOfRequestData(): array
    {
        // Generate monthly labels
        $labels = array_map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)), range(1, 12));

        // Retrieve the IDs of the relevant living situations
        $originOfRequestIds = OriginOfRequest::whereIn('name', [
            'CMO',
            'SPMO',
            'Walk-in',
            'Referral',
            'Barangay',
        ])->pluck('id');

        // Count data
        $originOfRequests = ShelterApplicant::whereIn('request_origin_id', $originOfRequestIds)->count();

        // Return labels and monthly data arrays
        return [
            'labels' => $labels,
            'originOfRequests' => $this->getMonthlyData(
                ShelterApplicant::whereIn('request_origin_id', $originOfRequestIds)
                    ->select('date_request')->get(),
                $labels
            ),
        ];
    }

    public function render()
    {
        return view('livewire.shelter-dashboard');
    }
}
