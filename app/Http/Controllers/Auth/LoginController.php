<?php

namespace App\Http\Controllers\Auth;
use Session;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class LoginController extends Controller
{
    public function login(){

        $credenciales = $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credenciales)){

            // Session::put('email', $credenciales->email);
            return redirect()->route('dashboard');
        }
        return back()->withErrors(['email' => trans('auth.failed')])
                     ->withInput(request(['email']));

    }


    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
