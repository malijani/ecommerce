<?php

namespace App\Http\View\Composers;


use App\FooterText;
use Illuminate\View\View;

class FooterTextIntroComposer
{
    public function compose(View $view)
    {
        /*FOOTER TEXT*/
        $footer_text_intro = FooterText::query()
            ->where('status', 1)
            ->first();

        $view->with([
            'footer_text_intro' => $footer_text_intro,
        ]);
    }
}

