<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        // Only admin can watch admin panel
        Gate::authorize('admin-view', [self::class]);

        return view('admin.index');
    }
}
