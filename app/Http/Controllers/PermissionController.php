<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        Gate::authorize('permission.view');
        $employes = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('permissions.index', compact('employes', 'roles', 'permissions'));
    }
    public function edit($id)
    {
        $employe = User::with('roles', 'permissions')->findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all()->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('permissions.edit', compact('employe', 'roles', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $employe = User::findOrFail($id);

     
        if ($request->has('role')) {
            $employe->syncRoles([$request->role]);
        }

       
        if ($request->has('permissions')) {
            $employe->syncPermissions($request->permissions);
        } else {
            $employe->syncPermissions([]);
        }

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permissions mises à jour avec succès');
    }

}
