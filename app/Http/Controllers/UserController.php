<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $userr = auth()->user();
        $fullName = $userr->name; // مثال: "Mohamed Amine"
        $firstName = explode(' ', $fullName)[0];
        $users = User::all();
        $roles = Role::all();
        return view('user', compact('users', 'roles', 'firstName'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('UserCreate', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('userIndex')->with('status', 'Utilisateur ajouté avec succès!')
            ->with('status_type', 'success');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('UserEdit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'required|array',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $user->roles()->sync($request->roles);

        return redirect()->route('userIndex')->with('status', 'Utilisateur modifié avec succès!')->with('status_type', 'success');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('userIndex')->with('status', 'Utilisateur supprimé avec succès!')->with('status_type', 'success');
    }
}
