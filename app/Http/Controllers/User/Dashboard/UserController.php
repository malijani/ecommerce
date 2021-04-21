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

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'family' => ['required', 'string', 'max:50'],
            'mobile' => ['required', 'iran_mobile', 'unique:users,mobile,' . $user->id],

            'current_password' => ['nullable', 'string', 'min:8'],
            'password' => ['nullable', 'required_with:current_password', 'exclude_if:current_password,null', 'string', 'min:8', 'confirmed'],
        ], [
            'name'=>[
                'required'=>'تعیین نام کاربر الزامیست',
                'string'=>'لطفا از حروف مناسب برای تعیین نام کاربر استفاده نمایید.',
                'max'=>'نام کاربر حداکثر ۵۰ کاراکتر باشد',
            ],
            'family'=>[
                'required'=>'تعیین نام خانوادگی کاربر الزامیست',
                'string'=>'لطفا از حروف مناسب برای تعیین نام خانوادگی کاربر استفاده نمایید.',
                'max'=>'نام خانوادگی کاربر حداکثر ۵۰ کاراکتر باشد',
            ],
            'mobile'=>[
                'required'=>'تعیین شماره تلفن همراه کاربر الزامیست',
                'iran_mobile'=>'شماره تلفن همراه کاربر باید معتبر و درون شبکه ایران باشد',
                'unique'=>'این شماره تلفن قبلاً توسط کاربر دیگری ثبت شده',
            ],
            'current_password'=>[
                'string'=>'لطفاً از حروف مناسب برای تعیین رمز عبور استفاده نمایید',
                'min'=>'رمز عبور حداقل باید دارای ۸ کاراکتر باشد'
            ],
            'password'=>[
                'required_with'=>'لطفا پسورد کنونی خود را تعیین نمایید',
                'string'=>'لطفاً از حروف مناسب برای تعیین رمز عبور جدید استفاده نمایید',
                'min'=>'رمز عبور جدید حداقل باید دارای ۸ کاراکتر باشد',
                'confirmed' => 'لطفاً در تکرار رمز عبور جدید خود دقت فرمایید',
            ],
        ]);


        $new_password = Auth::user()->password;
        /*CONTROL PASSWORD IF PRESENT*/
        if (!is_null($request->input('current_password')) && !is_null($request->input('password'))) {
            $current_password = $request->input('current_password');
            if (Hash::check($current_password, Auth::user()->password)) {
                $new_password = Hash::make($request->input('password'));
            } else {
                return back()->with('error' , 'خطایی در بروز رسانی رمز عبور رخ داده، لطفاً دوباره تلاش کنید.');
            }
        }


        $user->update(array_merge(
            $request->except('password'),
            ['password' => $new_password]
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
