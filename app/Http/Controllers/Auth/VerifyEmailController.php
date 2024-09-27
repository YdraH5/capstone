<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::DEFAULT.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        $user = Auth::user();
        switch($user->role){
            case 'admin':
                // Redirect admins to admin dashboard
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            case 'owner':
                // Redirect admins to admin dashboard
                return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
            case 'renter':
                // Redirect customers to customer dashboard
                return redirect()->intended(RouteServiceProvider::RENTER.'?verified=1');
            case 'reserve':
                // Redirect customers to customer dashboard
                return redirect()->intended(RouteServiceProvider::RESERVE.'?verified=1');
            default:
            return redirect()->intended(RouteServiceProvider::DEFAULT.'?verified=1');
        }
    }
}
