<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductBrand extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            //'message' => 'success',
            'data' => $this->collection->transform(function ($q) {
                return [
                    'id' => $q->id,
                    'title' => $q->title,
                    'title_en' => $q->title_en,
                    'short_text' => $q->short_text ?? $this->long_text_limited,
                    'price' => $q->price,
                    'discount_percent' => $q->discount_percent,
                    'entity' => $q->entity,
                    'price_type' => $q->price_type_text,
                    'category' => new Category($q->category),
                    'files' => new ProductFiles($q->files),
                ];
            }),


        ];
    }
}
