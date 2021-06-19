<?php

namespace App\Http\View\Composers;




use App\SocialMediaButton;
use Illuminate\View\View;

class SocialMediaButtonComposer
{
    public function compose(View $view)
    {
        /*FLOATING SOCIAL MEDIA BUTTON*/
        $float_social_media_button = SocialMediaButton::query()->where('status', 1)->first();

        $view->with([
            'float_social_media_button' => $float_social_media_button,
        ]);
    }
}
