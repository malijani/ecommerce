<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ImageMenu;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'لیست منو های تصویری';
        $image_menus = ImageMenu::query()
            ->orderByDesc('type')
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();
        return response()->view('admin.image-menu.index', [
            'title' => $title,
            'image_menus' => $image_menus
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'افزودن منو تصویری جدید';
        return response()->view('admin.image-menu.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:2|max:50',
            'link' => 'required|string|min:2|max:100',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:1024',
            'type' => 'required|numeric|in:0,1,2,3,4',
            'status' => 'required|numeric|in:0,1'
        ]);
        $image = imageUploader($request, 'image', 'image_menu');

        $image_menu = ImageMenu::query()->create(array_merge(
            $request->except('image'),
            ['image' => $image],
            ['user_id' => Auth::id()]
        ));

        return response()
            ->redirectToRoute('image-menus.index')
            ->with('success', 'تصویر منو ' . $image_menu->title . ' با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $image_menu = ImageMenu::query()->findOrFail($id);
        $title = ' بروز رسانی منو تصویری  ' . $image_menu->title;
        return response()
            ->view('admin.image-menu.edit', [
                'image_menu' => $image_menu,
                'title' => $title
            ]);
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
        $image_menu = ImageMenu::query()->findOrFail($id);

        $request->validate([
            'title' => 'required|string|min:2|max:50',
            'link' => 'required|string|min:2|max:100',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:1024',
            'type' => 'required|numeric|in:0,1,2,3,4',
            'status' => 'required|numeric|in:0,1'
        ]);
        $image = $image_menu->image;
        if ($request->hasFile('image')) {
            unlink(public_path($image_menu->image));
            $image = imageUploader($request, 'image', 'image_menu');
        }

        $image_menu->update(array_merge(
            $request->except('image'),
            ['image' => $image]
        ));

        return response()
            ->redirectToRoute('image-menus.index')
            ->with('success', 'تصویر منو ' . $image_menu->title . ' با موفقیت بروز رسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image_menu = ImageMenu::query()->findOrFail($id);
        unlink(public_path($image_menu->image));
        $image_menu->delete();
        return response()
            ->redirectToRoute('image-menus.index')
            ->with('warning', 'تصویر منو '. $image_menu->title . ' با موفقیت حذف شد!');
    }
}
