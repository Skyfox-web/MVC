<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;

class RegistroController extends Controller
{


    public function registrar(array $data){
        $datos = User::insert([
            'cliente' => 1,
            'nombre' => $data['nombre'],
            'paterno' => $data['paterno'],
            'materno' => $data['materno'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return redirect()->route('/');

    }


}
