<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $title = 'محصولات ' . config('app.short.name');
        $products = Product::withoutTrashed()
            ->active()
//            ->where('entity', '>', 0)
            ->orderBy('entity', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->paginate(100);

        return response()->view('front-v1.product.index', [
            'products' => $products,
            'title' => $title

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        $product = Product::withoutTrashed()
            ->where('title_en', $slug)
            ->with('bef', 'af', 'category', 'user', 'brand', 'files', 'attrs')
            ->active()
            ->first();


        /*TODO : CREATE 404 PAGE*/
        if(empty($product)){
            $title = 'محصول ' . $slug . ' در ' . config('app.short.name') . ' یافت نشد ';
            return response()
                ->view('front-v1.product.404', [
                    'title' => $title,
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


        return response()->view('front-v1.product.show', [
            'title' => $title,
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
