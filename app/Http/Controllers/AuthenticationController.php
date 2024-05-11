<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController
{
    public function show(){
        return view('authentication.register');
    }
    public function create(){
        $validatedUser = request()->validate([
            'name'=>['required','min:4','max:115'],
            'email'=>['required','min:5','email','max:255','unique:users,email'],
            'password'=>['required','min:8','max:100'],
        ]);
        $validatedUser['password'] = bcrypt($validatedUser['password']);
        $user= User::create($validatedUser);
        auth()->login($user);
        if($validatedUser){
            return redirect('/');
        }
        else{
            return redirect('/register')->with('error','Something went wrong');
        }
    }
    public function login(){
        return view('authentication.login');
    }

    public function destroy(){
        auth()->logout();
        return redirect('/login');
    }
}
