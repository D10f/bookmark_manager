<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class LoginController extends Controller
{
    /**
     * Displays the login page
     */
    public function show()
    {
        return Inertia::render('auth/Login', [
            'auth_register' => route('auth.register'),
            'auth_login' => route('auth.login'),
            'forgot_password' => route('password.index')
        ]);
    }

    /**
     * Displays the register page
     */
    public function create()
    {
        return Inertia::render('auth/Register', [
            'auth_login' => route('login'),
            'auth_store' => route('auth.store')
        ]);
    }

    /**
     * Endpoint to authenticate an existing user
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->intended('/'); // this is the default
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.'
        ]);
    }

    /**
     * Endpoint to register a new user
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => ['min:2', 'max:255', 'nullable'],
            'email' => ['required', 'email', 'unique:users', 'max:255'],
            'password' => ['required', 'min:6', 'max:255', 'confirmed'],
        ]);

        // TODO: create random string for username
        $attributes['name'] = 'Test User';
        $user = User::create($attributes);

        Auth::login($user);

        return redirect(route('home'));
    }

    /**
     * Endpoint to logout an currently logged in user.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    /**
     * Page for user password reset link
     */
    public function passwordResetShow()
    {
        return Inertia::render('auth/PasswordReset', [
            'password_reset_url' => route('password.email'),
            'auth_login' => route('login'),
        ]);
    }

    /**
     * Handles the request for a new password and sends an email to the user.
     */
    public function passwordResetEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Page to form to let user choose a new password.
     */
    public function passwordResetForm(Request $request, string $token)
    {
        return Inertia::render('auth/PasswordResetForm', [
            'password_update_url' => route('password.update'),
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    /**
     * Attempts to update the user's password.
     */
    public function passwordResetUpdate(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required'],
            'password' => ['required', 'min:6', 'max:255', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $new_password) {
                $user->forceFill([
                    'password' => Hash::make($new_password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
