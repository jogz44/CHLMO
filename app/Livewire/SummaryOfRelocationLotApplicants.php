<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\TaggedAndValidatedApplicant;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class SummaryOfRelocationLotApplicants extends Component
{
    // For counting
    public $walkInApplicants = 0, $taggedAndValidated = 0, $identifiedInformalSettlers = 0, $totalRelocationLotApplicants = 0;
    public function mount()
    {
        // Count Walk-in Applicants (transaction_type_id = 1)
        $this->walkInApplicants = Applicant::whereHas('transactionType', function ($query) {
            $query->where('id', 1);
        })->count();

        // Count ALL Tagged and Validated Applicants
        $this->taggedAndValidated = TaggedAndValidatedApplicant::where('is_tagged', true)->count();

        // Count Identified Informal Settlers
        // Specific living situation IDs: 1, 2, 3, 4, 5, 6, 7, 8, 9
        $this->identifiedInformalSettlers = TaggedAndValidatedApplicant::where('is_tagged', true)
            ->whereBetween('living_situation_id', [1, 9])
            ->count();
        // Add this debug code
//        $settlers = TaggedAndValidatedApplicant::where('is_tagged', true)
//            ->whereBetween('living_situation_id', [1, 9])
//            ->get();
//        dd([
//            'total_records' => $settlers->count(),
//            'living_situation_ids' => $settlers->pluck('living_situation_id')->toArray()
//        ]);

        // Calculate Total Relocation Lot Applicants
//        $this->totalRelocationLotApplicants = $this->walkInApplicants + $this->taggedAndValidated + $this->identifiedInformalSettlers;

        // Modified total calculation - only add walk-in and tagged/validated
        // since informal settlers are already included in tagged/validated
        $this->totalRelocationLotApplicants = $this->walkInApplicants + $this->taggedAndValidated;
    }

    public function exportPDF(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        ini_set('default_charset', 'UTF-8');

        // Prepare the data for PDF
        $data = [
            'walkInApplicants' => $this->walkInApplicants,
            'taggedAndValidated' => $this->taggedAndValidated,
            'identifiedInformalSettlers' => $this->identifiedInformalSettlers,
            'totalRelocationLotApplicants' => $this->totalRelocationLotApplicants,
            'informalSettlersCases' => [
                'AFFECTED BY GOVERNMENT INFRASTRUCTURE',
                'GOVERNMENT PROPERTIES',
                'WITH COURT ORDER FOR DEMOLITION AND EVICTION',
                'WITH NOTICE TO VACATE',
                'PRIVATE PROPERTIES',
                'PRIVATE CONSTRUCTION PROJECTS',
                'ALIENABLE AND DISPOSABLE LAND',
                'DANGER ZONE: ACCRETION AREA, LANDSLIDE PRONE AREA, IDENTIFIED FLOOD PRONE AREA, NPC LINE, ALONG THE CREEK, ALONG THE RIVER, ETC.',
                'AND OTHER CASES'
            ]
        ];

        // Render the PDF view with the data
        $html = view('pdfs.summary-of-relocation-lot-applicants', $data)->render();

        // Load the PDF with the generated HTML
        $pdf = Pdf::loadHTML($html);
        $pdf->setPaper('legal', 'portrait');

        // Stream the PDF for download
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'summary-of-relocation-lot-applicants.pdf');
    }

    public function render()
    {
        return view('livewire.summary-of-relocation-lot-applicants', [
            'walkInApplicants' => $this->walkInApplicants,
            'taggedAndValidated' => $this->taggedAndValidated,
            'identifiedInformalSettlers' => $this->identifiedInformalSettlers,
            'totalRelocationLotApplicants' => $this->totalRelocationLotApplicants
        ]);
    }
}
