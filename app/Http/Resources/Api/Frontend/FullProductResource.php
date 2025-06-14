<?php

namespace App\Http\Resources\Api\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class FullProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'sale_price' => $this->sale_price,
            'specification' => $this->specification,
            'image' => $this->image ? asset(Storage::url('products/' . $this->image)) : null,
            'gallery' => $this->gallery
                ? collect(explode(',', $this->gallery))->map(fn($img) => asset(Storage::url('products/' . trim($img))))
                : [],
            'offer' => $this->offer,
            'review' => $this->review,
            'review_count' => $this->review_count,
            'review_avg_rating_value' => $this->review_avg_rating_value,
        ];
    }
}
