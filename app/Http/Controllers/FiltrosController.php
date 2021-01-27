<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\Departamento;
use App\Grupo;
use App\ArticuloFoto;
use App\ExistenciaArticulo;
use App\Http\Controllers\DepartamentosController;
use DB;

class FiltrosController extends Controller
{
    public function busqueda_barra($datos){
        return response(['datos' => $datos]);
    }

    /*
        Función utilizada para búscar artículos por texto en el campo buscar de la parte superior de la página, se utiliza el store web_articulos_grupo_sel
        @param String $datos_busqueda, este será el texto a buscar dentro de los artículos.
    */
    public function busqueda_vista($datos_busqueda){

        $total_marcas = collect();
        $art_encontrados = collect();
        $isMarca = false;
        $tipo = false; //tipo 0 para subdepartamento, 1 para articulos
        $articulos = collect();

        // if($datos != null){
            // $articulos = DB::table('cat_grupos_articulos')->select('descripcion', 'departamento', 'grupo')->where('departamento', $datos->departamento)->where('mostrar_web', 1)->get();
        // }else{
            $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo, :PrecioMin, :PrecioMax, :Marca, :Color, :Material, :AreaRequerida, :Text, :Capacidad, :OrdenAscendente"),[
                ':Grupo' => 0,
                ':Articulo' => 0,
                ':PrecioMin' => 0 ,
                ':PrecioMax' => 0 ,
                ':Marca' => '',
                ':Color' => '',
                ':Material' => '',
                ':AreaRequerida' => '',
                ':Text' => $datos_busqueda,
                ':Capacidad' => '',
                ':OrdenAscendente' => 0
            ]);
            // dd($articulos);

            $isMarca = false;

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

            $tipo = true;
        // }
        return view('Busqueda.Results')->with(['tipo' => $tipo, 'articulos' => $articulos, 'lista_marcas' => $total_marcas, 'isMarca' => $isMarca, 'text_bus' => $datos_busqueda]);

    }

    public function filtros(Request $request){
        // dd($request->all());
        // dd($request->all());
        $marca = '';
        $color = '';
        $cap = '';
        $clasificacion = '';
        if($request->color){
            $colores = $request->color;
            // dd(sizeof($colores));
            $color = '';
            for ($i=0; $i < sizeof($colores) ; $i++) {
                $color .= $colores[$i] . ',';
            }
        }
        if($request->clasificacion){
            $clas = $request->clasificacion;
            // dd(sizeof($clas));
            $clasificacion = '';
            for ($i=0; $i < sizeof($clas) ; $i++) {
                $clasificacion .= $clas[$i] . ',';
            }
        }
        if($request->marca){
            $marcas = $request->marca;
            // dd(sizeof($marcas));
            $marca = '';
            for ($i=0; $i < sizeof($marcas) ; $i++) {
                $marca .= $marcas[$i] . ',';
            }
        }
        if($request->capacidad){
            $capacidad = $request->capacidad;
            // dd(sizeof($capacidad));
            $cap = '';
            for ($i=0; $i < sizeof($capacidad) ; $i++) {
                $cap .= $capacidad[$i] . ',';
            }
        }
        // dd($clasificacion);

        $articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo, :PrecioMin, :PrecioMax, :Marca, :Color, :Material, :AreaRequerida, :Text, :Capacidad, :OrdenAscendente, :Clasificacion"),[
            ':Grupo' => $request->id_grupo,
            ':Articulo' => 0,
            ':PrecioMin' => $min = intval($request->precio_min) != null ? intval($request->precio_min) : 0 ,
            ':PrecioMax' => $max = intval($request->precio_max) != null ? (intval($request->precio_max) != 0 ? intval($request->precio_max) : intval(1000000000)) : 0 ,
            ':Marca' => $marca,
            ':Color' => $color,
            ':Material' => '',
            ':AreaRequerida' => $request->area_requerida = $request->area_requerida != null ? $request->area_requerida : '',
            ':Text' => $request->text = $request->text != null ? $request->text : '',
            ':Capacidad' => $cap,
            ':OrdenAscendente' => $request->orden,
            ':Clasificacion' => $clasificacion
        ]);
        // dd($marca);
        // dd($articulo);
        return response(['articulos' => $articulo]);

    }



}
