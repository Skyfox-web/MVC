<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Usuario;
use App\Cliente;
use App\User;
use App\usuarios_mig;
use Auth;
use DB;

class LoginController extends Controller
{

    public function login(){

        $credenciales = $this->validate(request(), [
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($credenciales)){

            // Session::put('email', $credenciales->email);
            return redirect('/');
        }
        return back()->withErrors(['email' => trans('auth.failed')])
                     ->withInput(request(['email']));
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }




    public function registrarUsuarios(){
        // dd("hola");
        $datos = collect();
        /*
        199 299

        */
        $usuarioss = collect();
        $usuarios = usuarios_mig::where('id', '>', 1584)->where('id', '<=', 1600)->get();
        foreach ($usuarios as $key => $value) {
            if($value->email){

                $existe = User::where('email', $value->email)->first();

                if(!$existe){
                    $fecha = date("d-m-Y H:i:s", strtotime($value->fecha_nacimiento));
                    $user = User::insert([
                        'cliente_web' => 'W-'.$value->cliente,
                        'cliente' => $value->cliente,
                        'nombre' => $value->nombre,
                        'paterno' => $value->paterno,
                        'materno' => $value->materno,
                        'nombre_completo' => $value->nombre_completo,
                        'fecha_nacimiento' => $fecha,
                        'ofertas' => 1,
                        'email' => $value->email,
                        'password' => Hash::make($value->password),
                    ]);

                }

            }

            // $datos->push(['cliente_web' => $value->cliente,
            //               'cliente' => $value->cliente,
            //               'nombre' => $value->nombre,
            //               'paterno' => $value->paterno ,
            //               'materno' => $value->materno ,
            //               'nombre_completo' => $value->nombre_completo ,
            //               'fecha_nacimiento' => $value->fecha_nacimiento ,
            //               'email' => $value->email ,
            //               'contrasena' => $value->password
            // ]);
        }

        dd("hecho");

    }

}
