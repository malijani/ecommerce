<?php

namespace App\Http\Livewire;

use App\Product;
use Livewire\Component;

class Search extends Component
{
    public $search = '';

    public function render()
    {
        $data = [];

        if ($this->search) {
            $search = '%' . $this->search . '%';

            $products = Product::withoutTrashed()
                ->where('status', 1)
                ->where('entity', '>', 0)
                ->where('title', 'LIKE', $search)
                ->get();

            $data = [
                'products'=>$products,
            ];
        }

        return view('livewire.search', $data);
    }
}
