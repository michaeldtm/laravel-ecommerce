<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'reviews' => $this->reviews_count,
            'stars' => (int) $this->reviews_avg_stars,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'features' => ProductFeatureResource::collection($this->whenLoaded('features')),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
