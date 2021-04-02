<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;

class VerificationTokenController extends Controller
{
    public function verifytoken()
    {
        return view('auth.passwords.verificationToken');
    }

    public function postVerifyToken(Request $request)
    {
        $user = User::whereActivation_token($request->activation_token)->first();
        if($user == null) {
            return redirect()->back()->with('error', 'Mã OTP của bạn chưa đúng.');
        } else {
            $user->update([
                'activation_token' => rand(100000, 999999)
            ]);

            $token = $user->activation_token;
            return redirect(route('password.reset', compact('token')))->with('success', 'Mời bạn nhập mật khẩu mới');
        }
    }
}
