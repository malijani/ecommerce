<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SmsVerifyMethod;
use App\Http\Controllers\Controller;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SanjabVerify\Support\Facades\Verify;

class ResetPasswordController extends Controller
{
    /*GET USER MOBILE NUMBER*/
    public function getMobile()
    {
        $title = 'بازنشانی رمز عبور';
        return response()->view('auth.passwords.mobile', [
            'title' => $title,
        ]);
    }


    /*SET MOBILE NUMBER AND SEND CODE TO IT*/
    public function sendCode(Request $request)
    {
        $request->validate([
            'mobile'=>['required', 'iran_mobile', 'exists:users,mobile'],
        ],[
            'mobile.required' => 'تعیین شماره تلفن همراه الزامیست.',
            'mobile.iran_mobile' => 'تلفن همراه نامعتبر است',
            'mobile.exists' => 'کاربری با این تلفن همراه وجود ندارد!'
        ]);

        $mobile = $request->input('mobile');

        $result = Verify::request($mobile, SmsVerifyMethod::class);
        if ($result['success'] == false) { // If user exceed limitation
            if($request->ajax()){
                return response()->json( $result['message'], 403);
            }
            return redirect()->back()->with('error', $result['message']); // Show error message
        }

        session()->put('mobile', $mobile);

        if($request->ajax()){
            return response()->json( 'کد بازنشانی رمز عبور با موفقیت ارسال شد',200);
        }
        return response()
            ->redirectToRoute('password.get-code')
            ->with('success', 'کد بازنشانی رمز عبور با موفقیت ارسال شد!');
    }


    /*GET THE CODE FROM USER FOR VALIDATION*/
    public function getCode()
    {
        $title = 'احراز هویت کاربر';
        if(! session()->has('mobile')) {
            return redirect()->back()->with('error', 'شماره موبایل به درستی تعیین نشده!');
        }

        $mobile = session()->get('mobile');

        return response()->view('auth.passwords.verify', [
            'title' => $title,
            'mobile' => $mobile,
        ]);
    }

    /*VALIDATE THE CODE*/
    public function verify(Request $request)
    {
        $request->validate([
            'mobile' => 'required|iran_mobile|size:11',
            'code' => 'required|string|size:6',
        ], [
            'mobile' => [
                'required' => 'تعیین شماره تلفن همراه الزامیست.',
                'iran_mobile' => 'تلفن همراه نامعتبر است',
                'exists' => 'کاربری با این تلفن همراه وجود ندارد!'
            ],
            'code' => [
                'required' => 'تعیین کد تایید الزامیست.',
                'numeric' => 'نوع داده ای کد تایید عددی است.',
                'size' => 'کد تایید دارای ۶ عدد است!',
            ]
        ]);

        $mobile = $request->input('mobile');
        $user = User::query()->where('mobile', $mobile)->first();
        /*CHECK USER MOBILE*/
        if (!is_null($user) && $user->mobile !== $mobile) {
            return redirect()->back()->with('error', 'شماره تلفن همراه اشتباه است!');
        }

        $result = Verify::verify($request->input('mobile'), $request->input('code'));

        if ($result['success'] == false) {
            return redirect()->back()->with('error', $result['message']); // Show error message
        }

        session()->put('security_option', 'reset password is accessible');

        return response()->redirectToRoute('password.reset');

    }


    public function reset()
    {
        $title = 'بازنشانی رمز عبور';

        if(! session()->has('mobile')){
            return response()
                ->redirectToRoute('password.get-mobile')
                ->with('error', 'شماره تلفن همراه به درستی تعیین نشده! مجدداً تلاش نمایید');
        }

        if(! session()->has('security_option') && session()->get('security_option') != 'reset password is accessible'){
            return redirect()->back()->with('error', 'کد تایید به درستی تنظیم نشده! لطفاً دوباره تلاش کنید.');
        }

        $mobile = session()->get('mobile');
        return response()->view('auth.passwords.reset', [
            'title' => $title,
            'mobile' => $mobile
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'iran_mobile', 'exists:users,mobile'],
            'password' => ['required', 'string', 'confirmed', 'min:8']
        ], [
            'mobile' => [
                'required' => 'تعیین شماره تلفن همراه الزامیست.',
                'iran_mobile' => 'تلفن همراه نامعتبر است',
                'exists' => 'کاربری با این تلفن همراه وجود ندارد!'
            ],
            'password' => [
                'required' => 'تعیین رمز عبور جدید الزامیست',
                'confirmed' => 'رمز عبور جدید را دوباره با دقت وارد نمایید',
                'min' => 'رمز عبور حداقل دارای ۸ کاراکتر می باشد.'
            ]
        ]);

        $user = User::query()->where('mobile', $request->input('mobile'))->first();

        if(is_null($user)){
            return response()
                ->redirectToRoute('password.get-code')
                ->with('شماره تلفن نامعتبر!');
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        session()->forget(['security_option', 'mobile']);

        return response()->redirectToRoute('login')
            ->with('رمز عبور با موفقیت تغییر کرد! لطفاً وارد شوید.');
    }
}
