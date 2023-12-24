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
        return Inertia::render('Profile', [
            'user' => Auth::user()->setVisible(['id', 'name', 'email']),
            'delete_confirmation' => fake()->bothify('????####'),
            'home_url' => route('home'),
            'update_url' => route('profile.update'),
            'delete_url' => route('profile.delete'),
            'logout_url' => route('auth.destroy'),
                // ->with(['categories' => function ($query) {
                //     $query->select('id','title','order','parent_id');
                //     $query->orderByDesc('order');
                // }])
                // ->with(['bookmarks' => function ($query) {
                //     $query->select('id', 'name', 'url', 'order', 'category_id');
                //     $query->orderByDesc('order');
                // }])
                // ->get()
        ]);
        // return Inertia::render('Users/Index', [
        //     'users' => User::query()
        //     ->when(Request::input('search'), function ($query, $search) {
        //         $query->where('name', 'like', '%' . $search . '%');
        //     })
        //     ->paginate()
        //     ->withQueryString()
        //     ->through(fn($user) => [
        //         'id' => $user->id,
        //         'name' => $user->name,
        //         'can' => [
        //             'edit' => Auth::user()->can('edit', $user)
        //         ]
        //     ]),
        //     'filters' => Request::only(['search']),
        //     'can' => [
        //         'createUser' => Auth::user()->can('create', User::class)
        //     ]
        // ]);
    }

    public function update()
    {
        $attributes = Request::validate([
            'name' => ['required', 'min:1', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8', 'max:255'],
        ]);

        $user = Auth::user();

        // Update only fields that aren't null
        foreach ($attributes as $key => $value)
            if (isset($value) && $value !== '')
                $user[$key] = $value;

        $user->save();

        return redirect(route('home'));
    }

    /**
     * Deletes the current profile.
     */
    public function delete()
    {
        User::where('id', Auth::user()->id)->delete();
        return redirect(route('home'));
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


    public function loginApi(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials))
        {
            $user = User::where('username', $credentials['username'])->first();
            $token = $user->createToken('sanctumTokenLabel')->plainTextToken;
            return $token;
        }

        return 'Wrong username or password.';
    }
}
