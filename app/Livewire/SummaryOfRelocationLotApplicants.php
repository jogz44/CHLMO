<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\TaggedAndValidatedApplicant;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class SummaryOfRelocationLotApplicants extends Component
{
    // For counting
    public $walkInApplicants = 0,
        $taggedWalkInApplicants = 0,
        $untaggedWalkInApplicants = 0,

        $totalTaggedValidated = 0,
        $informalSettlers = 0,
        $nonInformalSettlers = 0,

        $totalInformalSettlers = 0,
        $awardedInformalSettlers = 0,
        $nonAwardedInformalSettlers = 0,

        $totalRelocationApplicants = 0;
    public function mount()
    {
        // Count total walk-in applicants
        $this->walkInApplicants = Applicant::where('transaction_type', 'Walk-in')->count();

        // Count tagged walk-in applicants
        $this->taggedWalkInApplicants = Applicant::where('transaction_type', 'Walk-in')
            ->where('is_tagged', true)
            ->count();

        // Count untagged walk-in applicants
        $this->untaggedWalkInApplicants = Applicant::where('transaction_type', 'Walk-in')
            ->where('is_tagged', false)
            ->count();

        // Count total tagged and validated applicants
        $this->totalTaggedValidated = TaggedAndValidatedApplicant::count();

        // Count informal settlers (living_situation_id 1-7)
        $this->informalSettlers = TaggedAndValidatedApplicant::whereIn('living_situation_id', [1, 2, 3, 4, 5, 6, 7])->count();

        // Count non-informal settlers (living_situation_id 8 and 9)
        $this->nonInformalSettlers = TaggedAndValidatedApplicant::whereIn('living_situation_id', [8, 9])->count();

        // Count all informal settlers (living_situation_id 1-7)
        $this->totalInformalSettlers = TaggedAndValidatedApplicant::whereIn('living_situation_id', [1, 2, 3, 4, 5, 6, 7])->count();

        // Count awarded informal settlers
        $this->awardedInformalSettlers = TaggedAndValidatedApplicant::whereIn('living_situation_id', [1, 2, 3, 4, 5, 6, 7])
            ->whereHas('awardees', function($query) {
                $query->where('is_awarded', true);
            })->count();

        // Count non-awarded informal settlers
        $this->nonAwardedInformalSettlers = TaggedAndValidatedApplicant::whereIn('living_situation_id', [1, 2, 3, 4, 5, 6, 7])
            ->whereHas('awardees', function($query) {
                $query->where('is_awarded', false);
            })->count();

        // OVERALL TOTALS

        // Total Walk-in Applicants
        $walkInTotal = Applicant::where('transaction_type', 'Walk-in')->count();

        // Non-Informal Settlers from Tagged and Validated
        $nonInformalTotal = TaggedAndValidatedApplicant::whereIn('living_situation_id', [8, 9])->count();

        // Informal Settlers
        $informalTotal = TaggedAndValidatedApplicant::whereIn('living_situation_id', [1, 2, 3, 4, 5, 6, 7])->count();

        // Grand Total
        $this->totalRelocationApplicants = $walkInTotal + $nonInformalTotal + $informalTotal;
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
            'taggedWalkInApplicants' => $this->taggedWalkInApplicants,
            'untaggedWalkInApplicants' => $this->untaggedWalkInApplicants,

            'totalTaggedValidated' => $this->totalTaggedValidated,
            'informalSettlers' => $this->informalSettlers,
            'nonInformalSettlers' => $this->nonInformalSettlers,

            'totalInformalSettlers' => $this->totalInformalSettlers,
            'awardedInformalSettlers' => $this->awardedInformalSettlers,
            'nonAwardedInformalSettlers' => $this->nonAwardedInformalSettlers
        ]);
    }
}
