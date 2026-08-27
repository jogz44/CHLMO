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

        // Only append a "WITH ..." suffix when a living situation filter was actually selected.
        // Previously this had a hardcoded "WITH NOTICE OF VACATE" fallback that showed up
        // on every unfiltered export, which was wrong.
        if (!empty($this->filters['living_situation'])) {
            $livingSituation = LivingSituation::find($this->filters['living_situation']);
            if ($livingSituation) {
                $title .= ' WITH ' . strtoupper($livingSituation->living_situation_description);
            }
        }

        return $title;
    }

   private function getFiltersSubtitle(): string
{
    $subtitleParts = [];

    // Add Case Specification or Property Name
    if (!empty($this->filters['case_specification'])) {
        $caseSpecification = CaseSpecification::find($this->filters['case_specification']);
        if ($caseSpecification) {
            $subtitleParts[] = strtoupper($caseSpecification->case_specification_name);
        }
    } elseif (!empty($this->filters['living_situation_case_specification']) && $this->filters['living_situation_case_specification'] !== 'no_specification') {
        $subtitleParts[] = strtoupper($this->filters['living_situation_case_specification']);
    }

    // Add Living Status
    if (!empty($this->filters['living_status'])) {
        $livingStatus = \App\Models\LivingStatus::find($this->filters['living_status']);
        if ($livingStatus) {
            $subtitleParts[] = strtoupper($livingStatus->living_status_name);
        }
    }

    // Add Civil Status
    if (!empty($this->filters['civil_status'])) {
        $civilStatus = \App\Models\CivilStatus::find($this->filters['civil_status']);
        if ($civilStatus) {
            $subtitleParts[] = strtoupper($civilStatus->civil_status);
        }
    }

    // Add Purok
    if (!empty($this->filters['purok'])) {
        $purok = Purok::where('name', $this->filters['purok'])->first();
        if ($purok) {
            $subtitleParts[] = 'PUROK ' . strtoupper($purok->name);
        }
    }

    // Add Barangay
    if (!empty($this->filters['barangay'])) {
        $barangay = Barangay::where('name', $this->filters['barangay'])->first();
        if ($barangay) {
            $subtitleParts[] = 'BARANGAY ' . strtoupper($barangay->name);
        }
    }

    // Add Income Range
    if (!empty($this->filters['income_range'])) {
        [$min, $max] = array_pad(explode('-', $this->filters['income_range']), 2, null);
        if ($max === 'up') {
            $subtitleParts[] = 'MONTHLY INCOME ABOVE ' . number_format((float) $min, 2);
        } elseif ($min !== null && $max !== null) {
            $subtitleParts[] = 'MONTHLY INCOME ' . number_format((float) $min, 2) . ' - ' . number_format((float) $max, 2);
        }
    }

    // Add Age Range
    if (!empty($this->filters['age_range'])) {
        [$minAge, $maxAge] = array_pad(explode('-', $this->filters['age_range']), 2, null);
        if ($maxAge === 'up') {
            $subtitleParts[] = 'AGE ' . $minAge . ' & ABOVE';
        } elseif ($minAge !== null && $maxAge !== null) {
            $subtitleParts[] = 'AGE ' . $minAge . '-' . $maxAge;
        }
    }

    return implode(', ', $subtitleParts);
}

private function getAsOfSubtitle(): string
{
    return 'AS OF ' . now()->format('F d, Y');
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
                ->when($maxAge !== 'up', function ($q) use ($maxAge) {
                    $q->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= ?', [(int)$maxAge]);
                });
        }

        $applicants = $query->get();

        return view('exports.masterlist-of-actual-occupants', [
            'applicants' => $applicants,
            'title' => $this->getTitle(),
            'filtersSubtitle' => $this->getFiltersSubtitle(),
'asOfSubtitle' => $this->getAsOfSubtitle(),
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function drawings(): array
    {
        $drawings = [];

        // Left Logo
        $leftDrawing = new Drawing();
        $leftDrawing->setName('Left Logo');
        $leftDrawing->setDescription('Left Logo');
        $leftDrawing->setPath(public_path('storage/images/logo-left.png')); // Update path if necessary
        $leftDrawing->setHeight(85); // Adjust height as needed
        $leftDrawing->setCoordinates('J2'); // Starting cell
        $leftDrawing->setOffsetX(315); // Align near the right edge of column B
        $leftDrawing->setOffsetY(0); // Fine-tune vertical positioning

        // Right Logo
        $rightDrawing = new Drawing();
        $rightDrawing->setName('Right Logo');
        $rightDrawing->setDescription('Right Logo');
        $rightDrawing->setPath(public_path('storage/images/logo-right.png'));
        $rightDrawing->setHeight(85); // Adjust height as needed
        $rightDrawing->setCoordinates('L2'); // Starting cell for the right logo
        $rightDrawing->setOffsetX(-30); // Fine-tune horizontal positioning
        $rightDrawing->setOffsetY(0); // Fine-tune vertical positioning

        $drawings[] = $leftDrawing;
        $drawings[] = $rightDrawing;

        return $drawings;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
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
                $worksheet->getStyle("A15:{$lastColumn}15")->applyFromArray([
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

                $worksheet->getStyle("A8:{$lastColumn}{$lastRow}")->getAlignment()->setWrapText(true);

                $remarksMinWidth = 50.22;
                $remarksColumn = $worksheet->getColumnDimension('T');
                if ($remarksColumn->getWidth() < $remarksMinWidth) {
                    $remarksColumn->setWidth($remarksMinWidth);
                }
                $remarksColumn->setAutoSize(false);
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
        $sheet->getColumnDimension('T')->setWidth(50.22); // Remarks

        // Set print area
        $sheet->getPageSetup()->setPrintArea('A1:T' . ($sheet->getHighestRow()));

        return [
            1 => ['font' => ['bold' => true, 'size' => 16]], // Header row
        ];
    }
}
