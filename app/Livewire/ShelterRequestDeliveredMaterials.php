<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ShelterRequestDeliveredMaterials extends Component
{
    public $governmentProgram = ''; // Holds selected government program ID

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
    }

    public function render()
    {
        $statistics = $this->getStatistics();

        // Fetch all government programs for the filter dropdown
        $GovernmentPrograms = DB::table('government_programs')
            ->select('id', 'program_name')
            ->orderBy('program_name', 'asc')
            ->get();

        return view('livewire.shelter-request-delivered-materials', [
            'statistics' => $statistics,
            'GovernmentPrograms' => $GovernmentPrograms
        ]);
    }
}
