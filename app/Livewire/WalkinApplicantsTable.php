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

final class WalkinApplicantsTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
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
//            ->add('id')
//            ->add('user_id')
//            ->add('transaction_type_id')
//            ->add('civil_status_id')
//            ->add('tribe_id')
            ->add('first_name')
            ->add('middle_name')
            ->add('last_name')
//            ->add('age')
            ->add('phone')
//            ->add('sex')
//            ->add('occupation')
//            ->add('income')
            ->add('date_applied_formatted', fn (Applicant $model) => Carbon::parse($model->date_applied)->format('d/m/Y H:i:s'))
//            ->add('initially_interviewed_by')
            ->add('status');
//            ->add('tagger_name')
//            ->add('tagging_date_formatted', fn (Applicant $model) => Carbon::parse($model->tagging_date)->format('d/m/Y H:i:s'))
//            ->add('awarded_by')
//            ->add('awarding_date_formatted', fn (Applicant $model) => Carbon::parse($model->awarding_date)->format('d/m/Y H:i:s'))
//            ->add('photo')
//            ->add('created_at');
    }

    public function columns(): array
    {
        return [
//            Column::make('Id', 'id'),
//            Column::make('User id', 'user_id'),
//            Column::make('Transaction type id', 'transaction_type_id'),
//            Column::make('Civil status id', 'civil_status_id'),
//            Column::make('Tribe id', 'tribe_id'),
            Column::make('First name', 'first_name')
                ->sortable()
                ->searchable(),

            Column::make('Middle name', 'middle_name')
                ->sortable()
                ->searchable(),

            Column::make('Last name', 'last_name')
                ->sortable()
                ->searchable(),

//            Column::make('Age', 'age')
//                ->sortable()
//                ->searchable(),

            Column::make('Phone', 'phone')
                ->sortable()
                ->searchable(),

//            Column::make('Sex', 'sex')
//                ->sortable()
//                ->searchable(),

//            Column::make('Occupation', 'occupation')
//                ->sortable()
//                ->searchable(),
//
//            Column::make('Income', 'income')
//                ->sortable()
//                ->searchable(),

            Column::make('Date applied', 'date_applied_formatted', 'date_applied')
                ->sortable(),

//            Column::make('Initially interviewed by', 'initially_interviewed_by')
//                ->sortable()
//                ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

//            Column::make('Tagger name', 'tagger_name')
//                ->sortable()
//                ->searchable(),
//
//            Column::make('Tagging date', 'tagging_date_formatted', 'tagging_date')
//                ->sortable(),
//
//            Column::make('Awarded by', 'awarded_by')
//                ->sortable()
//                ->searchable(),
//
//            Column::make('Awarding date', 'awarding_date_formatted', 'awarding_date')
//                ->sortable(),
//
//            Column::make('Photo', 'photo')
//                ->sortable()
//                ->searchable(),
//
//            Column::make('Created at', 'created_at_formatted', 'created_at')
//                ->sortable(),
//
//            Column::make('Created at', 'created_at')
//                ->sortable()
//                ->searchable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
//            Filter::datetimepicker('date_applied'),
//            Filter::datetimepicker('tagging_date'),
//            Filter::datetimepicker('awarding_date'),
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
            Button::add('edit')
                ->slot('Edit: '.$row->id)
                ->id()
                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
                ->dispatch('edit', ['rowId' => $row->id])
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
