<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Prompts\Key;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class WalkinApplicantsTable extends PowerGridComponent
{
    use WithExport;

    public bool $showFilters = true;

    public function boot(): void
    {
        config(['livewire-powergrid.filter' => 'outside']);
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage(perPage: 8, perPageValues: [0, 50, 100, 500])
                ->showRecordCount(),
        ];
    }

    public function datasource()
    {
        $query = Applicant::query();

        // Always eager load the address relationship as it's needed for both barangay and purok
        $eagerLoad = ['address'];

        // Check if barangay filter is applied
        if (isset($this->filters['select']['address.barangay_id'])) {
            $eagerLoad[] = 'address.barangay';
        }

        // Check if purok filter is applied (assuming you have a purok filter)
        if (isset($this->filters['select']['address.purok_id'])) {
            $eagerLoad[] = 'address.purok';
        }

        // Apply eager loading
        $query->with($eagerLoad);

        // Apply barangay filter if set
        if (isset($this->filters['select']['address.barangay_id'])) {
            $barangayId = $this->filters['select']['address.barangay_id'];
            $query->whereHas('address', function ($q) use ($barangayId) {
                $q->where('barangay_id', $barangayId);
            });
        }

        // Apply purok filter if set (assuming you have a purok filter)
        if (isset($this->filters['select']['address.purok_id'])) {
            $purokId = $this->filters['select']['address.purok_id'];
            $query->whereHas('address', function ($q) use ($purokId) {
                $q->where('purok_id', $purokId);
            });
        }

        return $query->get();
    }

    public function filters(): array
    {
        return [
            Filter::select('barangay', 'address.barangay_id.name')
                ->dataSource(Barangay::all())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('purok', 'address.purok_id.name')
                ->dataSource(Purok::all())
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }

    public function relationSearch(): array
    {
        return [
            'address' => [
                'barangay' => ['name']  // Enables searching by Barangay name
            ]
        ];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('first_name')
            ->add('middle_name')
            ->add('last_name')
            ->add('full_name', fn (Applicant $model) => $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name)
            ->add('phone')
            ->add('date_applied_formatted', fn (Applicant $model) => Carbon::parse($model->date_applied)->format('d/m/Y'))
            ->add('initially_interviewed_by')
            ->add('barangay', fn (Applicant $model) => $model->address->barangay->name ?? 'N/A')
            ->add('purok', fn (Applicant $model) => $model->address->purok->name ?? 'N/A');
    }

    public function columns(): array
    {
        return [
            // Use the 'full_name' field to display the concatenated names
            Column::make('FULL NAME', 'full_name')
                ->sortable()
                ->searchable(),

            Column::make('FIRST NAME', 'first_name')
                ->hidden()
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::make('MIDDLE NAME', 'middle_name')
                ->hidden()
                ->sortable()
                ->searchable(),

            Column::make('LAST NAME', 'last_name')
                ->hidden()
                ->sortable()
                ->searchable(),

            Column::make('PHONE', 'phone')
                ->sortable()
                ->searchable(),

            Column::make('DATE APPLIED', 'date_applied_formatted', 'date_applied')
                ->sortable(),

            Column::make('INITIALLY INTERVIEWED BY', 'initially_interviewed_by')
                ->sortable()
                ->searchable(),

            Column::make('PUROK', 'purok')
                ->sortable()
                ->searchable(),

            Column::make('BARANGAY', 'barangay')
                ->sortable()
                ->searchable(),

            Column::action('ACTION')
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert(' . $rowId.')');
    }

    public function actions(Applicant $row): array
    {
        return [
            Button::add('details')
                ->slot('<button onclick="window.location.href=\''.route('applicant-details', ['applicantId' => $row->id]).'\'" class="text-custom-red text-bold underline px-4 py-1.5">Details</button>')
                ->class(''),

            Button::add('tag')
                ->slot('<button @click="openModalTag = true" class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>')
                ->class(''),

            Button::add('award')
                ->slot('<button @click="openModalAward = true" class="bg-custom-green text-white px-8 py-1.5 rounded-full">Award</button>')
                ->class(''),
        ];
    }

    public function update(array $data):bool
    {
        try {
            $updated = Applicant::query()->find($data['id'])->update([
                $data['field'] => $data['value']
            ]);
        } catch (QueryException $exception){
            $updated = false;
        }
        return $updated;
    }

//    public function updateMessages(string $status, string $field = '_default_message')
//    {
//
//    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
