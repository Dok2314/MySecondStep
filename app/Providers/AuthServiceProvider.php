<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\AdminController;
use App\Models\Permission;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
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
        AdminController::class => UserPolicy::class
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

//        Gate::denyIf(fn ($user) => $user->banned());

        $permissions = cache()->remember('permissions', 60, fn () => Permission::all());

        foreach ($permissions as $permission) {
            Gate::define($permission->code, function (User $user) use($permission) {
                return $user->hasPermission($permission->code);
            });
        }
    }
}
