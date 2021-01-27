<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrito;
use App\ArticuloCarrito;
use App\Articulo;
use Illuminate\Support\Carbon;
use Auth;
use DB;
use App\Direccion;
use App\Bodega;
use App\ExistenciaArticulo;

class CarritoController extends Controller
{
    public function index(){
        $lista_carrito = collect();
        $subtotal_venta = 0;
        $iva_venta = 0;
        $total_final = 0;
        $isAuth = 0;
        // dd(auth()->user());
        if(auth()->user()){
            $carrito = Carrito::select('id')->where('id_usuario', auth()->user()->id)->where('estado', 'F')->first();
            // dd($carrito, auth()->user()->id);
            if($carrito != null){
                $articulos = ArticuloCarrito::where('id_carrito', $carrito->id)->get();
                foreach ($articulos as $key => $value) {

                    $existencias = DB::table('cat_articulos_existencias')
                                            ->join('cat_articulos', 'cat_articulos_existencias.articulo', '=', 'cat_articulos.articulo')
                                            ->where('cat_articulos_existencias.articulo', $value->id_articulo)
                                            ->where('cat_articulos_existencias.fisica', '<>', 0)
                                            ->selectRaw('sum(cat_articulos_existencias.fisica) as suma')
                                            ->selectRaw('cat_articulos.descripcion_corta as nombre_articulo')
                                            ->selectRaw('cat_articulos.departamento as departamento')
                                            ->groupBy('cat_articulos.descripcion_corta', 'cat_articulos.departamento')
                                            ->get();
                    // dd($existencias->isEmpty());
                    $mostrar = false;
                    if(!$existencias->isEmpty()){
                        if($existencias[0]->suma > 0){
                            $mostrar = 1;
                        }else{
                            $mostrar = 0;
                        }
                        $art = Articulo::select('descripcion_corta')->where('articulo', $value->id_articulo)->first();

                        $subtotal_venta += $value['subtotal_venta'];
                        $iva_venta += $value['iva_venta'];
                        $total_final += $value['precio_venta'];

                        $lista_carrito->push([
                            'id' => $value['id'],
                            'id_articulo' => $value['id_articulo'],
                            'nombre_articulo' => $existencias[0]->nombre_articulo,
                            'precio_unitario' => number_format($value['precio_unitario'], 2, '.', ','),
                            'cant' => $value['cant'],
                            'subtotal' => number_format($value['subtotal_venta'], 2, '.', ','),
                            'iva_venta' => number_format($value['iva_venta'], 2, '.', ','),
                            'precio_venta' => number_format($value['precio_venta'], 2, '.', ','),
                            'bodega' => $value['bodega'],
                            'mostrar' => $mostrar,
                            'total_existencias' => $existencias[0]->suma,
                            'img' => 'articulos_img/'.$existencias[0]->departamento . '/'.$value['id_articulo']. '.jpg'
                        ]);
                    }
                    // dd($lista_carrito);
                }
                $isAuth = true;
            }else{

            }

        }else{
            $isAuth = false;
        }
        // dd($subtotal_venta, $iva_venta, $total_final);


        return view('Carrito.Checkout', ['isAuth' => $isAuth, 'lista_carrito' => $lista_carrito, 'subtot' => number_format($subtotal_venta, 2, '.', ','), 'iva_tot' => number_format($iva_venta, 2, '.', ','), 'total_final' => number_format($total_final, 2, '.', ',')]);
    }

    public function getTotalVenta(Request $request){
        $total = Carrito::select('total_venta')->where('id', $request->id_carrito)->get();
        // dd($total);
    }

