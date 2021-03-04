<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductShort extends JsonResource
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
        if (isset($this->id)) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'title_en' => $this->title_en,
            ];
        } else {
            return null;
        }
    }
}
