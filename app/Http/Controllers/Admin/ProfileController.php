<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function edit()
    {
        return view('admin.profile.edit', [
            'user' => Auth::user()
        ]);    
    }

    public function update(Request $request)
    {
        $user = Auth::user(); 

        try {
            $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'current_password' => ['required_with:password', 'nullable', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
        ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput();
        }

        // Verify current password if trying to change password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()
                    ->withErrors(['current_password' => 'The provided password does not match your current password.'])
                    ->withInput();
            }
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        try {
            // $user->save();
            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->withErrors(['error' => 'Failed to update profile. Please try again.'])
                ->withInput();
        }
    }
}