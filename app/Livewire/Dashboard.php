<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Awardee;
use App\Models\Blacklist;
use App\Models\LivingSituation;
use App\Models\TaggedAndValidatedApplicant;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $years = [], $selectedYear, $totalApplicants = 0, $totalTagged = 0, $totalAwardees = 0, $totalBlacklisted = 0;
    public $relocationLotData, $informalSettlersData;

    public function mount()
    {
        $this->fetchYears();
        $this->updateCounts();
        $this->updateCharts();
    }

    /**
     * Recomputes both chart datasets for the currently selected year
     * and pushes the fresh data to the client via a browser event,
     * since the canvases are wire:ignore'd and Livewire won't
     * re-render them on its own.
     */
    protected function updateCharts(): void
    {
        $this->relocationLotData = $this->getApplicantsData();
        $this->informalSettlersData = $this->getInformalSettlersData();

        $this->dispatch(
            'charts-updated',
            relocationLotData: $this->relocationLotData,
            informalSettlersData: $this->informalSettlersData,
        );
    }

    public function getApplicantsData(): array
    {
        // Generate monthly labels
        $labels = array_map(fn($month) => date('M', mktime(0, 0, 0, $month, 1)), range(1, 12));

        // Get all distinct transaction types present in the table
        $transactionTypes = Applicant::whereNotNull('transaction_type')
            ->distinct()
            ->pluck('transaction_type');

        $datasets = [];
        foreach ($transactionTypes as $type) {
            $query = Applicant::where('transaction_type', $type)
                ->whereNotNull('date_applied');

            if ($this->selectedYear !== 'Overall Total') {
                $query->whereYear('date_applied', $this->selectedYear);
            }

            $records = $query->select('date_applied')->get();

            $datasets[$type] = $this->getApplicantsMonthlyData($records, $labels);
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets, // e.g. ['Walk-in' => [...12 months...], 'Online' => [...]]
        ];
    }

    public function getInformalSettlersData(): array
    {
        // Pull the relevant living situations (in a fixed, readable order)
        $livingSituations = LivingSituation::whereIn('living_situation_description', [
            'Affected by Government Infrastructure Projects',
            'Government Property',
            'With Court Order of Demolition and Eviction',
            'With Notice to Vacate',
            'Private Property',
            'Private Construction Projects',
            'Alienable and Disposable Land',
            'Danger Zone',
            'Other cases',
        ])->get();

        $labels = [];
        $counts = [];

        foreach ($livingSituations as $situation) {
            $query = TaggedAndValidatedApplicant::where('living_situation_id', $situation->id);

            if ($this->selectedYear !== 'Overall Total') {
                $query->whereYear('tagging_date', $this->selectedYear);
            }

            $labels[] = $situation->living_situation_description;
            $counts[] = $query->count();
        }

        return [
            'labels' => $labels,
            'informalSettlers' => $counts, // count of applicants per living situation
        ];
    }

    protected function getApplicantsMonthlyData($data, $labels): array
    {
        $monthlyData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $month = (int) date('m', strtotime($item->date_applied));
            $monthlyData[$month - 1]++;
        }
        return $monthlyData;
    }

    public function updatedSelectedYear(): void
    {
        $this->updateCounts();
        $this->updateCharts();
    }

    protected function fetchYears(): void
    {
        // Get distinct years from Applicant model
        $this->years = Applicant::selectRaw($this->yearSelectExpression('date_applied'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Add "Overall Total" as the first option
        array_unshift($this->years, 'Overall Total');

        // Set default year to the first option (Overall Total)
        $this->selectedYear = $this->years[0];
    }

    protected function yearSelectExpression(string $column): string
    {
        if (DB::connection()->getDriverName() === 'sqlite') {
            return "strftime('%Y', {$column}) as year";
        }

        return "YEAR({$column}) as year";
    }

    protected function updateCounts()
    {
        if ($this->selectedYear === 'Overall Total') {
            // Total Applicants
            $this->totalApplicants = Applicant::count();

            // Total Tagged — count of TaggedAndValidatedApplicant records, not Applicant.is_tagged
            $this->totalTagged = TaggedAndValidatedApplicant::count();

            // Total Awardees
            $this->totalAwardees = Awardee::count();

            // Total Blacklisted
            $this->totalBlacklisted = Awardee::where('is_blacklisted', true)->count();
        } else {
            // Filtered counts based on the selected year
            $this->totalApplicants = Applicant::whereYear('date_applied', $this->selectedYear)->count();

            // Total Tagged — filtered by tagging_date, since that's what "year" means for this table
            $this->totalTagged = TaggedAndValidatedApplicant::whereYear('tagging_date', $this->selectedYear)->count();

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