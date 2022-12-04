<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use App\Services\Helpers\Telegram;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function dd;
use function view;

class RegistrationController extends Controller
{
    public function registrationView()
    {
        return view('auth.registration');
    }

    public function registration(RegistrationRequest $request)
    {
        $validatedFields = $request->all();

        event(new UserRegistered(
            $user = $this->create($validatedFields)
        ));

        $this->guard()->login($user, true);

        return redirect()->route('homePage')->with('success', sprintf(
            'Пользователь %s успешно зарегистрирован!',
            $user->name
        ));
    }

    public function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role_id'  => 3
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }
}
