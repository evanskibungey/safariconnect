<?php

// File: app/Http/Controllers/Admin/Auth/VerifyEmailController.php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmailVerificationRequest;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user('admin')->hasVerifiedEmail()) {
            return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
        }

        if ($request->user('admin')->markEmailAsVerified()) {
            event(new Verified($request->user('admin')));
        }

        return redirect()->intended(route('admin.dashboard', absolute: false).'?verified=1');
    }
}