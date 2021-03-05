<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class Categories extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
//        return parent::toArray($request);
        return [
            $this->collection->transform(function($q){
                return [
                    'id'=>$q->id,
                    'title'=>$q->title,
                    'title_en'=>$q->title_en,
                    'text'=>$q->text,
                    'pic'=>isset($q->pic) ? asset($q->pic) : null,
                    'pic_alt'=>$q->pic_alt,
                    'color'=>$q->color,
                    'keywords'=>$q->keywords,
                    'description'=>$q->description,
                    'child'=>new Categories($q->children),
                ];
        }),
        ];
    }
}
