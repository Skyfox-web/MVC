<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;
use App\ArticuloFoto;
use App\Bodega;
use App\ExistenciaArticulo;
use DB;

class ArticulosController extends Controller
{
    /*
    Devuelve los datos de x artículo.
    Se envía el id del artículo y grupo,  posteriormente se ejecuta el store web_articulos_grupo_sel para obtener
    totos los datos del artículo donde se pasa el grupo y artículo a buscar. Se obtiene la bodega y existencias

    @param Request $request
    @return response articulo, bodega
    */
    public function index(Request $request){


        $articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
            ':Grupo' => intVal($request->grupo),
            ':Articulo' => intVal($request->articulo)
        ]);


        $bodegas = Bodega::orderBy('prioridad_cotizaciones')->get();

        foreach($bodegas as $key => $bodega) {
            $existencias = ExistenciaArticulo::where('articulo', $articulo[0]->articulo)->where('bodega', $bodega->bodega)->where('fisica', '<>', 0)->first();
            if($existencias){
                break;
            }
        }

        $nom_grupo = DB::table('cat_grupos_articulos')->select('descripcion')->where('grupo', $articulo[0]->grupo)->where('departamento', $articulo[0]->departamento)->first();
        // dd($nom_grupo->descripcion);

        $bodega = $existencias ? $existencias->bodega : 0;

        return response(['articulo' => $articulo, 'bodega' => $bodega]);
    }

    /*
    Devuelve los datos de x artículo.
    Se envía el id del artículo y grupo,  posteriormente se ejecuta el store web_articulos_grupo_sel para obtener
    totos los datos del artículo donde se pasa el grupo y artículo a buscar. Para posteriormente se retorna la vista Detalles (Detalles del Artículo)
    con las variables.

    @param int @articulo, @grupo
    @return View con variables articulo, grupo, bodega, enganche, abonos, precio_credito
    */
    public function detalleArticulo($articulo_v, $grupo){
        // dd($articulo_v);
        $isExist = false;

        $articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
            ':Grupo' => intVal($grupo),
            ':Articulo' => intVal($articulo_v)
        ]);
        if($articulo != []){
            $bodegas = Bodega::orderBy('prioridad_cotizaciones')->get();

            foreach($bodegas as $key => $bodega) {
                $existencias = ExistenciaArticulo::where('articulo', $articulo[0]->articulo)->where('bodega', $bodega->bodega)->where('fisica', '<>', 0)->first();
                if($existencias){
                    break;
                }
            }

            $nom_grupo = DB::table('cat_grupos_articulos')->select('descripcion')->where('grupo', $articulo[0]->grupo)->where('departamento', $articulo[0]->departamento)->first();
            $bodega = $existencias ? $existencias->bodega : 0;
            $precio_credito_form = number_format($articulo[0]->precio_credito, 2, '.', ',');
            $enganche = number_format($articulo[0]->importe_enganche, 2, '.', ',');
            $abonos = number_format($articulo[0]->importe_documentos, 2, '.', ',');

            $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo"),[
                ':Grupo' => $grupo
            ]);
            // dd($articulos);
            return view('Articulos.Detalles', ['isExist' => true,
            'articulo' => $articulo,
            'grupo' => $nom_grupo->descripcion,
            'bodega' => $bodega,
            'enganche' => $enganche,
            'abonos' => $abonos,
            'precio_credito' => $precio_credito_form,
            'articuloss' => $articulos]);

        }else{

            /*
                En caso de que el articulo no tenga exstencias devolverá información limitada del articulo como es el nombre, departamento, grupo, etc.
                En la vista mostrará algunos articulos similares

            */

            $articulo = Articulo::where('articulo', intVal($articulo_v))->select('descripcion_corta', 'departamento', 'grupo')->first();

            if($articulo != null){
                $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo"),[
                    ':Grupo' => $grupo
                ]);


                if($articulos != []){
                    return view('Articulos.Detalles', ['isExist' => false, 'isArt' => true, 'descripcion_art' => $articulo->descripcion_corta, 'departamento' => $articulo->departamento, 'grupo' => $articulo->grupo,'articulos' => $articulos]);

                }else{
                    // dd($articulos);
                    return view('Articulos.Detalles', ['isExist' => false, 'isArt' => false, 'descripcion_art' => $articulo->descripcion_corta, 'departamento' => $articulo->departamento, 'grupo' => $articulo->grupo]);
                }
            }else{
                return view('Articulos.Detalles', ['isExist' => false, 'isArt' => false, 'descripcion_art' => 'Artículo no encontrado', 'departamento' => '2', 'grupo' => '55']);
            }
            // dd($articulo);


        }
    }


}
