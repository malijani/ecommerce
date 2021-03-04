<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductFiles extends ResourceCollection
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
                  'title'=>$q->title,
                  'link'=>isset($q->link) ? asset($q->link) : null, // it's required! but for sure...
                  'type'=>$q->type // 0->image; 1->video; 2->link ::: type_text is usable too!,
              ];
          }),
        ];
    }
}
