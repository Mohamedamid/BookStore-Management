<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('permission', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions')
            ->with('status', 'Permission added successfully!')
            ->with('status_type', 'success');
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions')
            ->with('status', 'Permission updated successfully!')
            ->with('status_type', 'success');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions')
            ->with('status', 'Permission deleted successfully!')
            ->with('status_type', 'danger');
    }
}
