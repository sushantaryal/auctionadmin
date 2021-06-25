<?php

namespace App\Http\Resources\Api;

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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'initial_price' => $this->initial_price,
            'price' => $this->price,
            'closing_price' => $this->closing_price,
            'auto_increment' => $this->auto_increment,
            'min_increment' => $this->min_increment,
            'bid_credit' => $this->bid_credit,
            'expire_at' => $this->expire_at,
            'description' => $this->description,
            'updated' => $this->updated,
            'is_bookmarked' => $this->is_bookmarked,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'latest_bid' => new BidResource($this->whenLoaded('latestBid')),
            'photos' => PhotoResource::collection($this->parent ? $this->parent->photos : $this->photos),
            'order' => new OrderResource($this->whenLoaded('order'))
        ];
    }
}
