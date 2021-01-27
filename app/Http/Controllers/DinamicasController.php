<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;
use App\Dinamica_Enero_2021;

class DinamicasController extends Controller
{

    public function registra_participante(Request $request){
        // dd($request->all());
        $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));

        $isRegistro = Dinamica_Enero_2021::where('serie', strVal($request->serie))->where('folio', intVal($request->folio))->first();
        // dd($isRegistro);
        if($isRegistro == null){

            $registra = Dinamica_Enero_2021::insertGetId(['serie' => strVal($request->serie),
            'folio' => intVal($request->folio),
            'nombre' => strVal($request->nombre),
            'correo' => strVal($request->correo),
            'telefono' => strVal($request->telefono),
            'created_at' => $fecha]);

            if($registra || $registra != []){
                return response(['registrado' => true, 'existe' => false]);
            }else{
                return response(['registrado' => false, 'existe' => false]);
            }
        }else{
            return response(['registrado' => false, 'existe' => true]);
        }

    }

}
