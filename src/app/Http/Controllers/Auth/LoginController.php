<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
            'auth_login' => route('auth.login')
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
            'name' => ['min:2', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'min:6', 'max:255', 'confirmed'],
        ]);

        // TODO: create random string for username
        User::create($attributes);

        $request->session()->regenerate();

        return redirect(route('bookmarks.index'));
    }

    /**
     * Endpoint to logout an currently logged in user.
     */
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
