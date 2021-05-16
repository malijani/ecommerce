<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $title = 'مدیریت حساب شما | ' . config('app.name');

        $user = Auth::user();
        return response()->view('front-v1.user.dashboard.profile', [
            'title' => $title,
            'user' => $user,
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::withoutTrashed()->findOrFail($id);

        if (Auth::id() !== $user->id) {
            return back()->with('error', 'دسترسی نامعتبر');
        }

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
            'name' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'min:10', 'max:70'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'pic' => ['nullable', 'mimes:jpg,jpeg,png', 'max:300'],
        ], [

            'name.required' => 'تعیین نام کاربر الزامیست',
            'name.string' => 'لطفا از حروف مناسب برای تعیین نام کاربر استفاده نمایید.',
            'name.max' => 'نام کاربر حداکثر ۵۰ کاراکتر باشد',

            'email.email' => 'ایمیل وارد شده صحیح نیست.',
            'email.max' => 'برای ایمیل حداکثر ۷۰ کاراکتر در نظر گرفته شده است.',
            'email.min' => 'برای ایمیل حداقل ۱۰ کاراکتر در نظر گرفته شده است.',

            'password.string' => 'لطفاً از حروف مناسب برای تعیین رمز عبور جدید استفاده نمایید',
            'password.min' => 'رمز عبور جدید حداقل باید دارای ۸ کاراکتر باشد',
            'password.confirmed' => 'لطفاً در تکرار رمز عبور جدید خود دقت فرمایید',

            'pic.mimes' => 'فرمت تصویر نامعتبر، فرمت های png, jpg, jpeg معتبر هستند.',
            'pic.max' => 'حداکثر حجم فایل 300 کیلوبایت تعیین شده!',
        ]);

        /*UPLOAD IMAGE*/
        if($request->hasFile('pic')){
            $pic = imageUploader($request, 'pic', 'user_profile', 300, 300);
        } else {
            $pic = $user->pic;
        }

        if($request->hasFile('pic') && !is_null($user->pic)){
            unlink(public_path($user->pic));
        }

        $password = Auth::user()->password;
        /*CONTROL PASSWORD IF PRESENT*/
        if (!empty($request->input('password'))) {
            $new_password = $request->input('password');
            if (!Hash::check($new_password, $password)) {
                $password = Hash::make($request->input('password'));
            }
        }

        $user->update(array_merge(
            $request->except('password', 'mobile', 'pic'),
            ['password' => $password],
            ['pic' => $pic]
        ));

        return back()->with('success', 'حساب کاربری شما با موفقیت بروز رسانی شد!');
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
