<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\SmsVerifyMethod;
use App\Http\Controllers\Controller;
use App\Rules\Throttle;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SanjabVerify\Models\VerifyLog;
use SanjabVerify\Support\Facades\Verify;

class AuthController extends Controller
{

    /**
     * Show the login form
     */
    public function showLogin()
    {
        $requested = !empty(session()->get('login.mobile'));
        $title = 'ثبت نام/ورود به ' . config('app.brand.name');
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
            ->firstOrCreate(
                [
                    'mobile' => $request->input('mobile')
                ],
                [
                    'uuid' => generateUniqueString(app('App\\User'), 'uuid', 10)
                ]
            );

        $result = $this->sendCode($user);

        // If user exceed limitation or any unwanted error happens
        if (!$result['success']) {
            // Show error message
            return redirect(route('login'))
                ->with('error', $result['message']);
        }

        session()->put('login', []);
        session()->put('login.mobile', $user->mobile);

        return redirect(route('verify.show'))
            ->with('success', $result['message']);

    }

    public function showVerify()
    {
        /*CHECK LOGIN SESSION FOR USER*/
        $login = session()->get('login') ?? [];
        if (empty($login)) {
            return redirect(route('login'))
                ->with('error', 'لطفاً شماره تلفن خود را وارد نمایید!');
        }

        $mobile = (array_key_exists('mobile', $login)) ? $login['mobile'] : null;

        /*$lastestLog = VerifyLog::where('ip', request()->ip())->orWhere('receiver', $mobile)->latest()->first();
        $delay = config('verify.resend_delay') - $lastestLog->created_at->diffInSeconds();*/
        if (empty(User::withoutTrashed()->where('mobile', $mobile)->first())) {
            session()->forget('login');
            return redirect(route('login'))
                ->with('error', 'شماره تلفن شما به درستی ثبت نشده! دوباره امتحان نمایید');
        }

        return view('auth.verify', [
            'title' => 'تایید حساب کاربری',
            'mobile' => $mobile,
            /*'delay' => $delay*/
        ]);

    }

    public function doVerify(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ], [
            'code.required' => 'تعیین کد تایید الزامیست.',
            'code.numeric' => 'نوع داده ای کد تایید عددی است.',
            'code.size' => 'کد تایید دارای ۶ عدد است!',
        ]);


        if (empty(session()->get('login'))) {
            session()->forget('login');
            return redirect(route('login'))
                ->with('error', 'خطا در تنظیم مشخصات شما؛ لطفاً دوباره امتحان کنید.');
        }

        $login = session()->get('login');
        $mobile = $login['mobile'] ?? null;
        $code = $request->input('code');

        $user = User::withoutTrashed()
            ->where('mobile', $mobile)
            ->first();

        if (empty($user)) {
            session()->forget('login');
            return redirect(route('login'))
                ->with('error', 'لطفاً دوباره تلاش کنید!');
        }

        $result = $this->verifyCode($mobile, $code);

        if (!$result['success']) {
            return redirect()
                ->back()
                ->with('error', $result['message']); // Show error message
        }

        Auth::login($user, true);
        $request->session()->regenerate();
        session()->forget('login');
        session()->forget('sanjab_verify');

        return redirect(redirect()->intended()->getTargetUrl() ?? route('dashboard.index'))
            ->with('success', 'با موفقیت به حساب کاربری خود وارد شدید.');

    }

    /**
     * Resends the code to the user
     */
    public function resendCode(Request $request)
    {
        if (!$request->ajax()) {
            return redirect(route('login'))
                ->with('error', 'درخواست نامعتبر! لطفاً دوباره تلاش نمایید');
        }

        $mobile = session()->get('login')['mobile'] ?? null;

        $user = User::withoutTrashed()
            ->where('mobile', $mobile)
            ->first();

        if (empty($user)) {
            return response()
                ->json('کاربر مورد نظر یافت نشد! لطفاً در بخش تغییر شماره تلفن دوباره تلاش کنید!', 404);
        }

        $result = $this->sendCode($user);

        if (!$result['success']) { // If user exceed limitation
            return response()->json($result['message'], 403);
        }
        return response()
            ->json('کد احراز هویت با موفقیت ارسال شد.', 200);
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
    protected function verifyCode($mobile, $code)
    {
        return Verify::verify($mobile, $code);
    }

    protected function guard()
    {
        return Auth::guard();
    }

}
