<?php

namespace App\Http\View\Composers;



use App\ImageMenu;
use Illuminate\View\View;

class AboutImageMenuComposer
{
    public function compose(View $view)
    {
        /*ABOUT IMAGE MENUS*/
        $about_image_menus = ImageMenu::query()
            ->where('type', 0)
            ->where('status', 1)
            ->orderByDesc('id')
            ->get();


        $view->with([
            'about_image_menus' => $about_image_menus,
        ]);
    }
}
