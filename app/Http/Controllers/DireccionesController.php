<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;
use App\Municipio;
use App\Colonia;
use App\Direccion;
use Illuminate\Support\Carbon;
use DB;

class DireccionesController extends Controller
{

    public function guardaDireccion(Request $datos){

        DB::beginTransaction();
        $id_usuario = 0;
        if(auth()->user()){

            try{
                $id_usuario = auth()->user()->id;
                $fecha = date(Carbon::now());
                // dd($existe_direccion);

                $existe_direccion = Direccion::where('id_usuario', $id_usuario)->where('nombre_direccion', $datos->nombre_dir)->first();
                // dd($existe_direccion);

                $es_principal = $datos->nombre_dir == 'Principal';
                $datos_direccion = [
                    'id_usuario' => $id_usuario,
                    'es_principal' =>  $es_principal,
                    'calle' => $datos->calle_dir,
                    'num_ext' => $datos->num_ext_dir,
                    'num_int' => $datos->num_int_dir,
                    'cp' => $datos->cp_dir,
                    'entre_calle' => $datos->entre_calle1_dir,
                    'y_calle' => $datos->entre_calle2_dir,
                    'estado' => 28,
                    'ciudad' => $datos->ciudad_dir,
                    'municipio' => $datos->municipio_dir,
                    'colonia' => $datos->colonia_dir,
                    'referencias' => $datos->referencias_dir,
                    'nombre_direccion' => $datos->nombre_dir ? $datos->nombre_dir : 'Principal',
                    'nombre_contacto' => $datos->nombre_dir_val,
                    'paterno' => $datos->paterno_dir_val,
                    'materno' => $datos->materno_dir_val,
                    'telefono' => $datos->telefono_dir_val
                ];

                if(!$existe_direccion){

                    $datos_direccion['created_at'] = $fecha;
                }else{
                    $datos_direccion['updated_at'] = $fecha;
                }
                // dd($datos_direccion);


                $isCreate = ($existe_direccion && $existe_direccion->nombre_direccion != 'Principal') ? true : (!$existe_direccion ? true : false);

                // dd($isCreate);

                if($isCreate){
                    $direccion = Direccion::insert($datos_direccion);
                }else{
                    $direccion = Direccion::where('id', $existe_direccion->id)->update($datos_direccion);
                }


                DB::commit();
                return response(['success' => true,'isCreate' => $isCreate]);
            }catch(\Exception $e){
                DB::rollback();
                return response(['success' => false]);
            }
        }
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

        return response(['lista_direcciones' => $lista_direcciones]);
    }

    public function getMunicipios(){
        // $dat_municipio = collect();
        dd("hola");
        // $municipios = Municipio::where('estado', 28)->get();
        // foreach ($municipios as $key => $value) {
        //     $dat_municipio->push([
        //         'municipio' => $value->municipio,
        //         'descripcion' => $value->descripcion
        //     ]);
        // }
        // return response(['municipios' => $dat_municipio]);


    }

    public function getMunicipio(){
        $dat_municipio = collect();
        dd("municipios");
        $municipios = Municipio::where('estado', 28)->get();
        foreach ($municipios as $key => $value) {
            $dat_municipio->push([
                'municipio' => $value->municipio,
                'descripcion' => $value->descripcion
            ]);
        }
        return response(['municipios' => $dat_municipio]);

    }

    public function getCiudad($municipio){
        $dat_ciudades = collect();
        $ciudades =  DB::select(DB::raw("SET NOCOUNT ON; exec web_ciudades_sel :Estado, :Municipio, :Ciudad, :ID, :SoloFlete"),[
            ':Estado' => '28',
            ':Municipio' => $municipio,
            ':Ciudad' => '0',
            ':ID' => '',
            ':SoloFlete' => ''
        ]);

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
        $colonias = Colonia::where('estado', 28)->where('municipio', $municipio)->where('ciudad', $ciudad)->get();

        foreach ($colonias as $key => $value) {
            $dat_colonias->push([
                'colonia' => $value->colonia,
                'descripcion' => $value->descripcion
            ]);
        }

        return response(['colonias' => $dat_colonias]);
    }
}
