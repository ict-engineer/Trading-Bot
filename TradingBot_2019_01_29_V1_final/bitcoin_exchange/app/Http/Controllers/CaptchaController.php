<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    //
    public function create(){
        return view('auth.user_register');
    }

    public function captchaValidate(Request $request)
    {
        
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
