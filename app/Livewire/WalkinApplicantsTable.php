<?php

namespace App\Livewire;

use App\Models\Applicant;
use App\Models\Barangay;
use App\Models\Purok;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;
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

    public bool $showFilters = false;

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
            Header::make()
                ->showSearchInput()
                ->showToggleColumns(),
            Footer::make()
                ->showPerPage(perPage: 8, perPageValues: [0, 50, 100, 500])
                ->showRecordCount()
        ];
    }

    public function datasource(): Builder
    {
        // Logging filters for debugging
        Log::info('Filters:', $this->filters);

        // Querying applicants with eager loading of address relationship
        $query = Applicant::query();

        // Join with the addresses table
        $query->join('addresses', 'applicants.address_id', '=', 'addresses.id');

        // Apply barangay filter if set
        if (isset($this->filters['select']['barangay'])) {
            $barangayId = $this->filters['select']['barangay'];
            $query->where('addresses.barangay_id', $barangayId);
        }

        // Apply purok filter if set
        if (isset($this->filters['select']['purok'])) {
            $purokId = $this->filters['select']['purok'];
            $query->where('addresses.purok_id', $purokId);
        }

        // Eager load the relationships
        $query->with(['address.barangay', 'address.purok']);

        // Select specific columns to avoid ambiguity
        $query->select('applicants.*', 'addresses.barangay_id', 'addresses.purok_id');

        return $query;
    }


    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('transaction_type', fn(Applicant $model) => $model->transactionType->type_name)
            ->add('first_name')
            ->add('middle_name')
            ->add('last_name')
            ->add('full_name', fn(Applicant $model) => $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name)
            ->add('phone')
            ->add('date_applied_formatted', fn(Applicant $model) => Carbon::parse($model->date_applied)->format('m/d/Y'))
            ->add('initially_interviewed_by')
            ->add('barangay', fn(Applicant $model) => $model->address->barangay->name ?? 'N/A')
            ->add('purok', fn(Applicant $model) => $model->address->purok->name ?? 'N/A');
    }

    public function columns(): array
    {
        return [
//            Column::make('TRANSACTION TYPE', 'transaction_type')
//                ->sortable()
//                ->searchable(),

            Column::make('FULL NAME', 'full_name')
                ->sortable()
                ->searchable(),

            Column::make('FIRST NAME', 'first_name')
                ->hidden()
                ->sortable()
                ->searchable()
                ->editOnClick()
                ->visibleInExport(visible: true),

            Column::make('MIDDLE NAME', 'middle_name')
                ->hidden()
                ->sortable()
                ->searchable()
                ->visibleInExport(visible: true),

            Column::make('LAST NAME', 'last_name')
                ->hidden()
                ->sortable()
                ->searchable()
                ->visibleInExport(visible: true),

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
//    #[\Livewire\Attributes\On('edit')]
//    public function edit($rowId): void
//    {
//        $this->js('alert(' . $rowId.')');
//    }

    public function actions(Applicant $row): array
    {
        return [
            Button::add('tag')
                ->slot('<button onclick="window.location.href=\''.route('applicant-details', ['applicantId' => $row->id]).'\'" class="bg-custom-yellow text-white px-8 py-1.5 rounded-full">Tag</button>')
                ->class(''),
        ];
    }

    public function filters(): array
    {
        return [
            Filter::select('barangay', 'addresses.barangay_id')
                ->dataSource(Barangay::all())
                ->optionLabel('name')
                ->optionValue('id'),

            Filter::select('purok', 'addresses.purok_id')
                ->dataSource(Purok::all())  // Assuming you have a Purok model
                ->optionLabel('name')
                ->optionValue('id'),
        ];
    }
}

//    public function update(array $data):bool
//    {
//        try {
//            $updated = Applicant::query()->find($data['id'])->update([
//                $data['field'] => $data['value']
//            ]);
//        } catch (QueryException $exception){
//            $updated = false;
//        }
//        return $updated;
//    }

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
