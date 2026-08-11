<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerSettingsController extends Controller
{
    public function edit()
    {
        abort_unless(Auth::check(), 403);
        return view('settings.customer', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        abort_unless(Auth::check(), 403);
        $data = $request->validate([
            'dark_mode' => ['required', 'in:light,dark,system'],
            'notifications' => ['required', 'in:enabled,disabled'],
            'language' => ['nullable', 'string', 'max:50'],
        ]);
        Auth::user()->update($data);
        return back()->with('success', 'Settings saved successfully.');
    }
}
