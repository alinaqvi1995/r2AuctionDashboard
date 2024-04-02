<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category->name,
            'manufacturer' => $this->manufacturer->name,
            'condition' => $this->condition,
            'status' => $this->status,
            'colors' => $this->colors->pluck('name'),
            'storages' => $this->storages->pluck('name'),
            'regions' => $this->regions->pluck('name'),
            'modelNumbers' => $this->modelNumbers->pluck('name'),
            'lockStatuses' => $this->lockStatuses->pluck('name'),
            'grades' => $this->grades->pluck('name'),
            'carriers' => $this->carriers->pluck('name'),
            // Add other relationships here
        ];
    }
}
