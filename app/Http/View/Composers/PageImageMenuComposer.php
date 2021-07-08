<?php

namespace App\Http\View\Composers;

use App\ImageMenu;
use Illuminate\View\View;

class PageImageMenuComposer
{
    public function compose(View $view)
    {
        $page_image_menus = ImageMenu::query()
            ->where('type', 3)
            ->where('status', 1)
            ->orderBy('id')
            ->get();

        $view->with([
            'page_image_menus' => $page_image_menus,
        ]);

    }
}
