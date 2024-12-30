<?php

namespace Database\Seeders;

use App\Models\Dish;
use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;

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
            'image' => 'lomo_saltado'
        ]);
        Menu::create([
            'date' => '2024-12-09',
            'dish_id' => $dish1->id,
            'day_name' => Carbon::parse('2024-12-09')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        Menu::create([
            'date' => '2024-12-09',
            'dish_id' => $dish2->id,
            'day_name' => Carbon::parse('2024-12-09')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        $dish1 = Dish::create([
            'name' => 'Arroz con Pollo',
            'price' => 16,
            'image' => 'arroz_pollo'
        ]);
        $dish2 = Dish::create([
            'name' => 'Lentejitas',
            'price' => 14,
            'image' => 'lentejitas'
        ]);
        Menu::create([
            'date' => '2024-12-10',
            'dish_id' => $dish1->id,
            'day_name' => Carbon::parse('2024-12-10')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        Menu::create([
            'date' => '2024-12-10',
            'dish_id' => $dish2->id,
            'day_name' => Carbon::parse('2024-12-10')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        $dish1 = Dish::create([
            'name' => 'Tallarines Verdes',
            'price' => 13,
            'image' => 'tallarines_verdes'
        ]);
        $dish2 = Dish::create([
            'name' => 'Arroz a la Cubana',
            'price' => 10,
            'image' => 'arroz_cubana'
        ]);
        Menu::create([
            'date' => '2024-12-11',
            'dish_id' => $dish1->id,
            'day_name' => Carbon::parse('2024-12-11')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        Menu::create([
            'date' => '2024-12-11',
            'dish_id' => $dish2->id,
            'day_name' => Carbon::parse('2024-12-11')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        $dish1 = Dish::create([
            'name' => 'Causa',
            'price' => 11,
            'image' => 'causa'
        ]);
        $dish2 = Dish::create([
            'name' => 'Seco de Res',
            'price' => 13,
            'image' => 'seco_res'
        ]);
        Menu::create([
            'date' => '2024-12-12',
            'dish_id' => $dish1->id,
            'day_name' => Carbon::parse('2024-12-12')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        Menu::create([
            'date' => '2024-12-12',
            'dish_id' => $dish2->id,
            'day_name' => Carbon::parse('2024-12-12')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        $dish1 = Dish::create([
            'name' => 'Arroz Chaufa',
            'price' => 15,
            'image' => 'chaufa'
        ]);
        $dish2 = Dish::create([
            'name' => 'Saltado de Pollo',
            'price' => 16,
            'image' => 'saltado_pollo'
        ]);
        Menu::create([
            'date' => '2024-12-13',
            'dish_id' => $dish1->id,
            'day_name' => Carbon::parse('2024-12-13')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
        Menu::create([
            'date' => '2024-12-13',
            'dish_id' => $dish2->id,
            'day_name' => Carbon::parse('2024-12-13')->locale('es')->dayName, // Obtiene el nombre del día en español
        ]);
    }
}
