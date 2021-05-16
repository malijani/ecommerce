<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SmsVerifyMethod;
use App\Http\Controllers\Controller;
use App\Rules\Throttle;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SanjabVerify\Support\Facades\Verify;

class AuthController extends Controller
{

    /**
     * Show the login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Do the login process
     */
    public function doLogin(Request $request)
    {
        $request->validate([
            'mobile' => ['bail', 'required', 'iran_mobile', new Throttle('mobile')],
        ], [
            'mobile.required' => 'تعیین شماره تلفن همراه الزامیست',
            'mobile.iran_mobile' => 'تلفن همراه نامعتبر'
        ]);

        $user = User::withoutTrashed()
            ->where('mobile', $request->input('mobile'))
            ->firstOrCreate([
                'mobile' => $request->input('mobile')
            ]);

        $result = $this->sendCode($user);

        // If user exceed limitation or any unwanted error happens
        if (!$result['success']) {
            // Show error message
            return redirect(route('login'))
                ->with('error', $result['message']);
        }


        return view('auth.verify', [
            'title' => 'تایید حساب کاربری',
            'mobile' => $user->mobile,
            'remember' => (is_null($request->input('remember'))) ? false : true,
        ]);

    }


    /**
     * Logs out the user
     */
    public function doLogout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }


    public function doVerify(Request $request)
    {
        $request->validate([
            'mobile' => 'required|iran_mobile|exists:users,mobile',
            'code' => 'required|string|size:6',
        ], [
            'remember.in' => 'مقدار غیر مجاز برای به یاد آوری حساب',
            'remember.string' => 'مقدار غیر مجاز برای به یاد آوری حساب',
            'mobile.required' => 'تعیین شماره تلفن همراه الزامیست',
            'mobile.iran_mobile' => 'تلفن همراه نامعتبر',
            'mobile.exists' => 'این تلفن همراه ثبت نشده!',
            'code.required' => 'تعیین کد تایید الزامیست.',
            'code.numeric' => 'نوع داده ای کد تایید عددی است.',
            'code.size' => 'کد تایید دارای ۶ عدد است!',
        ]);

        $user = User::withoutTrashed()
            ->where('mobile', $request->input('mobile'))
            ->first();

        /*CHECK USER MOBILE*/
        if (!is_null($user) && $user->mobile !== $request->input('mobile')) {
            return redirect()
                ->back()
                ->with('error', 'شماره تلفن همراه اشتباه است!');
        }

        $result = $this->verifyCode($request);

        if (!$result['success']) {
            return redirect()
                ->back()
                ->with('error', $result['message']); // Show error message
        }

        /*        $user->mobile_verified_at = Carbon::now()->toDateTimeString();
                $user->save();*/
        Auth::login($user, $request->has('remember'));

        return redirect(route('dashboard.index'))
            ->with('success', 'با موفقیت به حساب کاربری خود وارد شدید.');

    }


    public function resendCode(Request $request)
    {
        if (!$request->ajax()) {
            return redirect(route('login'))
                ->with('error', 'درخواست نامعتبر! لطفاً دوباره تلاش نمایید');
        }

        $request->validate([
            'mobile' => 'required|iran_mobile|exists:users,mobile',
        ], [
            'mobile.required' => 'تعیین شماره تلفن همراه الزامیست',
            'mobile.iran_mobile' => 'تلفن همراه نامعتبر',
            'mobile.exists' => 'این تلفن همراه ثبت نشده!',
        ]);

        $result = $this->sendCode($request->input('mobile'));
        if (!$result['success']) { // If user exceed limitation
            return response()->json($result['message'], 403);
        }
        return response()->json( 'کد بازنشانی رمز عبور با موفقیت ارسال شد',200);
    }

    /**
     * Send verification code to user method
     */
    protected function sendCode(User $user)
    {
        return Verify::request($user->mobile, SmsVerifyMethod::class);
    }

    /**
     * Verify the code that has been sent to the user
     */
    protected function verifyCode(Request $request)
    {
        return Verify::verify($request->input('mobile'), $request->input('code'));
    }

    protected function guard()
    {
        return Auth::guard();
    }

}
