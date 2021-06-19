<?php

namespace App\Http\View\Composers;

use App\Comment;
use Illuminate\View\View;

class FooterLastCommentComposer
{
    public function compose(View $view)
    {
        /*LAST COMMENTS*/
        $footer_last_comments = Comment::withoutTrashed()
            ->where('commentable_type', 'App\\Product')
            ->with('product:id,title,title_en')
            ->where('status', 1)
            ->limit(5)
            ->orderByDesc('updated_at')
            ->get()
            ->filter(function($item){
                if(isset($item->user)){
                    return $item->user->isNormal();
                } else {
                    return $item;
                }
            });

        $view->with([
            'footer_last_comments' => $footer_last_comments,
        ]);
    }
}
