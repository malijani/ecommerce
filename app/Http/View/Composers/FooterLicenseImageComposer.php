<?php

namespace App\Http\View\Composers;


use App\FooterLicense;
use Illuminate\View\View;

class FooterLicenseImageComposer
{
    public function compose(View $view)
    {
        /*FOOTER LICENSE IMAGES*/
        $footer_license_images = FooterLicense::query()
            ->where('status', 1)
            ->get();
        //View::share('footer_license_images', $footer_license_images);

        $view->with([
            'footer_license_images' => $footer_license_images,
        ]);
    }
}

