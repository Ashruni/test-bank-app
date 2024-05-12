<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Operation;
use Illuminate\Validation\ValidationException;

class AuthenticationController
{
    public function show()
    {
        return view('authentication.register');
    }
    public function create()
    {
        $validatedUser = request()->validate([
            'name' => ['required', 'min:4', 'max:115'],
            'email' => ['required', 'min:5', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'max:100'],
        ]);
        $validatedUser['password'] = bcrypt($validatedUser['password']);
        $user = User::create($validatedUser);
        auth()->login($user);
        if ($validatedUser) {
            return redirect('/')->with('success', 'Registered successfully,Welcome To your new account');
        } else {
            return redirect('/register')->with('error', 'Something went wrong');
        }
    }
    public function login()
    {
        return view('authentication.login');
    }

    public function destroy()
    {
        auth()->logout();
        return redirect('/login');
    }
    public function check()
    {
        $credentials = request()->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|max:50',
        ]);

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'your provided credentials could not be verified'
            ]);
        }

        session()->regenerate();
        return redirect('/')->with('success', 'Welcome Back');
    }
}
