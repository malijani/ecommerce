<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Brands extends ResourceCollection
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
            $this->collection->transform(function($q){
                return [
                    'id'=>$q->id,
                    'title'=>$q->title,
                    'title_en'=>$q->title_en,
                    'text'=>$q->text,
                    'pic'=>isset($q->pic) ? asset($q->pic) : null,
                    'pic_alt'=>$q->pic_alt,
                ];
            }),
        ];
    }
}
