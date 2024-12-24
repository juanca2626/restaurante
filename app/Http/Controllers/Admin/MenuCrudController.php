<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Requests\MenuRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MenuCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MenuCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Menu::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/menu');
        CRUD::setEntityNameStrings('menu', 'Menus');
        CRUD::removeButton('create');
        CRUD::denyAccess('create');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {        
        $this->crud->addColumn([
            'label' => 'Día',
            'type' => 'text',
            'name' => 'day_name',
        ]);
        $this->crud->addColumn([
            'label' => 'Plato',
            'type' => 'select',
            'name' => 'dish_id',
            'entity' => 'dish',
            'attribute' => 'name',
            'model' => "App\Models\Dish",
        ]);
        CRUD::orderBy("date","asc");
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(MenuRequest::class);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->crud->addField([
            'label' => 'Día',
            'name' => 'day_name',
            'type' => 'select_from_array',
            'options' => [
                'Lunes' => 'Lunes',
                'Martes' => 'Martes',
                'Miércoles' => 'Miércoles',
                'Jueves' => 'Jueves',
                'Viernes' => 'Viernes'
            ],
            'attributes' => [
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'label' => "Plato",
            'type' => 'select',
            'name' => 'dish_id',
            'model' => "App\Models\Dish",
            'attribute' => 'name',
            'options' => (function ($query) {
                return $query->orderBy('name')->get();
            }),
        ]);
    }
}
