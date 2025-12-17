<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Profiel van ingelogde gebruiker
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update profiel van ingelogde gebruiker
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->phone = $request->get('phone');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->get('password'));
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete profiel van ingelogde gebruiker
     */
    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Admin: overzicht van alle gebruikers
     */
    public function adminUsers()
    {
        $users = User::all();
        return view('admin_Users', compact('users'));
    }

    /**
     * Admin: edit formulier voor één gebruiker
     */
    public function adminUsersEdit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin_Users_edit', compact('user'));
    }

    /**
     * Admin: update één gebruiker
     */
   public function adminUsersupdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validatie
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:20',
        ]);

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password){
            $user->password = bcrypt($request->password);
        }

        $user->phone = $request->phone;
        $user->admin = $request->has('admin');
        $user->save();

        return redirect()->route('admin_Users')->with('status', 'user-updated');
    }

    public function adminUsersdestroy(string $id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin_Users')->with('status', 'user-deleted');
    }
}
