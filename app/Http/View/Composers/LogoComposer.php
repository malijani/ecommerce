<?php

namespace App\Http\View\Composers;

use App\Logo;
use Illuminate\View\View;

class LogoComposer
{
    public function compose(View $view)
    {
        /*WEBSITE LOGO*/
        $logo = Logo::withoutTrashed()
            ->where('status', '1')
            ->first();

        $view->with([
            'logo' => $logo,
        ]);
    }
}
