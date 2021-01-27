<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Carbon;
use DB;
use App\Direccion;
use App\OrdenVenta;
use App\ArticuloCarrito;
use App\Articulo;
use App\Ciudad;
use App\Estado;
use App\Municipio;
use App\Colonia;
use App\Doc_Ventas;

class ClienteController extends Controller
{

    /*
        Index: obtiene las direcciones del usuario autenticado, posteriormente envía la lista de direcciones y redirecta a la vista Cliente.
    */
    // public function index(Request $dato){
    //     $direcciones = Direccion::where('id_usuario', auth()->user()->id)->get();
    //     $direccion_principal = collect();
    //     $lista_direcciones = collect();
    //         foreach ($direcciones as $key => $value) {
    //             $lista_direcciones->push([
    //                 'id_direccion' => $value->id,
    //                 'nombre_direccion' => $value->nombre_direccion
    //             ]);
    //         }
    //     $email = auth()->user()->email;
    //     $num_cliente = auth()->user()->id;
    //     return view('Usuario.accountMVC', ['lista_direcciones'=> $lista_direcciones, 'email' => $email, 'num_cliente' => $num_cliente]);
    // }




    public function index(){
        $isOrden = false;
        // Verifica si está iniciado sesión
        if(auth()->user()){
            // Obtiene las direcciones del cliente
            $direcciones = Direccion::where('id_usuario', auth()->user()->id)->get();
            $direccion_principal = collect();
            $lista_direcciones = collect();

            // Recorre las direcciones y las almacena en un objeto array
            foreach ($direcciones as $key => $value) {
                $lista_direcciones->push([
                    'id_direccion' => $value->id,
                    'nombre_direccion' => $value->nombre_direccion
                ]);
            }

            $email = auth()->user()->email;
            $num_cliente = auth()->user()->id;
            $ordenVenta = OrdenVenta::where('id_usuario', $num_cliente)->where('estado_trans', 'A')->get(); // Obtiene las ordenes de venta aceptadas
            $datos_historial = collect();
            $dat_array = [];
            $art_array = collect();

            // Si tiene ordenes de venta
            if(!$ordenVenta->isEmpty()){
                $isOrden = true;
                // recorre las ordenes de venta y obtiene los datos de la orden
                foreach ($ordenVenta as $key => $value) {

                    $municipio = Municipio::where('municipio', $value->id_municipio_reparto)->where('estado', 28)->first();
                    $ciudad = Ciudad::where('ciudad', $value->id_ciudad_reparto)->where('municipio', $value->id_municipio_reparto)->where('estado', 28)->first();
                    $colonia = Colonia::where('municipio', $value->id_municipio_reparto)->where('ciudad', $value->id_ciudad_reparto)->where('colonia', $value->id_colonia_reparto)->where('estado', 28)->first();

                    if($value->forma_pago == '28'){
                        $forma_pago = 'Débito';
                    }else if($value->forma_pago == '04'){
                        $forma_pago = 'Crédito';
                    }


                    $articuloCarrito = ArticuloCarrito::where('id_carrito',$value->id_carrito)->select('id_articulo', 'cant', 'precio_unitario', 'precio_venta')->get();

                    foreach ($articuloCarrito as $key => $valueA) {
                        $articulo = Articulo::where('articulo', $valueA->id_articulo)->select('descripcion_corta', 'grupo', 'departamento')->first();


                        $art_array->push([
                            'id_articulo' => $valueA->id_articulo,
                            'cant' => $valueA->cant,
                            'descripcion_art' => $articulo->descripcion_corta,
                            'grupo' => $articulo->grupo,
                            'departamento' => $articulo->departamento,
                            'precio_unitario' => number_format($valueA->precio_unitario, 2, '.', ','),
                            'total' => number_format($valueA->precio_venta, 2, '.', ',')
                        ]);

                    }
                    $direccion = 'Calle '. $value->calle_reparto . ', #' .  $value->numero_casa_reparto . ', CP ' . $value->cp_reparto . '. </br>Colonia ' .  $colonia->descripcion . ', ' . $ciudad->descripcion . ', ' . $municipio->descripcion . '. </br>Referencias: '. $value->referencias_reparto;

                    $subtotal = $value->total_carrito / 1.16;
                    $iva = $value->total_carrito - $subtotal;


                    $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
                    $fecha = Carbon::parse($value->fecha_venta);
                    $mes = $meses[($fecha->format('n')) - 1];
                    $fecha_venta = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');

                    $isCancelada = Doc_Ventas::where('serie', 'FW')->where('folio', 154)->first();
                    if($isCancelada || $isCancelada != []){
                        $isCancelada = $isCancelada->cancelada;
                    }else{
                        $isCancelada = false;
                    }

                    $dat_array = [
                        'id_carrito' => $value->id_carrito,
                        'isCancelada' => $isCancelada,
                        'folio_factura' => $value->folio_factura,
                        'fecha_venta' => $fecha_venta,
                        'forma_pago' => $forma_pago,
                        'ultimos_digitos' => $value->ultimos_digitos,
                        'subtotal_venta' => number_format($subtotal, 2, '.', ','),
                        'iva_venta' => number_format($iva, 2, '.', ','),
                        'total_venta' => number_format($value->total_venta, 2, '.', ','),
                        'total_carrito' => number_format($value->total_carrito, 2, '.', ','),
                        'precio_flete' => number_format($value->precio_flete, 2, '.', ','),
                        'municipio' => $municipio->descripcion,
                        'ciudad' => $ciudad->descripcion,
                        'colonia' => $colonia->descripcion,
                        'persona_recibe' => $value->persona_recibe_reparto,
                        'telefono' => $value->persona_tel_contacto_reparto,
                        'calle' => $value->calle_reparto,
                        'numero_casa' => $value->numero_casa_reparto,
                        'cp' => $value->cp_reparto,
                        'entre_calle' => $value->entre_calle_reparto,
                        'y_calle' => $value->y_calle_reparto,
                        'referencias' => $value->referencias_reparto,
                        'direccion' => $direccion,
                        'articulos' => $art_array
                    ];


                    $datos_historial->push(['datos_orden' => $dat_array]);
                    $art_array = collect();
                }
            }else{
                $isOrden = false;
            }

            return view('Usuario.accountMVC', ['lista_direcciones'=> $lista_direcciones,
            'email' => $email,
            'num_cliente' => $num_cliente,
            'isOrden' => $isOrden,
            'datos_historial' => $datos_historial]);
        }else{
            // dd(auth()->user());
            return redirect('/login');
        }

    }


}
