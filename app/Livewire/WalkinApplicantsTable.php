<?php

namespace App\Livewire;

use App\Models\Applicant;
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

    public function filters(): array
    {
        return [
//            Filter::select('category_name', 'category_id')
//                ->dataSource(Category::all())
//                ->optionLabel('name')
//                ->optionValue('id'),
        ];
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
            // Add a virtual field for the combined full name
            ->add('full_name', fn (Applicant $model) => $model->first_name . ' ' . $model->middle_name . ' ' . $model->last_name)

            ->add('phone')
//            ->add('sex')
            ->add('occupation')
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

            Column::make('OCCUPATION', 'occupation')
                ->sortable()
                ->searchable(),

            Column::make('DATE APPLIED', 'date_applied_formatted', 'date_applied')
                ->sortable(),

            Column::make('STATUS', 'status')
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
//            Button::add('edit')
//                ->slot('Edit: '.$row->id)
//                ->id()
//                ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
//                ->dispatch('edit', ['rowId' => $row->id]),

            Button::add('details')
                ->slot('<button onclick="window.location.href=\''.route('applicant-details', ['id' => $row->id]).'\'" class="text-custom-red text-bold underline px-4 py-1.5">Details</button>')
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

    public function updateMessages(string $status, string $field = '_default_message')
    {

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
