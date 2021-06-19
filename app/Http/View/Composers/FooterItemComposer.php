<?php

namespace App\Http\View\Composers;


use App\FooterItem;
use Illuminate\View\View;

class FooterItemComposer
{
    public function compose(View $view)
    {
        $footer_items = FooterItem::query()
            ->where('status', 1)
            ->get()
            ->filter(function($item){
                return !in_array($item->title_en, ['licenses', 'static-nav']);
            });

        $view->with([
            'footer_items' => $footer_items,
        ]);
    }
}

