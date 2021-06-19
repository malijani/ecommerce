<?php

namespace App\Http\View\Composers;



use App\FooterItem;
use Illuminate\View\View;

class FooterLicenseComposer
{
    public function compose(View $view)
    {
        /*LICENSES*/
        $footer_licenses = FooterItem::query()
            ->item('licenses');

        $view->with([
            'footer_licenses' => $footer_licenses,
        ]);
    }
}
