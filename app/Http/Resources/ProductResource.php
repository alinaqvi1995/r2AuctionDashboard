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
            'user_id' => $this->user_id,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'subcategory_id' => $this->subcategory_id,
            'manufacturer_id' => $this->manufacturer_id,
            'condition' => $this->condition,
            'status' => $this->status,
            'image' => $this->image,
            'auction_slot_id' => $this->auction_slot_id,
            'lot_no' => $this->lot_no,
            'screens' => $this->screens,
            'admin_approval' => $this->admin_approval,
            'reference' => $this->reference,
            'listing_type' => $this->listing_type,
            'material' => $this->material,
            'generation' => $this->generation,
            'connectivity' => $this->connectivity,
            'quantity' => $this->quantity,
            'auction_name' => $this->auction_name,
            'lot_address' => $this->lot_address,
            'lot_city' => $this->lot_city,
            'lot_state' => $this->lot_state,
            'lot_zip' => $this->lot_zip,
            'lot_country' => $this->lot_country,
            'international_buyers' => $this->international_buyers,
            'shipping_requirements' => $this->shipping_requirements,
            'certificate_data_erasure' => $this->certificate_data_erasure,
            'certificate_hardware_destruction' => $this->certificate_hardware_destruction,
            'lot_sold_as_is' => $this->lot_sold_as_is,
            'notes' => $this->notes,
            'bidding_close_time' => $this->bidding_close_time,
            'processing_time' => $this->processing_time,
            'minimum_bid_price' => $this->minimum_bid_price,
            'buy_now' => $this->buy_now,
            'buy_now_price' => $this->buy_now_price,
            'reserve_price' => $this->reserve_price,
            'model_size' => $this->model_size,
            'payment_requirement' => $this->payment_requirement,
            'created_at' => $this->created_at,
            'colors' => $this->colors->pluck('name'),
            'storages' => $this->storages->pluck('name'),
            'regions' => $this->regions->pluck('name'),
            'modelNumbers' => $this->modelNumbers->pluck('name'),
            'lockStatuses' => $this->lockStatuses->pluck('name'),
            'grades' => $this->grades->pluck('name'),
            'carriers' => $this->carriers->pluck('name'),
            'rams' => $this->rams->pluck('name'),
            'sizes' => $this->sizes->pluck('name'),
            'modelNames' => $this->modelNames->pluck('name'),
            // 'storages' => $this->storages->pluck('name'),
            // 'regions' => $this->regions->pluck('name'),
            // 'modelNumbers' => $this->modelNumbers->pluck('name'),
            // 'lockStatuses' => $this->lockStatuses->pluck('name'),
            // 'grades' => $this->grades->pluck('name'),
            // 'carriers' => $this->carriers->pluck('name'),
        ];
    }
}
