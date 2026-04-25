<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function index()
    {
        Gate::authorize('permission.view');
        $roles = Role::with('permissions')->get();
        return view('permissions.index', compact('roles'));
    }

    public function edit($id)
    {
        Gate::authorize('permission.edit');
        $role = Role::findOrFail($id);
        
        // Groupement des permissions par module (ex: 'user.create' -> 'user')
        $permissions = Permission::all()->groupBy(fn($p) => explode('.', $p->name)[0]);

        return view('permissions.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('permission.edit');
        $role = Role::findOrFail($id);

        // Synchronisation des permissions au rôle
        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        } else {
            $role->syncPermissions([]);
        }
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        return redirect()
            ->route('permissions.index')
            ->with('success', "Permissions du rôle '{$role->name}' mises à jour.");
    }
}