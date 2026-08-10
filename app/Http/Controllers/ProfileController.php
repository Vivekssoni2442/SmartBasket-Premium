<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
public function index()
{
    $user = Auth::user();

    if (! $user) {
        return redirect('/login');
    }

    return view('profile', compact('user'));
}

    public function update(Request $request)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect('/login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'house_no' => 'nullable|string|max:255',
            'street' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'landmark' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'pin_code' => 'nullable|string|max:20',
            'language' => 'nullable|string|max:50',
            'dark_mode' => 'nullable|string|max:10',
            'notifications' => 'nullable|string|max:10',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->address = $request->address;
        $user->house_no = $request->house_no;
        $user->street = $request->street;
        $user->area = $request->area;
        $user->landmark = $request->landmark;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->pin_code = $request->pin_code;
        $user->language = $request->language ?: 'English';
        $user->dark_mode = $request->dark_mode ?: 'light';
        $user->notifications = $request->notifications ?: 'enabled';

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();
            // Store in storage/app/public/profile/ (served via public/storage symlink)
            // NEVER use public_path('profile') — it creates a public/profile/ directory
            // that conflicts with the /profile route on PHP's built-in server.
            $path = $image->storeAs('profile', $name, 'public');
            $user->profile_image = $name;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function logout(Request $request)
    {
        // Logout user (invalidates remember token + clears auth)
        Auth::logout();

        // Invalidate the entire session (clears all session data including seller)
        session()->invalidate();

        // Regenerate CSRF token to prevent reuse
        session()->regenerateToken();

        // Forget the remember_me cookie explicitly
        $cookie = \Illuminate\Support\Facades\Cookie::forget('remember_web_' . sha1('Illuminate\Auth\AuthGuard'));
        $request->session()->flush();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}