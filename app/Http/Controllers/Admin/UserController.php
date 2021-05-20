<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'مدیریت کاربران وبسایت';

        $users = User::withoutTrashed()
            ->orderByDesc('level')
            ->orderByDesc('status')
            ->orderByDesc('id')
            ->get();

        return response()->view('admin.user.index', [
            'title' => $title,
            'users' => $users
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): Response
    {
        $title = 'افزودن کاربر جدید';
        return response()->view('admin.user.create', [
            'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['nullable', 'string', 'max:50'],
            'mobile' => ['required', 'iran_mobile', 'unique:users,mobile'],
            'email' => ['nullable', 'string', 'email', 'max:70', 'unique:users'],
            'level' => ['required', 'numeric', 'in:0,121'],
            'status' => ['required', 'numeric', 'in:0,1'],
            'pic' => ['nullable', 'mimes:jpg,jpeg,png', 'max:300']
        ]);

        $pic = imageUploader($request, 'pic', 'user_profile', 300, 300);
        $uuid = generateUniqueString(app('App\\User'), 'uuid', 10);

        User::query()->create(array_merge(
            $request->except('pic'),
            ['uuid' => $uuid],
            ['pic' => $pic]
        ));

        return response()->redirectToRoute('users.index')->with('success', 'کاربر جدید با موفقیت افزوده شد!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withoutTrashed()->findOrFail($id);
        $title = ' مشخصات کاربر ' . $user->full_name;

        return response()->view('admin.user.show', [
            'user' => $user,
            'title' => $title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::withoutTrashed()->findOrFail($id);
        $title = 'ویرایش کاربر ' . $user->full_name;
        return response()->view('admin.user.edit', [
            'user' => $user,
            'title' => $title,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::withoutTrashed()->findOrFail($id);

        if ($request->ajax()) {
            $request->validate([
                'delete' => 'required|in:true',
            ]);
            unlink(public_path($user->pic));
            $user->pic = null;
            $user->save();
            return redirect()->back()->with('success', 'تصویر پروفایل با موفقیت حذف شد');
        }

        $request->validate([
            'name' => ['nullable', 'string', 'max:50'],
            'mobile' => ['required', 'iran_mobile', 'unique:users,mobile,' . $user->id],
            'email' => ['nullable', 'string', 'email', 'max:70', 'unique:users,email,' . $user->id],
            'level' => ['required', 'numeric', 'in:0,121'],
            'status' => ['required', 'numeric', 'in:0,1'],
        ]);

        /*UPLOAD IMAGE*/
        if ($request->hasFile('pic')) {
            $pic = imageUploader($request, 'pic', 'user_profile', 300, 300);
            if (!is_null($user->pic)) {
                unlink(public_path($user->pic));
            }
        } else {
            $pic = $user->pic;
        }


        $user->update(array_merge(
            $request->all(),
            ['pic' => $pic]
        ));

        return response()->redirectToRoute('users.index')->with('success', 'کاربر ' . $user->full_name . ' با موفقیت بروزرسانی شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::withoutTrashed()->findOrFail($id);
        $user->delete();
        return response()->redirectToRoute('users.index')->with('warning', 'کاربر ' . $user->full_name . ' با موفقیت حذف شد!');
    }
}
