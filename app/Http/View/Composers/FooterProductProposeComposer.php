<?php

namespace App\Http\View\Composers;

use App\Product;
use Illuminate\View\View;

class FooterProductProposeComposer
{
    public function compose(View $view)
    {
        /*FOOTER PRODUCTS*/

        $footer_product_proposals =  Product::withoutTrashed()
            ->where('status', 1)
            ->where('entity', '>', 0)
            ->where('visit', '>', 10)
            ->where('discount_percent', '>', 1)
            ->where('origin', 1)
            ->orderByDesc('updated_at')
            ->limit(5)
            ->get()
            ->filter(function($item){
                return $item->ratingsAvg() > 4;
            });

        $view->with([
            'footer_product_proposals' => $footer_product_proposals,
        ]);
    }
}
