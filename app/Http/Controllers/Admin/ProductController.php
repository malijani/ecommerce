<?php

namespace App\Http\Controllers\Admin;

use App\Attribute;
use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use \Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $title = 'مدیریت محصولات';
        $products = Product::withoutTrashed()
            ->with('user', 'category', 'files')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        return response()->view('admin.product.index',
            [
                'title' => $title,
                'products' => $products,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        $title = 'ثبت محصول جدید';
        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $brands = Brand::withoutTrashed()
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $attributes = Attribute::query()
            ->orderBy('created_at', 'DESC')
            ->get();
        $products = Product::withoutTrashed()
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        return response()->view('admin.product.create', [
            'title' => $title,
            'categories' => $categories,
            'brands' => $brands,
            'attributes'=>$attributes,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        /*TODO : LOGIC OF SAVING POST WITH ATTRIBUTES*/


        $request->validate([
            /*FILES*/
            'file.title' => ['required', 'array', 'min:1','max:6'],
            'file.file' => ['required', 'array', 'min:1', 'max:6'],
            'file.title.*' => ['required', 'min:2', 'max:70'],
            'file.file.*' => ['required', 'mimes:jpg,jpeg,png,gif', 'max:10240'],

            /*ATTRIBUTES*/
            'attribute.id'=> ['sometimes', 'required', 'array',  'max:6'],
            'attribute.value'=>['sometimes', 'required', 'array', 'max:6'],
            'attribute.id.*'=>['sometimes', 'required', 'exists:attributes,id'],
            'attribute.value.*'=>['sometimes', 'required', 'min:2', 'max:70'],

            'brand_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'title' => ['required', 'min:2', 'max:100', 'unique:products,title'],
            'title_en' => ['required', 'min:2', 'max:100', 'unique:products,title_en'],
            'short_text' => ['nullable', 'min:3', 'max:255'],
            'long_text' => ['required', 'min:10', 'max:40000'],
            'origin' => ['required', 'numeric'],
            'deliver' => ['required', 'numeric'],
            'warranty' => ['required', 'numeric'],
            'weight'=>['required', 'numeric'],
            'price_type' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'discount_percent' => ['required', 'numeric', 'between:0,100'],
            'price_self_buy' => ['required', 'numeric'],
            'entity' => ['required', 'numeric', 'between:0,65533'],
            'keywords' => ['nullable', 'min:2', 'max:70'],
            'description' => ['nullable', 'min:3', 'max:255'],
            'color' => ['nullable', 'max:8'],
            'status' => ['required', 'numeric'],
            'before' => ['required', 'numeric'],
            'after' => ['required', 'numeric'],
            'show_default' => ['required', 'numeric', 'min:0', 'max:6'],
        ]);

        $show_default = $request->input('show_default'); // selected image to show as default




        $product = Product::query()->create(array_merge(
            $request->except('title_en', 'show_default'),
            ['title_en' => Str::slug($request->input('title_en'))],
            ['user_id' => Auth::id()]
        ));

        /*SAVE ATTRIBUTES*/
        if($request->has('attribute.id')){
            $attr_ids = $request->input('attribute.id');
            $attr_values = $request->input('attribute.value');
            foreach($attr_ids as $id_key=>$id_val){
                //['attr.id' => ["attr_value"=>'attr.value']]
                //['8'=> ["attr_value"=>"300g"]]

                /*DIRECT ATTACH ATTRIBUTE*/
                $product->attrs()->attach(
                    [$id_val=> ['attr_value'=>$attr_values[$id_key]]]
                );
            }
        }


        /*SAVE FILES*/
        if ($request->hasFile('file.file')) {
            $files = [];
            $fields = range(0, count($request->file('file.file')) - 1);

            foreach ($fields as $iteration) {

                $file = new ProductFile;
                $file->product_id = $product->getAttribute('id');
                $file->title = $request->input('file.title.' . $iteration);
                $file->link = imageUploader($request, 'file.file.' . $iteration, 'product/' . $product->getAttribute('id'));
                $file->type = 0; // type is picture
                $file->status = ((int)$iteration === (int)$show_default) ? '2' : '1'; // set picture as default OR only show it

                array_push($files, $file);

            }

            $product->files()->saveMany($files);
        }

        return response()->redirectToRoute('products.index')->with('success', 'محصول با موفقیت ثبت شد');


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        // TODO : IMPLEMENT SHOW METHOD PRODUCT
        return response('show/' . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id): Response
    {
        $product = Product::withoutTrashed()
            ->with('user', 'category', 'brand', 'files', 'attrs')
            ->findOrFail($id);
        $title = ' ویرایش محصول ' . $product->getAttribute('title');
        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->where('parent_id', 0)
            ->where('status', true)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $products = Product::withoutTrashed()
            ->where('status', 1)
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $brands = Brand::withoutTrashed()
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        $attributes = Attribute::query()
            ->orderBy('created_at', 'DESC')
            ->get();
        return response()->view('admin.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'title' => $title,
            'products' => $products,
            'brands' => $brands,
            'attributes'=>$attributes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $product = Product::withoutTrashed()->findOrFail($id);
        $request->validate([
            /*FILES*/
            'file.title' => ['required', 'array', 'min:1'],
            'file.file' => ['sometimes', 'array', 'min:1'],
            'file.title.*' => ['required', 'min:2', 'max:70'],
            'file.file.*' => ['sometimes', 'mimes:jpg,jpeg,png,gif', 'max:10240'],

            /*ATTRIBUTES*/
            'attribute.id'=> ['sometimes', 'required', 'array',  'max:6'],
            'attribute.value'=>['sometimes', 'required', 'array', 'max:6'],
            'attribute.id.*'=>['sometimes', 'required', 'exists:attributes,id'],
            'attribute.value.*'=>['sometimes', 'required', 'min:2', 'max:70'],

            'brand_id' => ['required', 'numeric'],
            'category_id' => ['required', 'numeric'],
            'title' => ['required', 'min:2', 'max:100', 'unique:products,title,' . $product->getAttribute('id')],
            'title_en' => ['required', 'min:2', 'max:100', 'unique:products,title_en,' . $product->getAttribute('id')],
            'short_text' => ['nullable', 'min:3', 'max:255'],
            'long_text' => ['required', 'min:10', 'max:40000'],
            'origin' => ['required', 'numeric'],
            'deliver' => ['required', 'numeric'],
            'warranty' => ['required', 'numeric'],
            'weight'=>['required', 'numeric'],
            'price_type' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
            'discount_percent' => ['required', 'numeric', 'between:0,100'],
            'price_self_buy' => ['required', 'numeric'],
            'entity' => ['required', 'numeric', 'between:0,65533'],
            'keywords' => ['nullable', 'min:2', 'max:70'],
            'description' => ['nullable', 'min:3', 'max:255'],
            'color' => ['nullable', 'max:8'],
            'status' => ['required', 'numeric'],
            'before' => ['required', 'numeric'],
            'after' => ['required', 'numeric'],
            'show_default' => ['required', 'numeric', 'min:0', 'max:6'],
            'changed_titles' => ['nullable', 'max:12'],
            'changed_files' => ['nullable', 'max:12'],
            'option' => ['nullable', 'array', 'max:5'],
        ]);

        $changed_titles = !is_null($request->input('changed_titles')) ? explode(',', $request->input('changed_titles')) : [];
        $changed_files = !is_null($request->input('changed_files')) ? explode(',', $request->input('changed_files')) : [];

        // Get old saved files to manipulate(remove or update!)
        $saved_files = range(0, count($product->getAttribute('files')) - 1);// Get indexes!
        // Get final fields count : title is always there!
        $fields = range(0, count($request->input('file.title')) - 1);

        $show_default = $request->input('show_default'); // selected image to show as default
        $delete_img = array_filter(array_diff($saved_files, $fields)); // store selected images for delete option => manipulate for updated and removed images
        $hide_img = []; // store selected images for hide option
        if (!is_null($request->input('option'))) {
            foreach ($request->input('option') as $option) {
                $exp_val = explode('-', $option);
                if ($exp_val[1] !== $show_default) { // do not process any option on default image
                    if ($exp_val[0] === 'h') { // hide : h-1
                        $hide_img = array_merge($hide_img, [(int)$exp_val[1]]);
                    }
                    if ($exp_val[0] === 'd') { // delete d-2
                        $delete_img = array_merge($delete_img, [(int)$exp_val[1]]);
                    }
                }
            }
        }

        // Result of loop // Processed:count
        $sort = 1;
        // Process on old files changed or not changed
        foreach ($fields as $iteration) {
            if (in_array($iteration, $delete_img)) {
                continue;
            }
            // Find the file Or Create new one!
            $file = ProductFile::query()->findOrNew($product->files[$iteration]->id??null);
            if (in_array($iteration, $saved_files)) {
                // Process file changes
                if (in_array($iteration, $changed_files) && $request->hasFile('file.file.' . $iteration)) {
                    // **If an old file is updated, old image should be removed**
                    array_push($delete_img, $iteration);
                    // Set new file
                    $file->link = imageUploader($request, 'file.file.' . $iteration, 'product/' . $product->getAttribute('id'));
                } else {
                    // Set old file
                    $file->link = $product->getAttribute('files')[$iteration]->getAttribute('link');
                }

                // Process title changes
                if (in_array($iteration, $changed_titles)) {
                    // Set new title
                    $file->title = $request->input('file.title.' . $iteration);
                } else {
                    // set old title
                    $file->title = $product->getAttribute('files')[$iteration]->getAttribute('title');
                }

            } else {
                // New Uploaded Field
                if ($request->hasFile('file.file.' . $iteration)) {

                    $file->title = $request->input('file.title.' . $iteration);
                    $file->link = imageUploader($request, 'file.file.' . $iteration, 'product/' . $product->getAttribute('id'));

                }
            }

            // Process status changes
            if ((int)$iteration === (int)$show_default) {
                $file->status = '2'; // set as default
            } else {
                $file->status = '1'; // just show it
            }
            if (in_array($iteration, $hide_img)) {
                $file->status = '0'; // don't show it
            }

            // Set constants
            $file->product_id = $product->getAttribute('id'); // product id
            $file->type = 0; // its always image
            $file->sort = $sort++; // sort is automatic.
            // Save final object
            $file->save([$file->toArray()]);
        }
        if (!is_null($delete_img)) {
            foreach ($delete_img as $image) {
                // unlink updated old file and marked images to delete and deleted fields
                $file_path = public_path($product->getAttribute('files')[$image]->getAttribute('link'));
                (file_exists($file_path)) ? unlink($file_path) : null;
                $file = $product->getAttribute('files')[$image]->getAttribute('id');
                $file = ProductFile::query()->find($file);
                $file->forceDelete();
            }
        }

        /*TODO: MAKE MORE PROFESSIONAL WITHOUT DETACHING EVERY TIME*/
        /*UPDATE ATTRIBUTES*/
        if($request->has('attribute.id')){
            /*DELETE OLD VALUES*/
            if($product->attrs->count()){
                $product->attrs()->detach();
            }

            $attr_ids = $request->input('attribute.id');
            $attr_values = $request->input('attribute.value');

            foreach($attr_ids as $id_key=>$id_val){
                //['attr.id' => ["attr_value"=>'attr.value']]
                //['8'=> ["attr_value"=>"300g"]]
                /*DIRECT ATTACH ATTRIBUTE*/
                $product->attrs()->attach(
                    [$id_val=> ['attr_value'=>$attr_values[$id_key]]]
                );
            }
        }

        $product->update(array_merge(
            $request->except('title_en'),
            ['title_en' => Str::slug($request->input('title_en'))]
        ));

        return response()->redirectToRoute('products.index')->with('success', ' محصول ' . $product->getAttribute('title') . ' با موفقیت به روز رسانی شد ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(int $id): JsonResponse
    {
        $product = Product::withoutTrashed()->findOrFail($id);
        /*DELETE PRODUCT ATTRIBUTES*/
        if($product->attrs->count()){
            $product->attrs->detach();
        }

        $product->delete();
        return response()->json('محصول ' . $product->getAttribute('title') . ' با موفقیت حذف شد');
    }
}
