<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class RisDataExport implements FromView
{
    protected $grantee;
    protected $selectedPO;

    public function __construct($grantee, $selectedPO)
    {
        $this->grantee = $grantee;
        $this->selectedPO = $selectedPO;
    }

    public function view(): View
    {
        $materials = $this->grantee->deliveredMaterials
            ->filter(function ($deliveredMaterial) {
                return $deliveredMaterial->material->purchaseOrder->po_number === $this->selectedPO;
            })
            ->map(function ($deliveredMaterial) {
                return [
                    'material_unit_id' => $deliveredMaterial->material->materialUnit->unit,
                    'item_description' => $deliveredMaterial->material->item_description,
                    'grantee_quantity' => $deliveredMaterial->grantee_quantity,
                ];
            });

        return view('exports.ris', [
            'grantee' => $this->grantee,
            'materials' => $materials,
            'selectedPO' => $this->selectedPO,
        ]);
    }
}
