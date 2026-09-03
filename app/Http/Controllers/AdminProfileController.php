<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $admin = DB::table('admins')
            ->where('id', $adminId)
            ->first();

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
        ]);

        $data = [
            'name' => trim($validated['name']),
            'email' => strtolower(trim($validated['email'])),
            'updated_at' => now(),
        ];

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

        DB::table('admins')
            ->where('id', $admin->id)
            ->update($data);

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