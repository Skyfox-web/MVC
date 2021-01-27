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

class DireccionController extends Controller
{
    /*


    */
    public function getDireccionEsp($municipio){

        $direccion = Direccion::where('id', $municipio)->orderBy('created_at', 'asc')->first();
        $municipio = Municipio::select('descripcion')->where('municipio', $direccion->municipio)->where('estado', 28)->first();
        $ciudad = Ciudad::select('descripcion')->where('estado', 28)->where('municipio', $direccion->municipio)->where('ciudad', $direccion->ciudad)->first();
        // dd($direccion, $municipio, $ciudad);
        $precio_flete = 0;
        $precio_flete = Articulo::select('precio_lista')->where('modelo', $ciudad->descripcion)->first();

        $precio_flete = $precio_flete != null ? $precio_flete->precio_lista : 'false';

        // dd($request->estado == '28' && $request->ciudad == '18' && $request->municipio == '41', $ciudad->descripcion);
        if($ciudad->descripcion === 'CD. VICTORIA'){
            $precio_flete = 0.00;
        }else if($ciudad->descripcion === 'H. MATAMOROS'){
            $precio_flete = 0.00;
        }

        $colonia = Colonia::select('descripcion')->where('estado', 28)->where('municipio', $direccion->municipio)->where('ciudad', $direccion->ciudad)->where('colonia', $direccion->colonia)->first();
        // dd($colonia);
        $direccion = [
            'id' => $direccion->id,
            'es_principal' => $direccion->es_principal,
            'nombre_direccion' => $direccion->nombre_direccion,
            'calle' => $direccion->calle,
            'num_ext' => $direccion->num_ext ,
            'num_int' => $direccion->num_int ,
            'cp' => $direccion->cp ,
            'entre_calle' => $direccion->entre_calle ,
            'y_calle' => $direccion->y_calle ,
            'municipio' => $direccion->municipio,
            'ciudad' => $direccion->ciudad,
            'precio_flete' => $precio_flete,
            'colonia' => $direccion->colonia,
            'municipio_des' => $municipio->descripcion,
            'ciudad_des' => $ciudad->descripcion,
            'colonia_des' => $colonia->descripcion,
            'referencias' => $direccion->referencias,
            'nombre_contacto' => $direccion->nombre_contacto,
            'paterno' => $direccion->paterno,
            'materno' => $direccion->materno,
            'telefono' => $direccion->telefono
        ];

        return response($direccion);

    }

    /*
        Obtiene el precio del flete de la ciudad seleccionada en la vista Cliente.
        @Param Request $request: ciudad, estado, municipio
    */
    public function getFleteCiudad(Request $request){

        $ciudad = Ciudad::select('descripcion')->where('ciudad', $request->ciudad)->where('municipio', $request->municipio)->where('estado', $request->estado)->first();
        $precio_flete = Articulo::select('precio_lista')->where('modelo', 'like', $ciudad->descripcion)->first();
        $precio_flete = $precio_flete != null ? $precio_flete->precio_lista : 'false';
        if(($request->estado == '28' && $request->ciudad == '18' && $request->municipio == '41') || ($request->estado == '28' && $request->ciudad == '1' && $request->municipio == '22')){
            $precio_flete = 0;
        }
        // Si la ciudad es Cd. Victoria o Matamoros, el precio de envío es de 0 pesos.
        if($ciudad->descripcion === 'CD. VICTORIA'){
            return response(0.00);
        }else if($ciudad->descripcion === 'H. MATAMOROS'){
            return response(0.00);
        }else{
            return response($precio_flete);
        }
    }

    /*
        Obtiene los datos del cliente propocionados en la vista Cliente y guarda la dirección del cliente
    */
    public function guardaDireccion(Request $datos){
        // dd($datos->all());
        // echo 'entra guarda direccion';
        $colonia_dir = 0;
        $colonia =  Colonia::where('municipio', $datos->municipio_dir)->where('ciudad', $datos->ciudad_dir)->where('descripcion', $datos->colonia_dir)->first();
        if($colonia){
            $colonia_dir = $colonia->colonia;

        }
        DB::beginTransaction();
        $id_usuario = 0;
        if(auth()->user()){

            try{
                $id_usuario = auth()->user()->id;
                // $fecha = Carbon::now();
                $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                // $fecha = $fecha->format('Y-m-d h:m:s');
                // dd($fecha);

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
                    'colonia' => $colonia_dir,
                    'referencias' => $datos->referencias_dir,
                    'nombre_direccion' => $datos->nombre_dir ? $datos->nombre_dir : 'Principal',
                    'nombre_contacto' => $datos->nombre_dir_val,
                    'paterno' => $datos->paterno_dir_val,
                    'materno' => $datos->materno_dir_val,
                    'telefono' => $datos->telefono_dir_val
                ];
                // dd($datos_direccion);
                // dd($datos_direccion, $datos);
                if(!$existe_direccion){
                     $datos_direccion['created_at'] = $fecha;
                }else{
                     $datos_direccion['updated_at'] = $fecha;
                }
                // dd($datos_direccion);


                $isCreate = ($existe_direccion && $existe_direccion->nombre_direccion != 'Principal') ? true : (!$existe_direccion ? true : false);

                // dd($existe_direccion->id);

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
    /*
        Obtiene la lista de direcciones del usuario logeado.
    */
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

    public function getMunicipio(Request $request){
        // dd("municipios");
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

    public function getCiudad(Request $request){
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

    public function getColonias(Request $request){
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


    public function eliminaDireccion(Request $datos){

        if(auth()->user()){
            $direccion = Direccion::where('id_usuario', auth()->user()->id)->where('id', $datos->id_direccion)->delete();
            if($direccion){
                return response(['estado' => true]);
            }else{
                return response(['estado' => false]);
            }
        }

    }

}
