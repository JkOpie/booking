<?php

namespace App\Http\Livewire;

use App\Models\ItemUser;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class ApprovedItemTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this //->showCheckBox()
            //->showPerPage();
            ->showSearchInput();
            //->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\Item>|null
    */
    public function datasource(): ?Builder
    {
        return ItemUser::query()
        ->join('items', 'items.id', 'item_user.item_id')
        ->join('users', 'users.id', 'item_user.user_id')
        ->join('types', 'types.id', 'items.type_id')
        ->join('categories', 'categories.id', 'items.category_id')
        ->where('item_user.status', 'approved')
        ->select( 'item_user.id','item_user.start_date', 'item_user.total_price', 'item_user.end_date', 'item_user.status','items.name', 'items.description',  'types.name as type_name', 'categories.name as category_name', 'users.name as user_name');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
        ->addColumn('user_id')
        ->addColumn('name')
        ->addColumn('description')
        ->addColumn('category_id')
        ->addColumn('type_id')
        ->addColumn('total_price')
        ->addColumn('payment_type')
        ->addColumn('receipt')
        ->addColumn('status');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('user')
                ->field('user_name')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('Start Date')
                ->field('start_date')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('End Date')
                ->field('end_date')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('NAME')
                ->field('name')
                ->sortable()
                ->searchable(),
            //->makeInputText(),

            Column::add()
                ->title('DESCRIPTION')
                ->field('description')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('CATEGORY')
                ->field('category_name'),
                //->makeInputRange(),

            Column::add()
                ->title('TYPE')
                ->field('type_name'),
                //->makeInputRange(),

            Column::add()
                ->title('Total Price')
                ->field('total_price'),

            Column::add()
                ->title('Status')
                ->field('status')


        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid Item Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

     public function actions(): array
     {
        return [

            Button::add('remove')
                ->caption('Removed')
                ->class('btn btn-danger btn-sm')
                ->target('_self')
                ->route('items.admin-update', ['item_id' => 'id', 'status' => 'rejected'])
         ];
     }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Item Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($item) => $item->id === 1)
                ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid Item Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = Item::query()
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
    */
}
