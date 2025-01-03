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


    public function setup()
    {
        CRUD::setModel(\App\Models\Dish::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dish');
        CRUD::setEntityNameStrings('Plato', 'Platos');
    }


    protected function setupListOperation()
    {
        /*
        CRUD::setFromDb(); // set columns from db columns.
        $this->crud->removeColumn('image');
        $this->crud->addColumn([
            'name' => 'image',
            'label' => 'Imagen',
            'type' => 'image',
            'disk' => 'public'
        ]);
        CRUD::orderBy('name');
        */
        CRUD::column('name')->label('Nombre Plato');
        CRUD::column('price')->type('number')->prefix('S/ ')->label('Precio');
        CRUD::column('image')->type('image')->prefix('storage/')->label('Imagen');
        CRUD::column('created_at')->label('Fecha de Creación');
        CRUD::orderBy('name');

    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(DishRequest::class);

        /*
        CRUD::setFromDb(); // set fields from db columns.
        $this->crud->removeField('image');
        $this->crud->addField([
            'name' => 'image',
            'label' => 'Imagen',
            'type' => 'upload',
            'disk' => 'public',
            'withFiles' => true
        ]);
        */

        CRUD::field('name')->type('text')->label('Nombre Plato');
        CRUD::field('price')->type('number')->prefix('S/ ')->label('Precio');
        CRUD::field('image')->type('upload')->upload(true)->disk('public')->withFiles(true)->label('Imagen');
    }


    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
