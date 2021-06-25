<?php

namespace App\Http\Resources\Api;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
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
            'product_id' => $this->product_id,
            'path' => filter_var($this->path, FILTER_VALIDATE_URL) ? $this->path : Storage::url($this->path),
            'created_at' => $this->created_at
        ];
    }
}
