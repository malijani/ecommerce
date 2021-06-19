<?php

namespace App\Http\View\Composers;


use App\FooterItem;
use Illuminate\View\View;

class FooterStaticNavComposer
{
    public function compose(View $view)
    {
        $footer_static_navs = FooterItem::query()
            ->item('static-nav');

        $view->with([
            'footer_static_navs' => $footer_static_navs,
        ]);
    }
}

