<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'status' => $this->status,
            'status_text' => $this->statusText($this->status),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product' => new ProductResource($this->whenLoaded('product'))
        ];
    }

    public function statusText($status)
    {
        $text = '';
        switch ($status) {
            case 1:
                $text = 'Order Placed';
                break;
            case 2:
                $text = 'Processing';
                break;
            case 3:
                $text = 'On Route';
                break;
            case 4:
                $text = 'Delivered';
                break;
        }
        return $text;
    }
}
