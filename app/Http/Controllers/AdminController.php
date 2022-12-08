<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        // Only admin can watch admin panel
        Gate::authorize('admin-view', [self::class]);

        $roles = DB::table('users')
            ->select(DB::raw('role_id, count(*) as cou'))
            ->groupBy('role_id')->get();

        $roles_for_chart = [];

        foreach ($roles as $role) {
            $roles_for_chart[] = [
                'count'  => $role->cou,
                'role'   => Role::find($role->role_id)->name,
            ];
        }

        $roles_for_chart = json_encode($roles_for_chart);

        return view('admin.index', compact('roles_for_chart'));
    }
}
