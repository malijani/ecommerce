<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SmsVerifyMethod;
use App\Http\Controllers\Controller;
use App\Rules\Throttle;

use App\User;
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
        $requested = !empty(session()->get('login')['mobile']);
        $title = 'ثبت نام/ورود به ' . config('app.short.name');
        return view('auth.login', [
            'title' => $title,
            'requested' => $requested,
        ]);
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


        session()->put('login', [
            'mobile' => $user->mobile,
            'remember' => $request->has('remember'),
        ]);

        return redirect(route('verify.show'))
            ->with('success', $result['message']);

    }

    public function showVerify()
    {
        /*CHECK LOGIN SESSION FOR USER AND REMEMBER*/
        $login = session()->get('login') ?? [];
        if (empty($login)) {
            return redirect(route('login'))
                ->with('error', 'لطفاً شماره تلفن خود را وارد نمایید!');
        }
        $mobile = (array_key_exists('mobile', $login)) ? $login['mobile'] : null;
        $remember = (array_key_exists('remember', $login)) ? $login['remember'] : null;

        if(empty(User::withoutTrashed()->where('mobile', $mobile)->first())){
            session()->forget('login');
            return redirect(route('login'))
                ->with('error', 'شماره تلفن شما به درستی ثبت نشده! دوباره امتحان نمایید');
        }

        return view('auth.verify', [
            'title' => 'تایید حساب کاربری',
            'mobile' => $mobile,
            'remember' => $remember
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
        session()->forget('login');
        session()->regenerate();

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

        $user = User::withoutTrashed()
            ->where('mobile', $request->input('mobile'))
            ->first();
        if(empty($user)){
            return response()->json('کاربر مورد نظر یافت نشد! لطفاً در بخش تغییر شماره تلفن دوباره تلاش کنید!', 404);
        }

        $result = $this->sendCode($user);
        if (!$result['success']) { // If user exceed limitation
            return response()->json($result['message'], 403);
        }
        return response()->json('کد بازنشانی رمز عبور با موفقیت ارسال شد', 200);
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
