<?php

namespace App\Livewire;

use App\Exports\ShelterRequestDeliveredMaterialsDataExport;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Models\Barangay;

class ShelterRequestDeliveredMaterials extends Component
{
    public $governmentProgram = ''; // Holds selected government program ID
    public $barangaysFilter = []; // Holds selected barangay IDs
    public $selectedBarangay_id = '';


    public function mount()
    {
        $this->barangaysFilter = Cache::remember('barangays', 60 * 60, function () {
            return Barangay::all();
        });
    }

    public function getStatistics()
    {
        $query = DB::table('barangays as b')
            ->select(
                'b.id as barangay_id',
                'b.name as barangay_name',
                DB::raw('COUNT(sa.id) as total_requests'),
                DB::raw('COUNT(CASE WHEN pta.is_tagged = true THEN 1 END) as tagged_requests'),
                DB::raw('COUNT(g.id) as delivered_requests')
            )
            ->leftJoin('addresses as addr', 'addr.barangay_id', '=', 'b.id')
            ->leftJoin('shelter_applicants as sa', 'sa.address_id', '=', 'addr.id')
            ->leftJoin('profiled_tagged_applicants as pta', 'pta.profile_no', '=', 'sa.id')
            ->leftJoin('grantees as g', 'g.profiled_tagged_applicant_id', '=', 'pta.id');


        // Apply Barangay filter
        if (!empty($this->selectedBarangay_id)) {
            $query->where('b.id', $this->selectedBarangay_id);
        }

        // Filter by government program
        if (!empty($this->governmentProgram)) {
            $query->where('pta.government_program_id', $this->governmentProgram);
        }

        return $query
            ->groupBy('b.id', 'b.name')
            ->havingRaw('COUNT(sa.id) > 0') // Only barangays with requests
            ->orderBy('b.name', 'asc')
            ->get();
    }

    public function clearFilter()
    {
        $this->governmentProgram = ''; // Reset the filter
        $this->selectedBarangay_id = ''; // Reset the filter
    }

    public function export()
    {
        try {
            // Collect the active filters
            $filters = [
                'startDate' => $this->filters['startDate'] ?? null,
                'endDate' => $this->filters['endDate'] ?? null,
                'government_program_id' => $this->governmentProgram,
                'barangay_id' => $this->selectedBarangay_id,
            ];

            // Pass the filters to the export class
            return Excel::download(
                new ShelterRequestDeliveredMaterialsDataExport($filters),
                'shelter-request-delivered-materials-' . now()->format('Y-m-d') . '.xlsx'
            );
        } catch (\Exception $e) {
            Log::error('Export error: ' . $e->getMessage());
            $this->dispatch('alert', [
                'title' => 'Export failed: ',
                'message' => $e->getMessage() . '<br><small>' . now()->calendar() . '</small>',
                'type' => 'danger',
            ]);
            return null;
        }
    }



    public function getTotals($statistics)
    {
        return [
            'total_requests' => $statistics->sum('total_requests'),
            'tagged_requests' => $statistics->sum('tagged_requests'),
            'delivered_requests' => $statistics->sum('delivered_requests'),
        ];
    }

    public function render()
    {
        $statistics = $this->getStatistics();

        $totals = $this->getTotals($statistics); // Calculate totals

        $GovernmentPrograms = DB::table('government_programs')
            ->select('id', 'program_name')
            ->orderBy('program_name', 'asc')
            ->get();

        return view('livewire.shelter-request-delivered-materials', [
            'statistics' => $statistics,
            'GovernmentPrograms' => $GovernmentPrograms,
            'totals' => $totals, // Pass totals to the Blade view
        ]);
    }
}
