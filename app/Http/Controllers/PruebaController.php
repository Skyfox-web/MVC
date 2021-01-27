<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Municipio;
use App\Direccion;
use App\Ciudad;
use App\Colonia;
use DB;

class PruebaController extends Controller
{
    public function getMunicipio(){
        $dat_municipio = collect();
        $municipios = Municipio::select('municipio', 'descripcion')->where('estado', 28)->get();
        foreach ($municipios as $key => $value) {
            $dat_municipio->push([
                'municipio' => $value->municipio,
                'descripcion' => $value->descripcion
            ]);
        }

        return response(['municipios' => $dat_municipio]);

    }


    public function getlistaDirecciones(Request $datos){

        $direcciones = Direccion::where('id_usuario', auth()->user()->id)->get();
        $lista_direcciones = collect();
        foreach ($direcciones as $key => $value) {
            $lista_direcciones->push([
                'id_direccion' => $value->id,
                'nombre_direccion' => $value->nombre_direccion
            ]);
        }
        // dd($direcciones);
        //
        return response(['lista_direcciones' => $lista_direcciones]);
    }

    public function getCiudadLista($municipio){
        $dat_ciudades = collect();
        // dd($municipio);
        $ciudades =  DB::select(DB::raw("SET NOCOUNT ON; exec web_ciudades_sel :Estado, :Municipio, :Ciudad, :ID, :SoloFlete"),[
            ':Estado' => '28',
            ':Municipio' => $municipio,
            ':Ciudad' => '0',
            ':ID' => '',
            ':SoloFlete' => ''
        ]);
        //
        foreach ($ciudades as $key => $value) {
            if($value->TieneFlete == 1){
                $dat_ciudades->push([
                    'ciudad' => $value->ciudad,
                    'descripcion' => $value->descripcion
                ]);
            }
        }

        return response(['ciudades' => $dat_ciudades]);

    }



    public function getColonias($municipio, $ciudad){
        $dat_colonias = collect();
        $colonias = Colonia::select('colonia', 'descripcion')->where('estado', 28)->where('municipio', $municipio)->where('ciudad', $ciudad)->get();
        // dd($colonias);
        foreach ($colonias as $key => $value) {
            $dat_colonias->push([
                'colonia' => $value->colonia,
                'descripcion' => $value->descripcion
            ]);
        }

        return response(['colonias' => $dat_colonias]);
    }


}
