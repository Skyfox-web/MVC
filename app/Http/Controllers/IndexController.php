<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;

use App\ArticuloCarrito;
use App\Carrito;

use App\Grupo;
use DB;
use App\Usuario;
use App\Cliente;
use Auth;


class IndexController extends Controller
{

    public function listarMenu(){
        return view('Index');
    }

    // public function listarMenuU($id_usuario){
    //     $data = Usuario::where('usuario', $id_usuario)->first();
    //     dd($data->cliente());
    //     if($data){
    //         $cliente = Cliente::where('cliente', $data->cliente)->first();
    //         return response(['nombre' => $cliente->nombres]);
    //     }
    //
    //     return view('Index');
    // }

    public function enviaindex($nombre){
        return view('Index', ['nombre' => $nombre]);
    }

}
