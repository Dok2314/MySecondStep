<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\IndexController;


Route::get('/', [IndexController::class, 'index'])->name('aIndex');
Route::get('/all', [IndexController::class, 'all'])->name('all');
