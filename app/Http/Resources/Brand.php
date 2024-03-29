<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Brand extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'title' => $this->title,
            'title_en' => $this->title_en,
            'text' => $this->text,
            'pic' => isset($this->pic) ? asset($this->pic) : null,
            'pic_alt' => $this->pic_alt,
            'color' => $this->color,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'products' => new ProductBrand($this->products)
        ];
    }
}
