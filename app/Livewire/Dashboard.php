<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\Blacklist;
use App\Models\LivingSituation;
use App\Models\TaggedAndValidatedApplicant;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $years = [], $selectedYear, $totalApplicants = 0, $totalTagged = 0, $totalAwardees = 0, $totalBlacklisted = 0;
    public $relocationLotData, $informalSettlersData;

    public function mount()
    {
        $this->fetchYears();
        $this->updateCounts();

        $this->relocationLotData = $this->getApplicantsData();
        $this->informalSettlersData = $this->getInformalSettlersData();
    }
    public function getApplicantsData(): array
    {
        // Generate monthly labels
        $labels = array_map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)), range(1, 12));

        $applicants = Applicant::where('transaction_type_id', 1)->count();

        return [
            'labels' => $labels,
            'applicants' => $this->getMonthlyData(
                Applicant::where('transaction_type_id', 1)
                    ->whereNotNull('date_applied')
                    ->select('date_applied')
                    ->get(),
                $labels
            ),
            'applicantsViaRequest' => $this->getMonthlyData(
                Applicant::where('transaction_type_id', 2)
                    ->whereNotNull('date_applied')
                    ->select('date_applied')
                    ->get(),
                $labels
            ),
        ];
    }
    public function getInformalSettlersData(): array
    {
        // Generate monthly labels
        $labels = array_map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)), range(1, 12));

        // Retrieve the IDs of the relevant living situations
        $livingSituationIds = LivingSituation::whereIn('living_situation_description', [
            'Affected by Government Infrastructure Projects',
            'Government Property',
            'With Court Order of Demolition and Eviction',
            'With Notice to Vacate',
            'Private Property',
            'Private Construction Projects',
            'Alienable and Disposable Land',
            'Danger Zone',
            'Other cases',
        ])->pluck('id');

        // Count data
        $informalSettlersApplicants = TaggedAndValidatedApplicant::whereIn('living_situation_id', $livingSituationIds)->count();

        // Return labels and monthly data arrays
        return [
            'labels' => $labels,
            'informalSettlers' => $this->getMonthlyData(
                TaggedAndValidatedApplicant::whereIn('living_situation_id', $livingSituationIds)
                    ->select('tagging_date')->get(),
                $labels
            ),
        ];
    }
    protected function getMonthlyData($data, $labels): array
    {
        $monthlyData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $month = (int) date('m', strtotime($item->date));
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
        // Get distinct years from Applicant model
        $this->years = Applicant::selectRaw('YEAR(date_applied) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Add "Overall Total" as the first option
        array_unshift($this->years, 'Overall Total');

        // Set default year to the first option (Overall Total)
        $this->selectedYear = $this->years[0];
    }
    protected function updateCounts()
    {
        if ($this->selectedYear === 'Overall Total') {
            // Total Applicants
            $this->totalApplicants = Applicant::count();

            // Total Tagged
            $this->totalTagged = Applicant::where('is_tagged', true)->count();

            // Total Awardees
            $this->totalAwardees = Awardee::count();

            // Total Blacklisted
            $this->totalBlacklisted = Awardee::where('is_blacklisted', true)->count();
        } else {
            // Filtered counts based on the selected year
            $this->totalApplicants = Applicant::whereYear('date_applied', $this->selectedYear)->count();
            $this->totalTagged = Applicant::whereYear('date_applied', $this->selectedYear)->where('is_tagged', true)->count();
            $this->totalAwardees = Awardee::whereHas('taggedAndValidatedApplicant', function ($query) {
                $query->whereYear('tagging_date', $this->selectedYear);
            })->count();
            $this->totalBlacklisted = Awardee::whereHas('taggedAndValidatedApplicant', function ($query) {
                $query->whereYear('tagging_date', $this->selectedYear);
            })->where('is_blacklisted', true)->count();
        }
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
