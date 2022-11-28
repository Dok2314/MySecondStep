<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Пароль должен содержать: хотя бы 1 цифру, хотя бы 1 букву, хотя бы 1 символ, верхний/нижний регистр
        Password::defaults(function () {
            return Password::min(8)->numbers()->letters()->symbols()->mixedCase();
        });
    }
}
