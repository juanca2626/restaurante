<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dayNextWeek = $this->date->copy()->addWeeks(2)->isoWeek();
        $yearNextWeek = $this->date->copy()->addWeeks(2)->isoWeekYear();
        $nextWeek = Carbon::now()->setISODate($yearNextWeek, $dayNextWeek, $this->date->dayOfWeek);
        $nextDate = $nextWeek->startOfWeek(0)->addDays($this->date->dayOfWeek);        
        return [
            'date' => $nextDate->format('Y-m-d'),
            'date_formated' => $nextDate->format('d/m'),
            'day_of_week' => $this->date->dayOfWeek === 0 ? 6 : $this->date->dayOfWeek - 1, 
            'dish' => [
                'id' => $this->id,
                'name' => $this->dish->name,
                'price' => $this->dish->price,
                'image' => $this->dish->image,
            ]
        ];
    }
}