    public function getTotalArticulos(Request $request){
        // dd($request->all());
        $total = 0;
        $subtotal_venta = 0;
        $iva_venta = 0;
        $precio = 0;
        $img = '';
        $art = '';
        if($request->articulo != null){
            $grupo = Articulo::select('grupo', 'departamento')->where('articulo', $request->articulo)->first();
            // dd('hola');
            $articulo_precio = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                ':Grupo' => $grupo->grupo,
                ':Articulo' => $request->articulo
            ]);
            // dd($articulo_precio == []);
            if($articulo_precio != []){
                // dd('entra');
                $precio = $articulo_precio[0]->precio_contado;
                $total += $precio * $request->cant;
                $subtotal_venta = $total / 1.16;
                $iva_venta = $total - $subtotal_venta;

                $img = 'articulos_img/'.$grupo->departamento.'/'.$request->articulo . '.jpg';
                return response(['isExistencia' => true,
                'precio_unitario' => $precio, 
                'total' => $total, 
                'subtot' => $subtotal_venta, 
                'iva_venta' => $iva_venta, 
                'articulo' => $request->articulo, 
                'cantidad' => $request->cant, 
                'nombre_articulo' => $articulo_precio[0]->descripcion_corta, 
                'departamento' => $articulo_precio[0]->departamento,
                'grupo' => $articulo_precio[0]->grupo, 
                'img' => $img]);
            }else{
                return response(['isExistencia' => false]);
            }
        }


    }

    public function getTotalLocal(Request $request){
        $total = 0;
        $precio = 0;
        $subtotal_venta = 0;
        $iva_venta = 0;
        $img = '';

        if($request->articulo != null && $request->cant != null){
            $existencias = ExistenciaArticulo::where('articulo', $request->articulo)->where('fisica', '<>', 0)->get();

            if($existencias->sum('fisica') >= $request->cant){
                $art = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $request->articulo)->first();
                // $articulo_precio = DB::table('cat_articulos')
                //                         ->where('articulo', $request['articulo'])
                //                         ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                //                         ->get();

                // $grupo = Articulo::select('grupo', 'departamento')->where('articulo', $request->articulo)->first();
                $articulo_precio = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                    ':Grupo' => $art->grupo,
                    ':Articulo' => $request->articulo
                ]);

                $precio = $articulo_precio[0]->precio_contado;
                $total += $precio * $request->cant; // total del articulo por la cantidad
                $subtotal_venta = $total / 1.16; //subtotal del articulo
                $iva_venta = $total - $subtotal_venta; //iva del articulo
                // dd($iva_venta);
                $img = 'articulos_img/'.$art->departamento.'/'.$request->articulo . '.jpg';
                $total_compra = 0; //total de la compra
                $subtotal_compra = 0;
                $iva_compra = 0;
                $tot_indiv = 0;
                $total_compra += $total;


                $cantidad = 0;

                foreach ($request->carrito as $key => $value) {
                    if($value['id'] != $request->articulo){
                        $grupo = Articulo::select('grupo', 'departamento')->where('articulo', $value['id'])->first();
                        $precio_art_in  = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                            ':Grupo' => $grupo->grupo,
                            ':Articulo' => $value['id']
                        ]);
                        // $precio_art_in = DB::table('cat_articulos')
                        //                 ->where('articulo', $value['id'])
                        //                 ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                        //                 ->get();

                        $tot_indiv = $precio_art_in[0]->precio_contado * $value['cantidad'];
                        $subtotal_compra = $tot_indiv / 1.16;
                        $iva_compra = $tot_indiv - $subtotal_compra;

                        $total_compra += $tot_indiv;
                        $subtotal_venta += $subtotal_compra;
                        $iva_venta += $iva_compra;

                        $cantidad += $value['cantidad'];
                    }

                }


                $cantidad += $request->cant;

                return response(['estado' => true,
                                'mensaje' => 'null',
                                'precio_unitario' => $precio,
                                'total_compra' => $total_compra,
                                'total' => $total,
                                'subtot' => $subtotal_venta,
                                'iva_venta' => $iva_venta,
                                'articulo' => $request->articulo,
                                'cantidad' => $cantidad,
                                'nombre_articulo' => $art->descripcion_corta,
                                'grupo' => $art->departamento,
                                'img' => $img]);

            }else{
                return response(['estado' => true, 'mensaje' => 'Actualmente solo se encuentran '. $existencias->sum('fisica') . ' unidades en existencia de este producto.']);
            }
        }else{
            return response(['estado' => false, 'mensaje' => false]);
        }
    }

    public function delArticulo(Request $request){
        // dd($request->all());
        if($request->id_articulo){
            $articulo = ArticuloCarrito::where('id_articulo', $request->id_articulo)->where('id_carrito', $request->id_carrito)->delete();

            $suma_art = ArticuloCarrito::select('precio_venta')->where('id_carrito', $request->id_carrito)->sum('precio_venta');

            $upCart = Carrito::where('id', $request->id_carrito)->update(['total_venta' => $suma_art]);


            return true;

        }else{
            return false;

        }
    }


    /*
    * Al entrar a la página siempre verificará desde el front si el usuario está logueado, en caso de no estarlo usará la funcion para generar carrito_loc
    en caso de no contar con uno.

    */
    public function getCarrito(Request $request){
        // dd($request->all());
        $usuario = auth()->user()->id;
        $carrito = Carrito::where('id_usuario', $usuario)->where('estado', 'F')->first();

        $id_carrito = 0;
        $articulos = collect();
        $cant_articulos = 0;
        $total_final = 0;
        /*
        Si el usuario tiene carrito
        */
        if($carrito != null){

            $id_carrito = $carrito->id;
            // Verifica si el usuario ha agregado artículos al carrito antes de iniciar sesión.
            if($request->articulos != null){
                $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                /*
                - Elimina los articulos del carrito pasado del usuario
                - Agrega los articulos nuevos a la tabla web_articulos_carrito
                */
                // dd($id_carrito);
                ArticuloCarrito::where('id_carrito', $id_carrito)->delete();
                foreach ($request->articulos as $key => $value) {
                    $articulos_estado = $this->agregarArticulosC($id_carrito, $value['id'], $value['cantidad'], $value['grupo'], $value['departamento']);
                    $articulos->push($articulos_estado);
                    $total_final = $total_final + $articulos_estado['total'];
                }
                // Actualiza el carrito

                $up_carrito = Carrito::where('id', $id_carrito)->update(['total_venta' => number_format($total_final, 2, '.', ''), 'updated_at' => $fecha]);

            }else{
                // dd($carrito->articulos);
                // Si no ha agregado artículos busca los articulos del usuario en la tabla web_articulos_carrito
                foreach ($carrito->articulos as $key => $value) {
                    $articulos->push([
                        'id' => $value->id_articulo,
                        'total' => $value->precio_venta,
                        'precio_unitario' => $value->precio_unitario,
                        'cantidad' => $value->cant,
                        'bodega' => $value->bodega,
                        'grupo' => $value->grupo,
                        'departamento' => $value->departamento
                    ]);
                }

            }
        }else{
            // Si el usuario no tiene carrito  genera uno nuevo
            $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
            $id_carrito = Carrito::insertGetId([
            'id_usuario' =>  $usuario,
            'total_venta' => 0,
            'recordatorio' => 1,
            'mostrar' => 1,
            'estado' => 'F',
            'created_at' => $fecha
            ]);


            if($request->articulos != null){
                // Agrega los articulos nuevos a la tabla web_articulos_carrito

                foreach ($request->articulos as $key => $value) {
                    $articulos_estado = $this->agregarArticulosC($id_carrito, $value['id'], $value['cantidad'], $value['grupo'], $value['departamento']);
                    $articulos->push($articulos_estado);
                    $total_final = $total_final + $articulos_estado['total'];
                }

                $up_carrito = Carrito::where('id', $id_carrito)->update(['total_venta' => number_format($total_final, 2, '.', ''), 'updated_at' => $fecha]);
            }
        }
        return ['articulos' => $articulos, 'id_carrito' => $id_carrito];
    }


    /*
    Función utilizada para agregar productos al carrito, en caso de que sea la primera vez cargará todos los articulos, en caso contrario solo cargará un artículo
    */
    public function agregarCarrito(Request $request){
        // dd($request->all());
        $total = 0;
        $id_carrito_nvo = 0;
        $usuario = auth()->user()->id;
        $respuesta = collect();
        $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
        if(!$request->guardado){
            $id_carrito_del = Carrito::select('id')->where('id_usuario', $usuario)->where('estado', 'F')->first();
            if($id_carrito_del != null){
                Carrito::where('id', $id_carrito_del->id)->delete();
                ArticuloCarrito::where('id_carrito', $id_carrito_del)->delete();
            }

            $id_carrito = Carrito::insertGetId(['id_usuario' => $usuario,
            'total_venta' => number_format($request->total_venta, 2, '.', ''),
            'recordatorio' => 1,
            'mostrar' => 1,
            'estado' => 'F',
            'created_at' => $fecha]);
            // dd($id_carrito);


            foreach ($request->articulos as $key => $value) {
                $respuesta->push($this->agregarArticulosC($id_carrito, $value['id'], $value['cantidad'], $value['grupo'], $value['departamento']));
            }

            $total = ArticuloCarrito::select('precio_venta')->where('id_carrito', $id_carrito)->sum('precio_venta');

            $estado = $id_carrito ? true : false;
            Carrito::where('id', $id_carrito)->update(['total_venta' => number_format($total, 2, '.', ''), 'updated_at' => $fecha]);

            return ['respuesta' => $respuesta, 'id_carrito' => $id_carrito, 'carritoGuardado' => $estado];

        }else{

            $estado = $request->id_carrito ? true : false;
            $id_carrito = Carrito::where('id_usuario', auth()->user()->id)->where('estado', 'F')->where('id', $request->id_carrito)->select('id')->first();
            if($id_carrito == null){
                $id_carrito = Carrito::insertGetId(['id_usuario' => $usuario,
                'total_venta' => number_format(0.00, 2, '.', ''),
                'recordatorio' => 1,
                'mostrar' => 1,
                'estado' => 'F',
                'created_at' => $fecha]);
                // dd($id_carrito);
                // dd($id_carrito);

                foreach ($request->articulos_local as $key => $value) {
                    $respuesta->push($this->agregarArticulosC($id_carrito, $value['id'], $value['cantidad'],  $value['grupo'], $value['departamento']));
                }

                $total = ArticuloCarrito::select('precio_venta')->where('id_carrito', $id_carrito)->sum('precio_venta');
                $up_carrito = Carrito::where('id', $id_carrito)->update(['total_venta' => number_format($total, 2, '.', ''), 'updated_at' => $fecha]);

                return ['respuesta' => $respuesta, 'id_carrito' => $id_carrito, 'carritoGuardado' => $estado];
            }else{
                $isArticulo = ArticuloCarrito::where('id_carrito', $id_carrito->id)->where('id_articulo', $request->articulo)->select('cant')->first();

                if($isArticulo != null){
                    $cantidad = $isArticulo->cant;

                    // $precio_contado = DB::table('cat_articulos')
                    // ->where('articulo', $request->articulo)
                    // ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                    // ->get();

                    $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $request->articulo)->first();
                    $precio_contado = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                        ':Grupo' => $grupo->grupo,
                        ':Articulo' => $request->articulo
                    ]);


                    $precio = $precio_contado[0]->precio_contado;



                    $total = floatVal($precio) * (intVal($request->cantidad_articulos) + intVal($cantidad));
                    $subtotal_venta = $total / 1.16;
                    $iva_venta = $total - $subtotal_venta;

                    $bodegas = Bodega::orderBy('prioridad_cotizaciones')->get();
                    foreach ($bodegas as $key => $bodega) {
                        $existencias = ExistenciaArticulo::where('articulo', $request->articulo)->where('bodega', $bodega->bodega)->where('fisica', '<>', 0)->first();
                        if($existencias){
                            // dd($existencias, $key);
                            break;
                        }
                    }
                    $upArt = ArticuloCarrito::where('id_articulo', $request->articulo)->where('id_carrito', $id_carrito->id)->update([
                    'precio_unitario' => $precio,
                    'cant' => (intVal($request->cantidad_articulos) + intVal($cantidad)),
                    'subtotal_venta' => $subtotal_venta,
                    'iva_venta' => $iva_venta,
                    'precio_venta' => $total,
                    'bodega' => $existencias->bodega,
                    'updated_at' => $fecha
                    ]);
                }else{
                    $respuesta->push($this->agregarArticulosC($request->id_carrito, $request->articulo, $request->cantidad_articulos, $request->grupo, $request->departamento));
                }
                $total = ArticuloCarrito::select('precio_venta')->where('id_carrito', $request->id_carrito)->sum('precio_venta');
                $up_carrito = Carrito::where('id', $request->id_carrito)->update(['total_venta' => number_format($total, 2, '.', ''), 'updated_at' => $fecha]);
                return ['respuesta' => $respuesta, 'id_carrito' => $request->id_carrito, 'carritoGuardado' => $estado];
            }
        }
    }
    /*
    * Agrega articulos a la tabla ArticuloCarrito
    * @Param int $id_carrito, id del carrito al que pertenecen los articulos
    * @Param int $articulo, id del articulo que se agregará a la tabla ArticuloCarrito
    * @Param int $cantidad, cantidad de articulos a agregar
    */
    public function agregarArticulosC($id_carrito, $articulo, $cantidad, $grupo_local, $departamento_local){
        // dd($grupo, $departamento);
        // $articulos = DB::table('cat_articulos')
        //                         ->where('articulo', $articulo)
        //                         ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
        //                         ->get();

        $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $articulo)->first();
        $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
            ':Grupo' => $grupo->grupo,
            ':Articulo' => $articulo
        ]);

        $precio = $articulos[0]->precio_contado;
        $total = $precio * $cantidad;

        $subtotal_venta = $total / 1.16;
        $iva_venta = $total - $subtotal_venta;

        $bodegas = Bodega::orderBy('prioridad_cotizaciones')->get();
        $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
        foreach ($bodegas as $key => $bodega) {
            $existencias = ExistenciaArticulo::where('articulo', $articulo)->where('bodega', $bodega->bodega)->where('fisica', '<>', 0)->first();
            if($existencias){
                break;
            }
        }
        if($existencias){
            $articulo_carrito = ArticuloCarrito::insertGetId([
                'id_articulo' => $articulo,
                'id_carrito' => $id_carrito,
                'precio_unitario' => $precio,
                'cant' => $cantidad,
                'subtotal_venta' => number_format($subtotal_venta, 2, '.', ''),
                'iva_venta' => number_format($iva_venta, 2, '.', ''),
                'precio_venta' => number_format($total, 2, '.', ''),
                'bodega' => $existencias->bodega,
                'grupo' => $grupo_local,
                'departamento' => $departamento_local,
                'created_at' => $fecha
            ]);
            $estado = ($articulo_carrito && $id_carrito) ? true : false;
            return ['estado' => $estado, 'total' => $total, 'bodega' => $existencias->bodega];
        }else{
            $total = 0;
            return ['id_articulo' => $articulo, 'estado' => false, 'total' => $total, 'bodega' => $existencias->bodega];
        }
    }

    /*
    * Actualiza la cantidad del campo cant en la tabla ArticuloCarrito
    * @Param int id_articulo Id del artículo
    * @Param int cant Cantidad de articulos deseados
    */

    public function updateCarrito(Request $request){
        if($request->cant == null || $request->cant == 0){
            return response(['mensaje' => 'null', 'estado' => false]);
        }else{

                // $articulo = ArticuloCarrito::select('precio_unitario', 'cant', 'precio_venta')->where('id_articulo', $request->id_articulo)->where('id_carrito', $request->id_carrito)->where('id', $request->id)->first();
                // $articulo_precio = DB::table('cat_articulos')
                // ->where('articulo', $request->id_articulo)
                // ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                // ->get();
                // dd($articulo_precio);
                $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $request->id_articulo)->first();
                $articulo_precio = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                    ':Grupo' => $grupo->grupo,
                    ':Articulo' => $request->id_articulo
                ]);
                $precio = $articulo_precio[0]->precio_contado;

                $existencias = DB::table('cat_articulos_existencias')
                ->join('cat_articulos', 'cat_articulos_existencias.articulo', '=', 'cat_articulos.articulo')
                ->where('cat_articulos_existencias.articulo', $request->id_articulo)
                ->where('cat_articulos_existencias.fisica', '<>', 0)
                ->selectRaw('sum(cat_articulos_existencias.fisica) as suma')
                ->first();

                if($existencias->suma >= $request->cant){
                    $total = $precio * $request->cant;
                    // dd($total);
                    $subtotal_venta = $total / 1.16;
                    $iva_venta = $total - $subtotal_venta;
                    $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                    $update = ArticuloCarrito::where('id', $request->id)->update(['cant' => $request->cant, 'precio_venta' => $total, 'iva_venta' => $iva_venta, 'subtotal_venta' => $subtotal_venta, 'updated_at' => $fecha]);
                    $art_sum = ArticuloCarrito::select('precio_venta', 'iva_venta', 'subtotal_venta')->where('id_carrito', $request->id_carrito)->where('id', '<>', $request->id)->get();

                    $sum_total = $art_sum->sum('precio_venta');
                    $sum_iva = $art_sum->sum('iva_venta');
                    $sum_subtot = $art_sum->sum('subtotal_venta');

                    $sum_total = $sum_total + $total;
                    $sum_iva = $sum_iva + $iva_venta;
                    $sum_subtot = $sum_subtot + $subtotal_venta;

                    $upCart = Carrito::where('id', $request->id_carrito)->update(['total_venta' => $sum_total, 'updated_at' => $fecha]);
                    if($update && $upCart){
                        return response(['mensaje' => '', 'estado' => true, 'cant' => $request->cant,
                        'total' => $total,
                        'sum_tot' => $sum_total,
                        'sum_iva' => $sum_iva,
                        'sum_subtot' => $sum_subtot]);

                    }else{
                        return response(['mensaje' => 'Ocurrió un problema al agregar los articulos', 'estado' => false]);
                    }


                }else{
                    return response(['mensaje' => 'Actualmente solo se encuentran '. number_format($existencias->suma, 0) .' unidades en existencia de este producto.', 'estado' => false]);
                }
        }

    }

    public function eliminaArticuloUpdate(Request $request){

    }




}
