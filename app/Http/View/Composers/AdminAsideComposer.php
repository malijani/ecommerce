<?php

namespace App\Http\View\Composers;

use App\Logo;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAsideComposer
{
    public function compose(View $view)
    {
        /*WEBSITE LOGO*/
        $logo = Logo::withoutTrashed()
            ->where('status', '1')
            ->first();

        $user = Auth::user();

        $view->with([
            'logo' => $logo,
            'user' => $user,
        ]);
    }
}
