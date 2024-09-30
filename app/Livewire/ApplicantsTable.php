<?php

namespace App\Livewire;

use App\Models\Applicant;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
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

final class ApplicantsTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Applicant::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('user_id')
            ->add('transaction_type_id')
            ->add('first_name')
            ->add('middle_name')
            ->add('last_name')
            ->add('suffix_name')
            ->add('phone')
            ->add('date_applied_formatted', fn (Applicant $model) => Carbon::parse($model->date_applied)->format('d/m/Y'))
            ->add('initially_interviewed_by')
            ->add('address_id')
            ->add('created_at');
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->hidden(),
            Column::make('User id', 'user_id')
                ->hidden(),
            Column::make('Transaction type id', 'transaction_type_id')
                ->hidden(),
            Column::make('First name', 'first_name')
                ->sortable()
                ->searchable(),

            Column::make('Middle name', 'middle_name')
                ->sortable()
                ->searchable(),

            Column::make('Last name', 'last_name')
                ->sortable()
                ->searchable(),

            Column::make('Suffix name', 'suffix_name')
                ->sortable()
                ->searchable(),

            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),

            Column::make('Date applied', 'date_applied_formatted', 'date_applied')
                ->sortable(),

            Column::make('Initially interviewed by', 'initially_interviewed_by')
                ->sortable()
                ->searchable(),

            Column::make('Address id', 'address_id'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::make('Created at', 'created_at')
                ->sortable()
                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::datepicker('date_applied'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
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
