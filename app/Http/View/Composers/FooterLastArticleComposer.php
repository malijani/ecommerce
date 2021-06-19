<?php

namespace App\Http\View\Composers;


use App\Article;
use Illuminate\View\View;

class FooterLastArticleComposer
{
    public function compose(View $view)
    {
        /*LAST ARTICLES*/
        $footer_last_articles = Article::withoutTrashed()
            ->where('status', 1)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $view->with([
            'footer_last_articles' => $footer_last_articles,
        ]);
    }
}
