<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\UserLogInNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        if(Auth::attempt($request->only(['email', 'password']), $request->boolean('remember'))) {
            $user = Auth::user();

            $admin = User::getAdmin();

            Notification::send($admin, new UserLogInNotification($user));
            return redirect()->route('homePage')->with('success', sprintf(
                'С возвращением %s',
                $user->name
            ));
        }

        return back()->with('error', 'Неверные данные!');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
