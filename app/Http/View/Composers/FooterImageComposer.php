<?php

namespace App\Http\View\Composers;


use App\FooterImage;
use Illuminate\View\View;

class FooterImageComposer
{
    public function compose(View $view)
    {
        /*FOOTER IMAGE*/
        $footer_image = FooterImage::withoutTrashed()
            ->where('status', '1')
            ->first();

        $view->with([
            'footer_image' => $footer_image,
        ]);
    }
}
