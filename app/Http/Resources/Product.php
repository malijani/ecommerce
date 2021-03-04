<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductShort as ProdcutShortResource;
use App\Http\Resources\Brand as BrandResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\ProductFiles as ProductFilesResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id'=> $this->id,
            'title'=>$this->title,
            'title_en'=>$this->title_en,
            'short_text'=>$this->short_text ?? $this->long_text_limited,
            'long_text'=>$this->long_text,
            'price'=>$this->price,
            'discount_percent'=>$this->discount_percent,
            'entity'=>$this->entity,

            'brand'=>new BrandResource($this->brand),
            'category'=>new CategoryResource($this->category),
            'price_type'=>$this->price_type_text,
            'origin'=>$this->origin_text,
            'deliver'=>$this->deliver_text,
            'warranty'=>$this->warranty_text,

            'keywords'=>$this->keywords,
            'description'=>$this->description,
            'visit'=>$this->visit,
            'color'=>$this->color,
            'before'=>new ProdcutShortResource($this->bef),
            'after'=>new ProdcutShortResource($this->af),

            'files'=>new ProductFilesResource($this->files),

        ];
    }
}
