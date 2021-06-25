<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
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
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'bid_at' => $this->bid_at,
            'price' => $this->price,
            'ip_address' => $this->ip_address,
            'country' => $this->country,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
