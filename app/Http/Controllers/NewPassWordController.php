<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetLink;

class NewPassWordController extends Controller
{
    //
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        $url = 'token=' .$token;
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('mails.forgetPassword', ['url' =>  $url], function($message) use($request){
            $message->to($request->email);
            $message->subject('[Cellphones] Tạo mới mật khẩu');
        });

        return response()->json([
            "message" => "We have send you a link to reset password!",
            "token" => $token,

        ]);
    }
    public function showResetPasswordForm($token) {
        return view('mails.forgetPasswordLink', ['token' => $token]);
    }
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if(!$updatePassword){
            return response()->json([
                "message" => "Invalid Token"
            ]);
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return response()->json([
            "message" => "Your password has been changed",
            "data" => $user

        ]);
    }

    public function sendmail(Request $request){
        $user = $request->user();
        Mail::to($user->email)->send(new ResetLink);
    }
}
