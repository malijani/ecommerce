<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $title = 'مدیریت دسته بندی ها';
        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->withCount('childrenRecursive')
            ->where('parent_id', 0)
            ->orderBy('children_recursive_count','ASC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();

        return view('admin.category.index',
            [
                'title'=>$title,
                'categories'=>$categories,

            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        $title = 'افزودن دسته بندی جدید';
        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->withCount('childrenRecursive')
            ->where('parent_id', 0)
            ->where('status', true)
            ->orderBy('children_recursive_count','ASC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();



        return view('admin.category.create',
            [
                'title'=>$title,
                'categories'=>$categories,

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
            'parent_id'=>['required', 'numeric'],
            'status'=>['required', 'numeric'],
            'menu'=>['required', 'numeric'],
        ]);

        $pic = imageUploader($request, 'pic', 'category', 300, 300, false);

        Category::query()->create(array_merge(
            $request->except(['pic','title_en']),
            ['pic'=>$pic],
            ['title_en'=>Str::slug($request->input('title_en'))],
            ['user_id'=>Auth::id()]
        ));

        return redirect(route('categories.index'))->with('success', 'دسته بندی جدید با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function show($id)
    {
        // GET FIRST CHILDREN OF EACH CATEGORY BASED ON PARENT_ID
        $child_categories =  Category::withoutTrashed()
            ->where('parent_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();
        // CREATE TABLE
        $table_data_class = 'align-middle text-center';
        $table = '<table id="datatable-categories" class="table table-bordered table-striped table-hover ">';
        $table.="<thead>";
        $table .= "<tr class='$table_data_class'>";
        $table .= "<th>#</th>";
        $table .= "<th colspan='2'>عنوان</th>";
        $table .= "<th>توضیحات</th>";
        $table .= "<th>وضعیت</th>";
        $table .= "<th>عملیات</th>";
        $table .= "</tr>";
        $table .= "</thead>";
        $table .= "<tbody class='sortable-list agile-list'>";
        if($child_categories->count()) {
            foreach ($child_categories as $child) {
                // SET OPTION ROUTES
                $edit_route = route('categories.edit', ['category' => $child->id]);
                $delete_route = url('admin/categories/');

                // START ROW
                $table .= "<tr class='$table_data_class' id='data$child->id'>";

                // ID
                $table .= "<td class='$table_data_class'>$child->id </td>";

                // TITLE & PICTURE
                $table .= "<td class='$table_data_class'>";
                $table .= '<img src='. asset($child->pic ?? 'images/fallback/category.png') . ' alt='."$child->pic_alt ?? $child->title ".' class="img rounded-circle " width="100vw" height="100vh">';
                $table.="</td>";
                $table .= "<td class='$table_data_class'>$child->title</td>";

                // TRUNCATED TEXT
                $table .= "<td class='$table_data_class'>" . Str::words(strip_tags($child->text), 10) . "</td>";

                // STATUS
                $table .= "<td class='$table_data_class'>";
                if ($child->status == 1) {
                    $table .= "<i class='fa fa-check text-success'></i>";
                    $table .= "<span class='hide'>1</span>";
                } else {
                    $table .= "<i class='fa fa-close text-danger'></i>";
                    $table .= "<span class='hide'>0</span>";
                }
                $table .= "</td>";

                // EDIT AND DELETE OPTIONS
                $table .= "<td class='$table_data_class'>";
                // ---- EDIT OPTION
                $table .= "<a title='ویرایش' href='$edit_route' class='btn btn-outline-info btn-sm ml-1 mb-1' role='button'><i class='fa fa-edit'></i></a>";
                // ---- DELETE OPTION
                $table .= "<button title='حذف' class='btn btn-outline-danger btn-sm inline mb-1' id='del$child->id' data-url='$delete_route/$child->id' onclick='del($child->id);'>";
                $table .= "<i class='fa fa-trash'></i>";
                $table .= "</button>";

                $table .= "</td>";
                // END ROW
                $table .= "</tr>";
            }
         }

        $table .= "</tbody>";
        $table .= "<tfoot>";
        $table .= "<tr class='$table_data_class'>";
        $table .= "<th>شناسه</th>";
        $table .= "<th colspan='2'>عنوان</th>";
        $table .= "<th>توضیحات</th>";
        $table .= "<th>وضعیت</th>";
        $table .= "<th>عملیات</th>";
        $table .= "</tr>";
        $table .= "</tfoot>";
        $table .= "</table>";
        return $table;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {

        $categories = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->withCount('childrenRecursive')
            ->where('parent_id', 0)
            ->where('status', true)
            ->orderBy('children_recursive_count','ASC')
            ->orderBy('created_at', 'DESC')
            ->orderBy('sort', 'ASC')
            ->get();



        $category = Category::query()->findOrFail($id);
        $children = $this->getChildren($category);
        $parent_id = ($category->parent_id != 0 ? $category->parent_id : null);
        $title = 'ویرایش '. $category->title;
        return view('admin.category.edit',
            [
                'title'=> $title,
                'category'=>$category,
                'children'=>$children,
                'parent_id'=>$parent_id,
                'categories'=>$categories,
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
        $category = Category::withoutTrashed()->findOrFail($id);
        $request->validate([
            'title'=>['required', 'min:3', 'max:70', 'unique:categories,title,'.$category->id],
            'title_en'=>['required', 'min:3', 'max:70', 'unique:categories,title_en,'.$category->id],
            'text'=>['nullable', 'min:2', 'max:40000'],
            'pic'=>['nullable', 'mimes:jpg,jpeg,png,gif', 'max:10240'],
            'pic_alt'=>['nullable','min:2', 'max:70'],
            'color'=>['nullable', 'min:3', 'max:10'],
            'keywords'=>['nullable','min:3', 'max:70'],
            'description'=>['nullable', 'min:2', 'max:255'],
            'parent_id'=>['required', 'numeric'],
            'status'=>['required', 'numeric'],
            'menu'=>['required', 'numeric'],
            'delete_pic'=>['nullable','max:2'],
        ]);

        if($request->has('delete_pic')&& $request->input('delete_pic')=="on"){
            if(isset($category->pic)){
                unlink(public_path($category->pic));
            }
        }

        $pic = imageUploader($request, 'pic', 'category', 300, 300, false);
        if(!is_null($pic) && !is_null($category->pic)){
            unlink(public_path($category->pic));
        }

        $category->update(array_merge(
            $request->except(['pic','title_en']),
            ['title_en'=>Str::slug($request->input('title_en'))],
            ['pic'=>$pic??$category->pic],
            ['user_id'=>$category->user_id]
        ));

        return redirect(route('categories.index'))->with('success', ' دسته بندی '. $category->title . ' باموفقیت ویرایش شد. ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $category = Category::withoutTrashed()
            ->with('childrenRecursive')
            ->findOrFail($id);
        $array_of_ids = $this->getChildren($category);
        array_push($array_of_ids, $id);
        Category::destroy($array_of_ids);
        return response()->json('دسته بندی مورد نظر با موفقیت حذف شد.');
    }

    /**
     * Collect all sub categories ids to perform an action
     * @param Category
     * @return array
     */
    private function getChildren($category): array
    {
        $ids=[];
        foreach($category->children as $children){
            $ids[]= $children->id;
            $ids = array_merge($ids, $this->getChildren($children));
        }
        return $ids;
    }


}


