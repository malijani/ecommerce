<?php

namespace App\Http\View\Composers;


use App\SocialMedia;
use Illuminate\View\View;

class FooterSocialMediaComposer
{
    public function compose(View $view)
    {
        /*SOCIAL MEDIA*/
        $social_medias = SocialMedia::query()
            ->where('status', 1)
            ->get();

        $view->with([
            'social_medias' => $social_medias,
        ]);
    }
}

