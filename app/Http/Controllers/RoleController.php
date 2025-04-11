<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        return view('role', compact('roles', 'permissions'));
    }

    
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'discription' => $request->description,
        ]);
        $role->permissions()->sync($request->permissions); 

        return redirect()->route('role')->with('status', 'Rôle créé avec succès !');
    }

    
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('editRole', compact('role', 'permissions'));
    }

    
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
            'discription' => $request->description,
        ]);
        $role->permissions()->sync($request->permissions); 

        return redirect()->route('role')->with('status', 'Rôle mis à jour avec succès !');
    }

    
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('role')->with('status', 'Rôle supprimé avec succès !');
    }
}
