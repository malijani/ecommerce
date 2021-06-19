<?php

namespace App\Http\View\Composers;


use App\Favicon;
use Illuminate\View\View;

class FaviconComposer
{
    public function compose(View $view)
    {
        /*WEBSITE FAVICON*/
        $favicon = Favicon::query()
            ->where('status', 1)
            ->first();
        
        $view->with([
            'favicon' => $favicon,
        ]);
    }
}
