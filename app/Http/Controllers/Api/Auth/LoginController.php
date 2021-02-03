<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt(['mobile'=>$request->mobile, 'password'=>$request->password])){

            $token_result = Auth::user()->createToken('Personal Access Token');
            $token = $token_result->token;
            $token->expires_at = Carbon::now()->addMonth();
            $token->save();
            $data = [
                'access_token'=>'Bearer '. $token_result->accessToken,
                'expires_at'=>Carbon::parse($token->expires_at)->toDateTimeString()
            ];
            return response()->json($data);
        } else {
            return response()->json(['auth_error'=>'Wrong credentials']);
        }

    }
}
