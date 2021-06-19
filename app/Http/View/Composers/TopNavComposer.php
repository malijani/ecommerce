<?php

namespace App\Http\View\Composers;


use App\Favicon;
use App\TopNav;
use Illuminate\View\View;

class TopNavComposer
{
    public function compose(View $view)
    {
        /*MEDIUM SCREEN NAVIGATION ITEMS*/
        $top_navs_medium = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 1)
            ->orderBy('id')
            ->orderByDesc('status')
            ->get();

        /*SMALL SCREEN NAVIGATION ITEMS*/
        $top_navs_small = TopNav::withoutTrashed()
            ->where('status', 1)
            ->where('screen', 0)
            ->orderByDesc('id')
            ->get();

        $view->with([
            'top_navs_medium' => $top_navs_medium,
            'top_navs_small' => $top_navs_small,
        ]);
    }
}
