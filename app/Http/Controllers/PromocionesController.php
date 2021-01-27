<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CodigoDescuento;
use App\DescuentoArticulo;
use App\DescuentoDepartamento;
use App\DescuentoGrupo;
use Illuminate\Support\Carbon;

use DB;

class PromocionesController extends Controller
{
    public function busca_codigo(Request $request){
        // dd($request->all());
        // $ip = $this->getUserIpAddress();
        // dd($ip);
        /*
        Estados:
        0.- No se recibió el código.
        1.- El código no existe en los registros.
        2.- El código ya ha sido usado.
        3.-

        */




        $codigo = [];
        $arts = [];
        $deps = [];
        $grup = [];
        $monto = 0;
        $restricciones_array = [];

        if($request->codigo){

            $codigo = CodigoDescuento::where('codigo', $request->codigo)->first();

            if($codigo){

                $total_usado = intVal($codigo->total_usado) + 1;
                // $codigo_update = CodigoDescuento::where('codigo', $codigo->codigo)->update(['total_usado' => $total_usado]);

                $fecha_hoy = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                $fecha_inicio = $codigo->fecha_inicio;
                $fecha_fin = $codigo->fecha_fin;

                $es_fecha_valida = $this->valida_fechas($fecha_inicio, $fecha_fin, $fecha_hoy);
                $es_valido = ($codigo->total_valido > $codigo->total_usado) ? true : false;
                // dd($es_fecha_valida);

                if($es_valido && $es_fecha_valida){

                    if($codigo->articulos){
                        $articulos = DescuentoArticulo::where('id', $codigo->articulos)->get();
                        $arts = $articulos->map(function ($item, $key){
                            return intVal($item->articulo);
                        });
                        $arts = $arts->toArray();
                    }else if($codigo->departamentos){
                        $departamentos = DescuentoDepartamento::where('id', $codigo->departamentos)->get();

                        $deps = $departamentos->map(function ($item, $key){
                            return intVal($item->departamento);
                        });
                        $deps = $deps->toArray();

                    }else if($codigo->grupos){
                        $grupos = DescuentoGrupo::where('id', $codigo->grupos)->get();

                        $grup = $grupos->map(function ($item, $key){
                            return intVal($item->grupo);
                        });
                        $grup = $grup->toArray();
                    }

                    $monto = $codigo->monto ? $codigo->monto : 0;

                    $carrito = json_decode($request->carrito);
                    $total_carrito = $request->total_carrito;
                    $descuento = ($total_carrito * ($codigo->porcentaje / 100));
                    $total_con_descuento = $total_carrito - $descuento;
                    // $total_carrito = $total_carrito - $cant_descuento;

                    if(count($carrito) == 1){

                        $precio_art = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                            ':Grupo' => $carrito[0]->grupo,
                            ':Articulo' => $carrito[0]->id
                        ]);

                        $precio_contado = $precio_art[0]->precio_contado;
                        $descuento = ($precio_contado * ($codigo->porcentaje / 100));
                        $total_con_descuento = $precio_contado - $descuento;
                        $subtotal = $total_con_descuento / 1.16;
                        $iva = $total_con_descuento - $subtotal;

                        // dd($carrito[0]->departamento, $deps);

                        $aplica_codigo = $arts != [] && in_array($carrito[0]->id, $arts) ? true :
                        (($deps != [] && in_array($carrito[0]->departamento, $deps)) ? true :
                        (($grup != [] && in_array($carrito[0]->grupo, $grup)) ? true :
                        false));

                        if($aplica_codigo){
                            $carrito[0]->precio_unitario = $total_con_descuento;
                            echo $carrito[0]->precio_unitario;
                        }else{
                            dd('no aplica');
                            //retorna carrito y mensaje
                        }

                    }else{
                        $subtotal = $total_con_descuento / 1.16;
                        $iva = $total_con_descuento - $subtotal;
                        for ($i=0; $i < count($carrito); $i++) {
                            $precio_art = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                                ':Grupo' => $carrito[$i]->grupo,
                                ':Articulo' => $carrito[$i]->id
                            ]);

                            $precio_contado = $precio_art[0]->precio_contado;
                            $descuento = ($precio_contado * ($codigo->porcentaje / 100));
                            $total_con_descuento = $precio_contado - $descuento;

                            $aplica_codigo = $arts != [] && in_array($carrito[$i]->id, $arts) ? true :
                            (($deps != [] && in_array($carrito[$i]->departamento, $deps)) ? true :
                            (($grup != [] && in_array($carrito[$i]->grupo, $grup)) ? true :
                            false));

                            if($aplica_codigo){
                                $carrito[$i]->precio_unitario = $total_con_descuento;
                                $carrito[$i]->total = $carrito[$i]->precio_unitario * $carrito[$i]->cantidad;
                            }else{
                                echo 'no aplica';
                            }


                        }
                    }



                }else{
                    // return response(['estado' => 2]);
                }




                $codigo = $codigo->codigo;
            }else{
                // return response(['estado' => 1]);
            }




        }else{
            // return response(['estado' => 0]);
        }

        // dd($codigo);



    }


    public function valida_fechas($fecha_inicio, $fecha_fin, $fecha_hoy) {
        $fecha_inicio = strtotime($fecha_inicio);
        $fecha_fin = strtotime($fecha_fin);
        $fecha_hoy = strtotime($fecha_hoy);
        if (($fecha_hoy >= $fecha_inicio) && ($fecha_hoy <= $fecha_fin))
            return true;
        return false;
     }


     function getUserIpAddress() {

        foreach ( [ 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR' ] as $key ) {

            // Comprobamos si existe la clave solicitada en el array de la variable $_SERVER
            if ( array_key_exists( $key, $_SERVER ) ) {

                // Eliminamos los espacios blancos del inicio y final para cada clave que existe en la variable $_SERVER
                foreach ( array_map( 'trim', explode( ',', $_SERVER[ $key ] ) ) as $ip ) {

                    // Filtramos* la variable y retorna el primero que pase el filtro
                    if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) !== false ) {
                        return $ip;
                    }
                }
            }
        }

        return '?'; // Retornamos '?' si no hay ninguna IP o no pase el filtro
    }


}
