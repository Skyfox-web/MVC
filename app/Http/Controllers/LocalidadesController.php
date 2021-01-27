<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use App\Estado;
use App\Municipio;
use App\Colonia;
use App\Direccion;
use App\Articulo;
use Illuminate\Support\Carbon;
use DB;

class LocalidadesController extends Controller
{
    /* ---- DIRECCIÓN ------------------------------------------------------------------------------------------------------- */
    public function getMunicipio(Request $request){
        // dd("municipios");
        $dat_municipio = collect();
        $municipios = DB::select(DB::raw("SET NOCOUNT ON; exec web_municipios_envio_sel :Estado"),[
            ':Estado' => 28
        ]);
        foreach ($municipios as $key => $value) {
            $dat_municipio->push([
                'municipio' => $value->municipio,
                'descripcion' => $value->descripcion
            ]);
        }
        return response(['municipios' => $dat_municipio]);
    }

    public function getCiudad(Request $request){
        // dd($request->all());
        $dat_ciudades = collect();
        $ciudades =  DB::select(DB::raw("SET NOCOUNT ON; exec web_ciudades_sel :Estado, :Municipio, :Ciudad, :ID, :SoloFlete"),[
            ':Estado' => 28,
            ':Municipio' => $request->municipio,
            ':Ciudad' => '0',
            ':ID' => '',
            ':SoloFlete' => ''
        ]);
        // dd($ciudades, $request->municipio);
        foreach ($ciudades as $key => $value) {
            $precio_flete = 0;
            if($value->TieneFlete == 1){
                $precio_flete = Articulo::select('precio_lista')->where('modelo', $value->descripcion)->first();
                if($precio_flete){
                    $precio_flete = $precio_flete->precio_lista;
                }
                $dat_ciudades->push([
                    'ciudad' => $value->ciudad,
                    'descripcion' => $value->descripcion,
                    'precio_flete' => $precio_flete
                ]);
            }
        }

        return response(['ciudades' => $dat_ciudades]);
    }

    public function getColonias(Request $request){
        $dat_colonias = collect();
        $colonias = Colonia::select('colonia', 'descripcion')->where('municipio', $request->municipio)->where('ciudad', $request->ciudad)->where('estado', 28)->get();

        foreach ($colonias as $key => $value) {
            if($value->descripcion != 'SIN COLONIA'){
                $dat_colonias->push([
                    'colonia' => $value->colonia,
                    'descripcion' => $value->descripcion
                ]);
            }
        }

        return response(['colonias' => $dat_colonias]);
    }

    /* ---- FACTURACIÓN ------------------------------------------------------------------------------------------------------- */

    public function getEstado(Request $request){
        $dat_estados = collect();
        $estados = Estado::select('estado', 'descripcion')->get();
        foreach ($estados as $key => $value) {
            $dat_estados->push([
                'estado' => $value->estado,
                'descripcion' => $value->descripcion
            ]);
        }
        return response(['estados' => $dat_estados]);
    }

    public function getMunicipioF(Request $request){
        // dd("municipios");
        $dat_municipio = collect();
        $municipios = Municipio::select('municipio', 'descripcion')->where('estado', $request->estado)->get();
        foreach ($municipios as $key => $value) {
            $dat_municipio->push([
                'municipio' => $value->municipio,
                'descripcion' => $value->descripcion
            ]);
        }
        return response(['municipios' => $dat_municipio]);
    }

    public function getCiudadF(Request $request){
        // dd($request->all());
        $dat_ciudades = collect();
        $ciudades =  DB::select(DB::raw("SET NOCOUNT ON; exec web_ciudades_sel :Estado, :Municipio, :Ciudad, :ID, :SoloFlete"),[
            ':Estado' => $request->estado,
            ':Municipio' => $request->municipio,
            ':Ciudad' => '0',
            ':ID' => '',
            ':SoloFlete' => ''
        ]);
        // dd($ciudades, $request->municipio);
        foreach ($ciudades as $key => $value) {
            $precio_flete = 0;
            if($value->TieneFlete == 1){
                $precio_flete = Articulo::select('precio_lista')->where('modelo', $value->descripcion)->first();
                if($precio_flete){
                    $precio_flete = $precio_flete->precio_lista;
                }
                $dat_ciudades->push([
                    'ciudad' => $value->ciudad,
                    'descripcion' => $value->descripcion,
                    'precio_flete' => $precio_flete
                ]);
            }
        }

        return response(['ciudades' => $dat_ciudades]);
    }

    public function getColoniasF(Request $request){
        $dat_colonias = collect();
        $colonias = Colonia::select('colonia', 'descripcion')->where('municipio', $request->municipio)->where('ciudad', $request->ciudad)->where('estado', $request->estado)->get();

        foreach ($colonias as $key => $value) {
            if($value->descripcion != 'SIN COLONIA'){
                $dat_colonias->push([
                    'colonia' => $value->colonia,
                    'descripcion' => $value->descripcion
                ]);
            }
        }

        return response(['colonias' => $dat_colonias]);
    }




}
