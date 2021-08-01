<?php

namespace App\Http\Controllers\Visitor;

use App\HeaderPage;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $products = Product::withoutTrashed()
            ->active()
            ->orderBy('updated_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->orderBy('entity', 'DESC')
            ->paginate(100);


        /*LOAD META*/
        $page_header = HeaderPage::query()
            ->where('page', '=', 'products')
            ->first();

        if (!empty($page_header->title)) {
            $title = $page_header->title;
        } else {
            $title = 'محصولات ' . config('app.brand.name');
        }

        return view('front-v1.product.index', [
            'title' => $title,
            'page_header' => $page_header,
            'products' => $products,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return View
     */
    public function show(string $slug): View
    {
        $product = Product::withoutTrashed()
            ->where('title_en', $slug)
            ->with('bef', 'af', 'category', 'user', 'brand', 'files', 'attrs')
            ->active()
            ->first();


        if (empty($product)) {
            $title = 'محصول ' . $slug . ' در ' . config('app.brand.name') . ' یافت نشد ';
            $products = Product::withoutTrashed()
                ->active()
                ->orderByDesc('sold')
                ->orderBy('entity', 'DESC')
                ->orderBy('created_at', 'DESC')
                ->orderBy('sort', 'ASC')
                ->limit(30)
                ->get();
            return view('front-v1.product.404', [
                'title' => $title,
                'products' => $products,
                'not_found' => $slug,
            ]);
        }

        $product->increment('visit');
        $comments = $product->comments()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->active()
            ->sort()
            ->get();
        $title = $product->title;


        $basket = session()->get('basket') ?? null;
        /*do not over ordering product if its already in the users basket*/
        if (isset($basket) && isset($basket[$product->id])) {
            $product->entity = $product->entity - $basket[$product->id]['quantity'];
        }

        /*GET SIMILAR PRODUCTS*/
        $similar_products = Product::withoutTrashed()
            ->active()
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->get();


        /*GENERATE ATTRIBUTES FOR OPTION SELECTION*/
        $attributes = [];
        if ($product->attrs->count()) {
            foreach ($product->attrs as $product_attr) {
                /* SAMPLE :
                 * $attr : id , title
                 * $pivot : attr_value
                 * [
                 *     "$attr->id" =>[
                 *         "$attr->title"=>[
                 *          //[index=> $pivot->attr_value],
                 *            [0=> "هنداونه ای" ],
                 *            [1=> "لیمویی"]
                 *         ]
                 *     ]
                 * ]
                */
                if (array_key_exists($product_attr->id, $attributes)) {
                    $attributes[$product_attr->id] = array_merge_recursive($attributes[$product_attr->id], [$product_attr->title => $product_attr->pivot->attr_value]);
                } else {
                    $attributes[$product_attr->id] = [$product_attr->title => $product_attr->pivot->attr_value];
                }
            }
        }


        $page_header = new \stdClass();
        $page_header->keywords = $product->keywords;
        $page_header->description = $product->description;
        $page_header->author = $product->user->full_name;
        $page_header->url = route('product.show', $product->title_en);
        $page_header->image = asset($product->files()->defaultFile()->link);
        $page_header->type = 'product';

        return view('front-v1.product.show', [
            'title' => $title,
            'page_header' => $page_header,
            'product' => $product,
            'attributes' => $attributes,
            'similar_products' => $similar_products,
            'comments' => $comments
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
