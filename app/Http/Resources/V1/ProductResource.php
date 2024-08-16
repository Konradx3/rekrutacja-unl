<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->resource;

        return [
            'type' => 'product',
            'code' => $product['code'],
            'quantity' => $product['quantity'],
            'images' => isset($product['images']) ?
                array_map(function ($image){
                    return ['url' => $image['url']];
            }, $product['images']) : [],
        ];
    }
}
