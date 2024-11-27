<?php

namespace App\Exports;

use App\Models\Barangay;
use App\Models\CaseSpecification;
use App\Models\LivingSituation;
use App\Models\Purok;
use App\Models\TaggedAndValidatedApplicant;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasterlistOfActualOccupantsDataExport implements FromView, ShouldAutoSize, WithChunkReading, WithStyles, WithDrawings, WithEvents
{
    use Exportable;

    protected $search;
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = array_merge([
            'barangay' => null,
            'purok' => null,
            'civil_status' => null,
            'living_situation' => null,
            'case_specification' => null,
            'living_situation_case_specification' => null,
            'living_status' => null,
            'income_range' => null,
            'age_range' => null,
        ], $filters);
    }
    private function getTitle(): string
    {
        $title = 'MASTERLIST OF ACTUAL OCCUPANTS';

        // Add Living Situation
        if (!empty($this->filters['living_situation'])) {
            $livingSituation = LivingSituation::find($this->filters['living_situation']);
            $title .= ' WITH ' . strtoupper($livingSituation->living_situation_description);
        } else {
            $title .= ' WITH NOTICE OF VACATE';
        }

        return $title;
    }

    private function getSubtitle(): string
    {
        $subtitleParts = [];

        // Add Case Specification or Property Name
        if (!empty($this->filters['case_specification'])) {
            $caseSpecification = CaseSpecification::find($this->filters['case_specification']);
            $subtitleParts[] = strtoupper($caseSpecification->case_specification_name);
        } else {
            $livingSituationCaseSpecification = TaggedAndValidatedApplicant::find($this->filters['living_situation_case_specification']);
            $subtitleParts[] = strtoupper($livingSituationCaseSpecification->living_situation_case_specification);
        }

        // Add Purok
        if (!empty($this->filters['purok'])) {
            $purok = Purok::find($this->filters['purok']);
            $subtitleParts[] = 'PUROK ' . strtoupper($purok->name);
        }

        // Add Barangay
        if (!empty($this->filters['barangay'])) {
            $barangay = Barangay::find($this->filters['barangay']);
            $subtitleParts[] = 'BARANGAY ' . strtoupper($barangay->name);
        }

        // Add Current Date
        $subtitleParts[] = 'AS OF ' . now()->format('F d, Y');

        return implode(', ', $subtitleParts);
    }

    public function view(): View
    {
        $query = TaggedAndValidatedApplicant::query()
            ->with([
                'applicant.person',
                'applicant.address.barangay',
                'applicant.address.purok',
                'civilStatus',
                'spouse',
                'liveInPartner',
                'dependents',
                'livingSituation',
                'caseSpecification',
                'livingStatus'
            ]);

        // Apply filters
        if ($this->filters['barangay']) {
            $query->whereHas('applicant.address.barangay', function ($q) {
                $q->where('name', $this->filters['barangay']);
            });
        }

        if ($this->filters['purok']) {
            $query->whereHas('applicant.address.purok', function ($q) {
                $q->where('name', $this->filters['purok']);
            });
        }

        if ($this->filters['civil_status']) {
            $query->where('civil_status_id', $this->filters['civil_status']);
        }

        if ($this->filters['living_situation']) {
            $query->where('living_situation_id', $this->filters['living_situation']);
        }

        if ($this->filters['living_situation_case_specification']) {
            if ($this->filters['living_situation_case_specification'] === 'no_specification') {
                $query->whereNull('living_situation_case_specification');
            } else {
                $query->where('living_situation_case_specification', $this->filters['living_situation_case_specification']);
            }
        }

        if ($this->filters['living_status']) {
            $query->where('living_status_id', $this->filters['living_status']);
        }

        if ($this->filters['case_specification']) {
            $query->where('case_specification_id', $this->filters['case_specification']);
        }

        // Income range filter
        if ($this->filters['income_range']) {
            [$min, $max] = explode('-', $this->filters['income_range']);
            if ($max === 'up') {
                $query->where('monthly_income', '>', (int)$min);
            } else {
                $query->whereBetween('monthly_income', [(int)$min, (int)$max]);
            }
        }

        // Age range filter
        if ($this->filters['age_range']) {
            [$minAge, $maxAge] = explode('-', $this->filters['age_range']);
            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= ?', [(int)$minAge])
                ->when($maxAge !== 'up', function($q) use ($maxAge) {
                    $q->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ?', [(int)$maxAge]);
                });
        }

        $applicants = $query->get();

        return view('exports.masterlist-of-actual-occupants', [
            'applicants' => $applicants,
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath(public_path('storage/images/housing_logo.png'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('K1'); // Using column D for center alignment
        $drawing->setOffsetY(2);

        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $worksheet = $event->sheet->getDelegate();

                // Set to Legal paper size (8.5" x 14")
                $worksheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_LEGAL);

                // Set to Landscape orientation
                $worksheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                // Fit to 1 page wide by 1 page tall
                $worksheet->getPageSetup()->setFitToWidth(1);
                $worksheet->getPageSetup()->setFitToHeight(1);

                // Apply styles to the table
                $lastRow = $worksheet->getHighestRow();
                $lastColumn = 'T';

                // Optional: Set margins (in inches)
                $worksheet->getPageMargins()
                    ->setTop(0.5)
                    ->setRight(0.5)
                    ->setBottom(0.5)
                    ->setLeft(0.5);

                // Style the table headers
                $worksheet->getStyle("A8:{$lastColumn}8")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F3F4F6']
                    ]
                ]);

                // Set header and footer
                $worksheet->getHeaderFooter()->setOddHeader('');
                $worksheet->getHeaderFooter()->setEvenHeader('');
                $worksheet->getHeaderFooter()->setOddFooter('&P of &N'); // Page number
                $worksheet->getHeaderFooter()->setEvenFooter('&P of &N');

                $worksheet->getStyle('A:T')->getAlignment()->setWrapText(true);
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set paper orientation to landscape
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(15.56); // ID.
        $sheet->getColumnDimension('B')->setWidth(36.89); // PRINCIPAL NAME
        $sheet->getColumnDimension('C')->setWidth(4.22); // AGE
        $sheet->getColumnDimension('D')->setWidth(14.67); // Occupation
        $sheet->getColumnDimension('E')->setWidth(9.67); // Monthly Income
        $sheet->getColumnDimension('F')->setWidth(10.89); // Marital Status
        $sheet->getColumnDimension('G')->setWidth(10.11); // Barangay
        $sheet->getColumnDimension('H')->setWidth(10.78); // Purok
        $sheet->getColumnDimension('I')->setWidth(11.78); // Date Tagged
        $sheet->getColumnDimension('J')->setWidth(15.67); // Living Situation
        $sheet->getColumnDimension('K')->setWidth(19.22); // Living Situation (Case Specification)
        $sheet->getColumnDimension('L')->setWidth(8.89); // Living Status
        $sheet->getColumnDimension('M')->setWidth(33.22); // Spouse
        $sheet->getColumnDimension('N')->setWidth(11.89); // Occupation
        $sheet->getColumnDimension('O')->setWidth(10.56); // Monthly Income
        $sheet->getColumnDimension('P')->setWidth(12); // No. of Dependents
        $sheet->getColumnDimension('Q')->setWidth(9.22); // Family Income
        $sheet->getColumnDimension('R')->setWidth(10.33); // Length of Residency
        $sheet->getColumnDimension('S')->setWidth(11.78); // Contact Number
        $sheet->getColumnDimension('T')->setWidth(26.22); // Remarks

        // Set print area
        $sheet->getPageSetup()->setPrintArea('A1:T' . ($sheet->getHighestRow()));

        return [
            1 => ['font' => ['bold' => true, 'size' => 16]], // Header row
        ];
    }
}
