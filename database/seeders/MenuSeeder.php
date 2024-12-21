<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dish1 = Dish::create([
            'name' => 'Ají de Gallina',
            'price' => 15,
            'image' => 'aji'
        ]);
        $dish2 = Dish::create([
            'name' => 'Lomo Saltado',
            'price' => 17,
            'image' => 'aji'
        ]);
        Menu::create([
            'date' => '2024-12-09',
            'dish_id' => $dish1->id
        ]);
        Menu::create([
            'date' => '2024-12-09',
            'dish_id' => $dish2->id
        ]);
        $dish1 = Dish::create([
            'name' => 'Arroz con Pollo',
            'price' => 16,
            'image' => 'aji'
        ]);
        $dish2 = Dish::create([
            'name' => 'Lentejitas',
            'price' => 14,
            'image' => 'aji'
        ]);
        Menu::create([
            'date' => '2024-12-10',
            'dish_id' => $dish1->id
        ]);
        Menu::create([
            'date' => '2024-12-10',
            'dish_id' => $dish2->id
        ]);
        $dish1 = Dish::create([
            'name' => 'Tallarines Verdes',
            'price' => 13,
            'image' => 'aji'
        ]);
        $dish2 = Dish::create([
            'name' => 'Arroz a la Cubana',
            'price' => 10,
            'image' => 'aji'
        ]);
        Menu::create([
            'date' => '2024-12-11',
            'dish_id' => $dish1->id
        ]);
        Menu::create([
            'date' => '2024-12-11',
            'dish_id' => $dish2->id
        ]);
        $dish1 = Dish::create([
            'name' => 'Causa',
            'price' => 11,
            'image' => 'aji'
        ]);
        $dish2 = Dish::create([
            'name' => 'Mondonguito Italiano',
            'price' => 13,
            'image' => 'aji'
        ]);
        Menu::create([
            'date' => '2024-12-12',
            'dish_id' => $dish1->id
        ]);
        Menu::create([
            'date' => '2024-12-12',
            'dish_id' => $dish2->id
        ]);
        $dish1 = Dish::create([
            'name' => 'Arroz Chaufa',
            'price' => 15,
            'image' => 'aji'
        ]);
        $dish2 = Dish::create([
            'name' => 'Saltado de Pollo',
            'price' => 16,
            'image' => 'aji'
        ]);
        Menu::create([
            'date' => '2024-12-13',
            'dish_id' => $dish1->id
        ]);
        Menu::create([
            'date' => '2024-12-13',
            'dish_id' => $dish2->id
        ]);        
    }
}
