<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Awardee;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public $years = [];
    public $selectedYear;
    public $totalAwardees;
    public $totalApplicants = 0;
    public $monthlyApplicants = [];

    public function mount()
    {
        $this->totalAwardees = Awardee::count();
        $this->totalApplicants = Applicant::count();

        $this->years = Applicant::selectRaw('YEAR(date_applied) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Set the selected year to the latest year from the database, or fallback to the current year if none exists
        $this->selectedYear = !empty($this->years) ? $this->years[0] : Carbon::now()->year;
        $this->updateTotalApplicants(); // Initialize the count
//        $this->fetchMonthlyData();

        // If the selected year is not in the list of years, add it
        if (!in_array($this->selectedYear, $this->years)) {
            array_unshift($this->years, $this->selectedYear);
        }
    }

    public function updatedSelectedYear()
    {
        $this->updateTotalApplicants(); // Update count when selected year changes
        // Fetch the monthly data when the year is updated
//        $this->fetchMonthlyData();

        // Emit event with the updated monthly data
//        $this->emit('refreshChartData-' . $this->chartId, [
//            'categories' => $this->getMonths(), // Ensure this returns the correct labels
//            'seriesData' => $this->monthlyApplicants, // Ensure this holds the data for the selected year
//            'seriesName' => 'Applicants', // Change according to your data series
//        ]);
    }

//    protected function getMonths()
//    {
//        return ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
//    }

    protected function updateTotalApplicants()
    {
        $this->totalApplicants = Applicant::whereYear('date_applied', $this->selectedYear)->count();
    }

//    private function fetchMonthlyData()
//    {
//        // Get the count of applicants for each month across all years
//        $this->monthlyApplicants = Applicant::selectRaw('MONTH(date_applied) as month, COUNT(*) as count')
//            ->groupBy('month')
//            ->pluck('count', 'month')
//            ->toArray();
//
//
//        // Ensure all 12 months are represented, with missing months filled with 0
//        $this->monthlyApplicants = array_replace(array_fill(1, 12, 0), $this->monthlyApplicants);
//    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
