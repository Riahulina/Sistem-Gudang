<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([

            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:' . User::class
            ],

            'email' => [
                'nullable',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class
            ],

<<<<<<< HEAD
            // validasi role sesuai enum di database
            'role' => [
                'required',
                'in:admin,ktu'
            ],

=======
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
        ]);

        $user = User::create([

<<<<<<< HEAD
            'name'     => $request->name,

            'username' => $request->username,

            'email'    => $request->email,

            'role'     => $request->role,
=======
            'name' => $request->name,

            'username' => $request->username,

            'email' => $request->email,

            // default role
            'role' => 'admin',
>>>>>>> 88ee3e1ad7e8585d6d15ead5c937f9d749a03d81

            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
