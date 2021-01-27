<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;
use App\Articulo;
use App\Grupo;
use App\ArticuloFoto;
use App\ExistenciaArticulo;
use DB;
// use App\Traits\ArticulosTrait;

class DepartamentosController extends Controller
{

    /*
        función usada para obtener los artículos de x grupo, el grupo es envíado como parametros $id_g y es enviado al store
        web_articulos_grupo_sel el cual retorna los artículos. Al obtener los artículos se crea un array con las marcas que
        serán enviadas a la vista.
        @param int id_d, int id_g
        @return view con parametros: marcas, id_g, id_d, nombre_departamento,
    */
    public function index($id_d, $id_g){

        $grupos = Grupo::where('grupo', $id_g)->first();
        $total_marcas = collect();
        $isMarca = false;
        $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo, :PrecioMin, :PrecioMax, :Marca, :Color, :Material, :AreaRequerida, :Text, :Capacidad, :OrdenAscendente"),[
            ':Grupo' => $id_g,
            ':Articulo' => 0,
            ':PrecioMin' => 0 ,
            ':PrecioMax' => 0 ,
            ':Marca' => '',
            ':Color' => '',
            ':Material' => '',
            ':AreaRequerida' => '',
            ':Text' => '',
            ':Capacidad' => '',
            ':OrdenAscendente' => 0
        ]);
        // dd($articulos);

        $total_lista = collect();
        foreach ($articulos as $key => $value) {
            if(!empty($value->marca)){
                $total_lista->push(['marca' => $value->marca]);
            }
        }
        $ttotal_lista = $total_lista->countBy(function ($item) {
            return $item['marca'];
        });

        foreach ($ttotal_lista as $key => $value) {
            $total_marcas->push([
                'marca' => $key,
                'total' => $value
            ]);
        }
        if(count($total_marcas) > 0){
            $isMarca = true;
        }
        // dd($total_marcas);
        // $total_lista = $marcas->countBy(function ($item) {
        //     return $item['marca'];
        // });
        //
        // $total_marcas = collect();
        // foreach ($total_lista as $key => $value) {
        //     $total_marcas->push([
        //         'marca' => $key,
        //         'total' => $value
        //     ]);
        // }
        // if(count($total_marcas) > 0){
        //     $isMarca = true;
        // }
        
        $nom_grupo = DB::table('cat_grupos_articulos')->select('descripcion')->where('grupo', $id_g)->where('departamento', $id_d)->first();

        return view('Departamentos', ['id_d' => $id_d,
                                    'id_g' => $id_g,
                                    'subdepto' => $grupos->descripcion,
                                    'isMarca' => $isMarca,
                                    'total_lista' => $total_marcas,
                                    'descripcion_grupo' => $nom_grupo->descripcion
                                    ]);
    }

    public function articulosDepto($id_departamento, $id_grupo){
        $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :OrdenAscendente"),[
            ':Grupo' => $id_grupo,
            ':OrdenAscendente' => '0'
        ]);
        return response(['articulos' => $articulos]);
    }



}
