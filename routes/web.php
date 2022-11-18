<?php

use App\Http\Controllers as C;
use App\Http\Controllers\Auth AS AuthControllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CRUD as CRUD;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [C\HomeController::class, 'home'])->name('homePage');

//Route::get('/test', function () {
//
//});

Route::group(['prefix' => 'authorization', 'as' => 'auth.'], function() {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/registration', [AuthControllers\RegistrationController::class, 'registrationView'])
            ->name('registration');

        Route::post('/registration', [AuthControllers\RegistrationController::class, 'registration']);

        Route::get('/login', [AuthControllers\LoginController::class, 'loginView'])
            ->name('login');

        Route::post('/login', [AuthControllers\LoginController::class, 'login']);

        Route::get('/registration-reload-captcha', [AuthControllers\RegistrationController::class, 'reloadCaptcha']);
        Route::get('/login-reload-captcha', [AuthControllers\LoginController::class, 'reloadCaptcha']);
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', function () {
            Auth::logout();

            return redirect()->route('homePage');
        })->name('logout');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::put('/restore/{id}', [CRUD\Post\PostController::class, 'restore'])
        ->name('posts.restore');

    Route::get('posts/{Id}/comments/create', [CRUD\Comment\CommentController::class, 'create'])
        ->name('commentToPost.create');

    Route::resources([
        'posts'     => CRUD\Post\PostController::class,
        'comments'  => CRUD\Comment\CommentController::class
    ]);
});
