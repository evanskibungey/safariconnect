<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Exception;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     * This is now disabled for security - only one admin allowed
     */
    public function create(): View
    {
        // Check if admin already exists
        if (Admin::adminExists()) {
            abort(403, 'Admin registration is disabled. Only one admin account is allowed.');
        }

        // Only allow registration if no admin exists (initial setup)
        return view('admin.auth.register');
    }

    /**
     * Handle an incoming registration request.
     * This is now disabled for security - only one admin allowed
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Check if admin already exists
        if (Admin::adminExists()) {
            abort(403, 'Admin registration is disabled. Only one admin account is allowed.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Admin::class],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        try {
            $admin = Admin::createSingleAdmin([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(), // Auto-verify the single admin
            ]);

            event(new Registered($admin));

            Auth::guard('admin')->login($admin);

            return redirect(route('admin.dashboard', absolute: false));
        } catch (Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()]);
        }
    }
}