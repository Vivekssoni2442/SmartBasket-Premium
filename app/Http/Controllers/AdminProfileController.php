<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Admin;

class AdminProfileController extends Controller
{
    /**
     * Get currently logged-in administrator.
     */
    private function getAdmin()
    {
        $adminId = session('admin_id');

        if (!$adminId) {
            abort(403, 'Administrator session not found.');
        }

        $admin = Admin::find($adminId);

        if (!$admin) {
            abort(403, 'Administrator account not found.');
        }

        return $admin;
    }

    /**
     * Profile page.
     */
    public function show()
    {
        $admin = $this->getAdmin();

        $name = trim(
            (string) (
                $admin->name
                ?? session('admin_name')
                ?? 'Administrator'
            )
        );

        $email = trim(
            (string) (
                $admin->email
                ?? session('admin_email')
                ?? 'admin@smartbasket.local'
            )
        );

        $words = preg_split(
            '/\s+/',
            $name,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $initials = '';

        foreach (array_slice($words ?: [], 0, 2) as $word) {
            $initials .= Str::upper(
                Str::substr($word, 0, 1)
            );
        }

        if ($initials === '') {
            $initials = 'A';
        }

        return view('admin.profile', [
            'admin' => $admin,
            'name' => $name,
            'email' => $email,
            'initials' => $initials,
        ]);
    }

    /**
     * Update administrator profile.
     */
    public function update(Request $request)
    {
        $admin = $this->getAdmin();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:190',
                'unique:admins,email,' . $admin->id . ',id',
            ],

            'current_password' => [
                'nullable',
                'string',
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'timezone' => ['nullable', 'timezone'],
            'language' => ['nullable', 'string', 'max:20'],
            'dark_mode' => ['nullable', 'boolean'],
            'notification_preferences' => ['nullable', 'array'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ]);

        $data = [
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'updated_at' => now(),
            'phone' => $validated['phone'] ?? $admin->phone,
            'bio' => $validated['bio'] ?? $admin->bio,
            'timezone' => $validated['timezone'] ?? $admin->timezone,
            'language' => $validated['language'] ?? $admin->language,
            'notification_preferences' => $validated['notification_preferences'] ?? $admin->notification_preferences,
        ];

        if ($request->has('dark_mode')) {
            $data['dark_mode'] = $request->boolean('dark_mode');
        }

        /*
         * Password change
         */
        if (!empty($validated['password'])) {

            if (empty($validated['current_password'])) {
                return back()
                    ->withErrors([
                        'current_password' =>
                            'Current password is required to change your password.',
                    ])
                    ->withInput();
            }

            $storedPassword = $admin->password ?? null;

            if (
                !$storedPassword ||
                !Hash::check(
                    $validated['current_password'],
                    $storedPassword
                )
            ) {
                return back()
                    ->withErrors([
                        'current_password' =>
                            'Current password is incorrect.',
                    ])
                    ->withInput();
            }

            $data['password'] = Hash::make(
                $validated['password']
            );
        }

        if ($request->hasFile('avatar')) {
            if ($admin->avatar) Storage::disk('public')->delete('admin-avatars/' . $admin->avatar);
            $data['avatar'] = $request->file('avatar')->store('admin-avatars', 'public');
            $data['avatar'] = basename($data['avatar']);
        }

        $admin->update($data);

        /*
         * Keep current session information synchronized.
         */
        session()->put(
            'admin_name',
            $data['name']
        );

        session()->put(
            'admin_email',
            $data['email']
        );

        return redirect()
            ->route('admin.profile')
            ->with(
                'success',
                'Administrator profile updated successfully.'
            );
    }
}
