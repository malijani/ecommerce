<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\ProductShort as ProductShortResource;
use App\Http\Resources\Brand as BrandResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\ProductFiles as ProductFilesResource;

class Products extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
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
                    'long_text' => $q->long_text,
                    'price' => $q->price,
                    'discount_percent' => $q->discount_percent,
                    'entity' => $q->entity,


                    'price_type' => $q->price_type_text,
                    'origin' => $q->origin_text,
                    'deliver' => $q->deliver_text,
                    'warranty' => $q->warranty_text,


                    'keywords' => $q->keywords,
                    'description' => $q->description,
                    'visit' => $q->visit,
                    'color' => $q->color,

                    'brand' => new BrandResource($q->brand),
                    'category' => new CategoryResource($q->category),

                    'before' => new ProductShortResource($q->bef),
                    'after' => new ProductShortResource($q->af),

                    'files' => new ProductFilesResource($q->files),
                ];
            }),


        ];
    }
}
