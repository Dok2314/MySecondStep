<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Notifications\UserLogInNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $rateLimitingKey = $request->input('email') . '|' . $request->ip();

        if(Auth::attempt($request->only(['email', 'password']), $request->boolean('remember'))) {
            $user = Auth::user();

            $admin = User::getAdmin();

            Notification::send($admin, new UserLogInNotification($user));
            return redirect()->route('homePage')->with('success', sprintf(
                'С возвращением %s',
                $user->name
            ));
        }

        if (RateLimiter::tooManyAttempts($rateLimitingKey,  $perMinute = 5)) {
            $seconds = RateLimiter::availableIn($rateLimitingKey);

            return back()->with('error', 'Вы превысили максимально допустимое количество попыток. Осталось ждать: '.$seconds.' секунд.');
        }

         RateLimiter::hit($rateLimitingKey, 120);

        return back()->with('error', sprintf(
            'Неверные данные. Осталось попыток: %d',
            RateLimiter::retriesLeft($rateLimitingKey, $perMinute)
        ));
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
