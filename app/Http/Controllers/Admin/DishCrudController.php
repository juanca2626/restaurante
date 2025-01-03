<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DishRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class DishCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DishCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Dish::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dish');
        CRUD::setEntityNameStrings('Plato', 'Platos');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::setFromDb(); // set columns from db columns.
        $this->crud->removeColumn('image');
        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Imagen',
            'type' => 'image',
            'disk' => 'public'
        ]);
        CRUD::orderBy('name');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(DishRequest::class);
        CRUD::setFromDb(); // set fields from db columns.
        // $this->crud->removeField('type');
        $this->crud->addField([
            'label' => 'Tipo',
            'name' => 'type',
            'type' => 'select_from_array',
            'options' => [
                'first_course' => 'Entrada',
                'second_ourse' => 'Segundo' 
            ],
        ]);
        $this->crud->removeField('image');
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Imagen',
            'type' => 'upload',
            'withFiles' => true
        ]);

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
