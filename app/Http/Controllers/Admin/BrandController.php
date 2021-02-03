<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $title = 'مدیریت برند محصولات';
        $brands = Brand::withoutTrashed()
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();
        return view('admin.brand.index', [
                'title'=>$title,
                'brands'=>$brands
            ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $title = 'افزودن برند جدید';
        return view('admin.brand.create',[
            'title'=>$title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required', 'min:3', 'max:70', 'unique:categories,title'],
            'title_en'=>['required', 'min:3', 'max:70', 'unique:categories,title_en'],
            'text'=>['nullable', 'min:2', 'max:40000'],
            'pic'=>['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt'=>['nullable','min:2', 'max:70'],
            'color'=>['nullable', 'min:3', 'max:10'],
            'keywords'=>['nullable','min:3', 'max:70'],
            'description'=>['nullable', 'min:2', 'max:255'],
            'status'=>['required', 'numeric'],
        ]);

        $pic = $this->imageUploader($request, 'pic', 'brand');

        Brand::query()->create(array_merge(
            $request->except(['pic','title_en']),
            ['pic'=>$pic],
            ['title_en'=>Str::slug($request->input('title_en'))],
            ['user_id'=>Auth::id()]
        ));

        return redirect(route('brands.index'))->with('success', 'برند جدید با موفقیت افزوده شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $brand = Brand::query()->findOrFail($id);
        $title = 'ویرایش '. $brand->title;
        return view('admin.brand.edit',
            [
                'title'=> $title,
                'brand'=>$brand,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::withoutTrashed()->findOrFail($id);
        $request->validate([
            'title'=>['required', 'min:3', 'max:70', 'unique:categories,title,'.$brand->id],
            'title_en'=>['required', 'min:3', 'max:70', 'unique:categories,title_en,'.$brand->id],
            'text'=>['nullable', 'min:2', 'max:40000'],
            'pic'=>['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt'=>['nullable','min:2', 'max:70'],
            'color'=>['nullable', 'min:3', 'max:10'],
            'keywords'=>['nullable','min:3', 'max:70'],
            'description'=>['nullable', 'min:2', 'max:255'],
            'status'=>['required', 'numeric'],
            'delete_pic'=>['nullable','max:2'],
        ]);

        if($request->has('delete_pic')&& $request->input('delete_pic')=="on"){
            if(isset($brand->pic)){
                unlink(public_path($brand->pic));
            }
        }

        $pic = $this->imageUploader($request, 'pic', 'brand');
        if(isset($pic) && isset($brand->pic)){
            unlink(public_path($brand->pic));
        }

        $brand->update(array_merge(
            $request->except(['pic','title_en']),
            ['title_en'=>Str::slug($request->input('title_en'))],
            ['pic'=>$pic],
            ['user_id'=>$brand->user_id]
        ));

        return redirect(route('brands.index'))->with('success', ' برند '. $brand->title . ' باموفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $brand = Brand::withoutTrashed()->findOrFail($id);
        $brand->delete();
        return response()->json('برند '.$brand->title. ' با موفقیت حذف شد');
    }



    /**
     * Image uploader
     * @param Request
     * @param string
     * @return mixed
     */
    private function imageUploader(Request $request, $field, $dir) : ?string
    {
        if ($request->hasFile($field)){
            $file = $request->file($field);
            $name = Str::random(20) . '.' . $file->extension()??'png';
            $path = 'images/'.$dir;
            if(!is_dir($path)){
                mkdir($path, 0777, true);
            }
            $pic = $path .'/'. $name;
            // CONVERT IMAGE TO 300x300 PNG WITH WATERMARK
            $manager = new ImageManager(['driver'=>'imagick']);
            $manager
                ->make($file->path())
                ->resize(300, 300, function($c){
//                    $c->aspectRatio();
//                    $c->upsize();
                })
                ->insert(env('WATERMARK_PATH', 'images/watermark/watermark-80.png'), 'bottom-right', 5, 5)
                ->encode('png')
                ->save($pic);
            return $pic;
        } else {
            return null;
        }
    }
}
