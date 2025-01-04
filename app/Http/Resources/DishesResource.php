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
        $monday = $this->date->startOfWeek();
        $weeksUntilNow = now()->startOfWeek()->diffInWeeks($monday);
        $newDate = $this->date->addWeeks($weeksUntilNow + 1);
        return [
            'date' => $newDate->format('Y-m-d'),
            'date_formated' => $newDate->format('d/m'),
            'day_of_week' => $newDate->dayOfWeek === 0 ? 6 : $newDate->dayOfWeek - 1, 
            'dish' => [
                'id' => $this->dish->id,
                'name' => $this->dish->name,
                'price' => $this->dish->price,
                'image' => $this->dish->image,
                'type' => $this->dish->type,
            ]
        ];
    }
}
