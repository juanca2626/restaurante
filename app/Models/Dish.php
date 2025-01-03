<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dish extends Model
{
    use CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];


    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, 'dish_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($dish) {
            if ($dish->image) {
                \Storage::disk('public')->delete($dish->image);
            }
        });
    }
}
