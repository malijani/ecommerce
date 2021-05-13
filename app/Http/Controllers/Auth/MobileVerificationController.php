<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SmsVerifyMethod;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use SanjabVerify\Support\Facades\Verify;

class MobileVerificationController extends Controller
{

    public function index()
    {
        $title = 'تایید اعتبار حساب کاربری ' . config('app.short.name');
        return response()->view('auth.verify', [
            'title' => $title,
        ]);
    }


    public function sendCode()
    {
        $user = Auth::user();

        $result = Verify::request($user->mobile, SmsVerifyMethod::class);

        if ($result['success'] == false) { // If user exceed limitation
            return redirect()->back()->with('error', $result['message']); // Show error message
        }

        return response()->redirectToRoute('verify.index')->with('success', $result['message']);
    }


    public function processCode(Request $request)
    {
        $request->validate([
            'mobile' => 'required|iran_mobile|size:11',
            'code' => 'required|string|size:6',
        ], [
            'code' => [
                'required' => 'تعیین کد تایید الزامیست.',
                'numeric' => 'نوع داده ای کد تایید عددی است.',
                'size' => 'کد تایید دارای ۶ عدد است!',
            ]
        ]);

        $user = User::query()->find(Auth::id());
        /*CHECK USER MOBILE*/
        if (!is_null($user) && $user->mobile !== $request->input('mobile')) {
            return redirect()->back()->with('error', 'شماره تلفن همراه اشتباه است!');
        }

        $result = Verify::verify($request->input('mobile'), $request->input('code'));
        if ($result['success'] == false) {
            return redirect()->back()->with('error', $result['message']); // Show error message
        }

        $user->mobile_verified_at = Carbon::now()->toDateTimeString();
        $user->save();

        return response()
            ->redirectToRoute('dashboard.index')
            ->with('success', 'حساب کاربری شما با موفقیت تایید شد!');

    }


    public function changeNumber()
    {
        $title = 'تغییر شماره تلفن';
        $mobile = Auth::user()->mobile;

        return response()->view('auth.change-number', [
            'title' => $title,
            'mobile' => $mobile
        ]);

    }

    public function doChangeNumber(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'iran_mobile', 'unique:users,mobile'],
        ], [
            'mobile.required' => 'تعیین شماره تلفن همراه الزامیست',
            'mobile.iran_mobile' => 'شماره همراه نامعتبر!',
            'mobile.unique' => 'این شماره همراه قبلاً ثبت شده است.',
        ]);

        $user = User::query()->find(Auth::id());
        $user->mobile = $request->input('mobile');
        $user->save();

        return response()->redirectToRoute('verify.send-code');
    }

}
