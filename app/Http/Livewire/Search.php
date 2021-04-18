<?php

namespace App\Http\Livewire;

use App\Article;
use App\Brand;
use App\Category;
use App\Product;
use Livewire\Component;
use Mews\Purifier\Facades\Purifier;

class Search extends Component
{
    public $search = '';

    public function render()
    {
        $search = $this->search;
        $data = [];

        if ($search && strlen($search) >= 4) {
            $search = '%' . $search . '%';

            $products = Product::withoutTrashed()->search($search, 10);

            $articles = Article::withoutTrashed()->search($search, 10);

            $categories = Category::withoutTrashed()->search($search, 10);

            $brands = Brand::withoutTrashed()->search($search, 10);

            $data = [
                'products'=>$products,
                'articles'=>$articles,
                'brands'=>$brands,
                'categories'=>$categories,
            ];
        }

        return view('livewire.search', $data);
    }
}
