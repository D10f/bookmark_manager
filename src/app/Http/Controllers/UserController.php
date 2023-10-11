<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => User::query()
            ->when(Request::input('search'), function ($query, $search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->paginate()
            ->withQueryString()
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'can' => [
                    'edit' => Auth::user()->can('edit', $user)
                ]
            ]),
            'filters' => Request::only(['search']),
            'can' => [
                'createUser' => Auth::user()->can('create', User::class)
            ]
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Users/Edit', [
            'user' => $user
        ]);
    }

    public function update(User $user)
    {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => 'confirmed',
        ]);

        $user->update($attributes);

        return redirect('/users');
    }

    public function store()
    {
        $attributes = Request::validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);

        User::create($attributes);

        return redirect('/users');
    }

    public function create()
    {
        return Inertia::render('Users/Create');
    }
}
