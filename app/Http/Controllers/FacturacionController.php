<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\CFDI;
use App\Carrito;
use App\ArticuloCarrito;
use App\Articulo;
use App\Direccion;
use App\Bodega;
use App\ExistenciaArticulo;
use App\OrdenVenta;
use App\Cliente;
use App\User;
use App\FoliosCXC;
use App\FoliosOrden;
use App\AesCrypto;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class FacturacionController extends Controller
{
    /*

        Obtiene el RFC del cliente logeado. Se utiliza la funcion web_obtener_cliente al cual se le pasa el RFC.

    */
    public function getClienteRFC(Request $request){
        // dd($request->all());
        $esCliente = false;
        $cliente = DB::select('select dbo.web_obtener_cliente(?) as cliente', array($request->rfc));
        if($cliente[0]->cliente != 0){
            $esCliente = true;
            if(auth()->user()){
                $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                $up_user = User::where('id', auth()->user()->id)->update(['cliente_web' => 'W-'.$cliente[0]->cliente, 'cliente' => $cliente[0]->cliente, 'updated_at' => $fecha]);
            }
        }
        return response(['esCliente' => $esCliente, 'idCliente' => $cliente[0]->cliente]);
    }

    /*
        En caso de requerir factura y no encontrar a un cliente relacionado al RFC proporcionado por el usuario se registrará al cliente en la tabla cat_clientes

    */
    public function setClienteRFC(Request $request){
        // dd($request->all());

        DB::beginTransaction();
        try {
            $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
            // FoliosCXC::where('descripcion', 'cat_clientes')->update(['ultimo_folio' => 161801, 'updated_at' => $fecha]);
            // TENF930604BQ5
            $isCliente = collect();
            $last_fol = FoliosCXC::where('descripcion', 'cat_clientes')->select('ultimo_folio')->first();
            $cliente = $last_fol->ultimo_folio+1;

            $datos = [];
            $datos = [
                'cliente' => $cliente,
                'rfc' => $request->rfc,
                'domicilio' => $request->calle_fact,
                'numero_exterior' => $request->num_ext_fact,
                'estado' => $request->estado_select_fact,
                'municipio' => $request->municipio_select_fact,
                'ciudad' => $request->ciudad_select_fact,
                'colonia' => $request->colonia_select_fact,
                'cp' => $request->cp_fact,
                'ingresos' => 1,
                'usuario' => 'SUPER',
                'saldo' => 0.00,
                'sucursal' => 9,
                'no_paga_comision' => 0,
                'rfc_completo' => 1,
                'limite_credito' => 0.00,
                'saldo_vencido' => 0.00,
                'localizado' => 0,
                'QUE' => 'A',
                'QUIEN' => 'SUPER',
                'CUANDO' => $fecha,
                'DONDE' => 'WEB',
                'activo' => 1,
                'facturacion_especial' => 0,
                'uso_cfdi' => $request->select_uso_cfdi,
            ];

            if($request->tipo_p === 'M'){
                $tipo_persona = [
                    'persona' => $request->tipo_p,
                    'nombre' => $request->razon_fact,
                ];
            }else {
                $tipo_persona = [
                    'persona' => $request->tipo_p,
                    'nombre' => $request->nombres_fact . ' ' . $request->paterno_fact . ' ' . $request->materno_fact,
                    'nombres' => $request->nombres_fact,
                    'paterno' => $request->paterno_fact,
                    'materno' => $request->materno_fact,
                ];
            }

            $datos_insert = $datos + $tipo_persona;
            Cliente::insert($datos_insert);
            $isCliente = Cliente::where('cliente', $cliente)->select('cliente')->first();
            if($isCliente){
                if(auth()->user()){
                    $up_user = User::where('id', auth()->user()->id)->update(['cliente_web' => 'W-'.$isCliente->cliente, 'cliente' => $isCliente->cliente, 'updated_at' => $fecha]);
                }
                $folio = DB::update("update cat_folios_cxc set ultimo_folio = ". $cliente ." where descripcion = 'cat_clientes'");
                DB::commit();
                return response(['estado' => true, 'id_cliente' => $isCliente->cliente]);
            }else{
                DB::commit();
                return response(['estado' => false, 'id_cliente' => false]);
            }

        }catch(Exception $e){
            DB::rollBack();
            return response(['estado' => false, 'id_cliente' => false]);
        }

        // dd($isCliente, $folio);

    }

    /*

    */
    public function CFDI(){
        $uso_cfdi = collect();
        $cfdi = CFDI::select('uso_cfdi', 'descripcion')->get();
        // dd($cfdi);
        return response(['uso_cfdi' => $cfdi]);
    }

    public function getFolio(Request $request){
        $id_usuario = auth()->user() ? auth()->user()->id : '160721';
        $carrito = Carrito::where('id_usuario', $id_usuario)->where('recordatorio', 1)->select('folio')->first();
        if($carrito){
            return response(['folio' => $carrito->folio]);
        }else{
            return false;
        }
    }

    public function setCartNoRegistrado(Request $request){
        $folio = '';
        if($request->carrito){
            $art_cart = $request->carrito;
            DB::beginTransaction();
            try {
                $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                $id_carrito = Carrito::insertGetId(['id_usuario' => '160721',
                'recordatorio' => 1,
                'mostrar' => 1,
                'estado' => 'NP',
                'total_venta' => 0,
                'created_at' => $fecha]);
                $fecha_folio = Carbon::now();
                $dia = $fecha_folio->isoFormat('DD');
                $mes = $fecha_folio->isoFormat('MM');
                $año = $fecha_folio->isoFormat('YY');
                $total_final = 0;
                // dd($dia, $mes, $año, $fecha_folio);
                $folio = 'C'.$dia.$mes.$año.$id_carrito;
                $cart_fol = Carrito::where('id', $id_carrito)->update(['folio' => $folio]);
                if($cart_fol){
                    $total = 0;
                    for ($i=0; $i < count($art_cart); $i++) {
                        // $precio_contado = DB::table('cat_articulos')
                        // ->where('articulo', $art_cart[$i]['id'])
                        // ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                        // ->first();

                        $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $art_cart[$i]['id'])->first();
                        $precio_contado = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                            ':Grupo' => $grupo->grupo,
                            ':Articulo' => $art_cart[$i]['id']
                        ]);


                        $total = floatVal($precio_contado[0]->precio_contado) * floatVal($art_cart[$i]['cantidad']);
                        $total_final += $total;
                        $sub_total = floatVal($total) / 1.16;
                        $iva = $total - $sub_total;
                        ArticuloCarrito::insert(['id_carrito' => $id_carrito, 'id_articulo' => $art_cart[$i]['id'], 'precio_unitario' => floatVal($precio_contado[0]->precio_contado),
                            'cant' => intVal($art_cart[$i]['cantidad']),
                            'subtotal_venta' => $sub_total,
                            'iva_venta' => $iva,
                            'precio_venta' => $total,
                            'bodega' =>  strval($art_cart[$i]['bodega']),
                            'created_at' => $fecha
                        ]);
                    }
                    $act_cart =  Carrito::where('id', $id_carrito)->update(['total_venta' => $total_final]);
                }
                DB::commit();
                return response(['folio' => $folio, 'id_carrito' => $id_carrito]);
            }catch(Exception $e) {
                DB::rollBack();
                return false;
            }
        }
    }

    public function actCartRegistrado(Request $request){
        if($request->folio){
            if($request->carrito){
                $art_cart = $request->carrito;
                DB::beginTransaction();
                try {
                    $total_final = 0;
                    $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
                    $id_carrito = Carrito::where('folio', $request->folio)->select('id')->first();
                    // dd($id_carrito, $request->all());
                    $id_carrito = $id_carrito->id;
                    for ($i=0; $i < count($art_cart); $i++) {
                        // $precio_contado = DB::table('cat_articulos')
                        // ->where('articulo', $art_cart[$i]['id'])
                        // ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                        // ->first();

                        $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $art_cart[$i]['id'])->first();
                        $precio_contado = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                            ':Grupo' => $grupo->grupo,
                            ':Articulo' => $art_cart[$i]['id']
                        ]);

                        $total = floatVal($precio_contado[0]->precio_contado) * floatVal($art_cart[$i]['cantidad']);
                        $total_final += $total;
                        $sub_total = floatVal($total) / 1.16;
                        $iva = $total - $sub_total;
                        ArticuloCarrito::where('id_carrito', $id_carrito)->update(['id_carrito' => $id_carrito, 'id_articulo' => $art_cart[$i]['id'], 'precio_unitario' => floatVal($precio_contado[0]->precio_contado),
                        'cant' => intVal($art_cart[$i]['cantidad']),
                        'subtotal_venta' => $sub_total,
                        'iva_venta' => $iva,
                        'precio_venta' => $total,
                        'bodega' =>  strval($art_cart[$i]['bodega']),
                        'created_at' => $fecha]);

                    }
                    $act_cart = Carrito::where('id', $id_carrito)->update(['total_venta' => $total_final]);
                    DB::commit();
                    return true;
                }catch(Exception $e){
                    DB::rollBack();
                    return false;
                }
            }
        }
    }

    public function CarritoCheckOutView(Request $request){
        $lista_direcciones = collect();
        if($request->all()){
            // dd($request->all());
            $mensaje = '';
            if($request->nbResponse === 'Rechazado'){
                $mensaje = $request->nb_error ? $request->nb_error : 'La transacción ha sido rechazada por el banco emisor, intente de nuevo con otra tarjeta o método de pago.';
            }else if($request->nbResponse === 'Aprobado'){
                $mensaje = 'El pago se ha realizado con éxito.';
            }else{
                $mensaje = 'Error en la información proporcionada al someter la solicitud de autorización.';
            }

            // dd($mensaje);
            // $mensaje = $request->nb_error ? $request->nb_error : 'El pago se ha realizado con éxito.';
            // dd($mensaje);
            if(Auth()->user()){
                $direcciones = Direccion::where('id_usuario', auth()->user()->id)->get();
                foreach ($direcciones as $key => $value) {
                    $lista_direcciones->push([
                        'id_direccion' => $value->id,
                        'nombre_direccion' => $value->nombre_direccion
                    ]);
                }
            }

            $referencia = $request['referencia'];
            $json = collect();
            $curl = curl_init();

            if($referencia){
                $orden = OrdenVenta::where('folio_trans', $referencia)->first();
                if($orden != null || $orden){
                    $id_carrito = $orden->id_carrito;

                    $carrito = Carrito::where('id', $id_carrito)->first();
                    // dd($carrito->articulos);
                    $articulos = $carrito->articulos;
                    foreach ($articulos as $key => $value) {
                        $articulo_nombre = Articulo::where('articulo', $value->id_articulo)->first();
                        $json->push([
                            'codigo' => $value->id_articulo,
                            'nombre_articulo' => $articulo_nombre->descripcion_corta,
                            'precio_unitario' => number_format($value->precio_unitario, 2, '.', ','),
                            'cant' => $value->cant,
                            'total_articulo' => number_format($value->precio_unitario * $value->cant, 2, '.', ',')
                        ]);
                    }

                    $total_venta = number_format($orden->total_carrito, 2, '.', ',');
                    $envio = number_format($orden->precio_flete, 2, '.', ',');
                    $nombre = $orden->persona_recibe_reparto;
                    $email = $orden->email_facturacion;
                }




                curl_setopt_array($curl, [
                    CURLOPT_URL => "https://api.sendinblue.com/v3/smtp/email",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\"sender\":{\"name\":\"Muebleria Villarreal\",
                        \"email\":\"contacto@muebleria-villarreal.com\"},
                        \"to\":[{\"email\":\"$email\"},{\"email\":\"oscarinfante.mvc@gmail.com\"},{\"email\":\"linda.muebleriavillareal@gmail.com\"}],
                        \"replyTo\":{\"email\":\"contacto@muebleria-villarreal.com\"},
                        \"params\":{\"products\":$json,
                        \"total_venta\":\"$total_venta\",
                        \"envio\":\"$envio\",
                        \"nombre\":\"$nombre\"
                        },
                        \"templateId\":331}",
                    CURLOPT_HTTPHEADER => [
                        "Accept: application/json",
                        "Content-Type: application/json",
                        "api-key: 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"
                        ],
                    ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                $message = json_decode($response);
                curl_close($curl);
            }





            return view('Carrito/CheckOrdenVenta', ['lista_direcciones' => $lista_direcciones, 'esPago' => true, 'response' => $request->nbResponse, 'mensaje' => $mensaje]);
        }else{
            if(Auth()->user()){
                $direcciones = Direccion::where('id_usuario', auth()->user()->id)->get();
                $lista_direcciones = collect();
                foreach ($direcciones as $key => $value) {
                    $lista_direcciones->push([
                        'id_direccion' => $value->id,
                        'nombre_direccion' => $value->nombre_direccion
                    ]);
                }
                return view('Carrito/CheckOrdenVenta',['lista_direcciones' => $lista_direcciones, 'esPago' => false]);
            }
            return view('Carrito/CheckOrdenVenta',['lista_direcciones' => $lista_direcciones, 'esPago' => false, 'response' => false, 'mensaje' => false]);
        }
    }


    public function enviaCorreoCheck(Request $request){
        // dd($request['referencia']);

        $referencia = 'C21R508F310';
        $json = collect();
        $curl = curl_init();






    }



    public function generaOrden(Request $request){


        $correo = '';

        $datos_general = [];
        $direccion_dat = [];
        $direccion = collect();
        $datos_facturacion = [];
        $datos_extras = [];
        $id_cliente_mvc = 160721;
        $id_usuario = auth()->user() ? auth()->user()->id : 160721;
        // Se obtiene el último folio generado
        $ultimo_folio_orden = FoliosOrden::where('descripcion', 'web_orden_venta')->where('campo', 'folio_trans')->select('ultimo_folio')->first();
        // dd($ultimo_folio_orden);
        $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));
        // Se obtienen el total, subtotal e iva de la venta
        $total = $request->total_cont;

        $total_carrito = $request->total_carrito;
        $precio_flete = $request->precio_flete;

        $subtotal = $total / 1.16;
        $iva = $total - $subtotal;
        $id_carrito = 0;
        // Se obtienen las variables para generar el folio
        $fecha_folio = Carbon::now();
        $dia = $fecha_folio->day;
        $mes = $fecha_folio->month;
        $año = $fecha_folio->isoFormat('YY');
        // Si está autenticado se actualiza el folio
        $last_folio = intVal($ultimo_folio_orden->ultimo_folio);
        $folio = 'C'.$año.'R'.random_int(1, 1000).'F'.($last_folio+1);
        // $folio =  'C'.$dia.$mes.$año.($last_folio+1);
        // actualiza el ultimo folio de la tabla orden de venta folio
        $up_folio = FoliosOrden::where('descripcion', 'web_orden_venta')->where('campo', 'folio_trans')->update(['ultimo_folio' => $last_folio+1, 'updated_at' => $fecha]);

        // Se valida que se obtenga el carrito, en caso contrario se genera un carrito y se le cambia el estado a dicho carrito
        if(auth()->user()){
            // Obtiene la dirección del cliente
            $id_dir = $request->id_dir;
            $direccion = Direccion::where('id_usuario', auth()->user()->id)->where('id', $id_dir)->first();
            // dd($direccion, auth()->user()->id, $request->all());
            $direccion_dat = [
                'persona_recibe_reparto' => $direccion->nombre_contacto . ' ' . $direccion->paterno . ' ' . $direccion->materno,
                'persona_tel_contacto_reparto' => $direccion->telefono,
                'calle_reparto' => $direccion->calle,
                'numero_casa_reparto' => $direccion->num_ext,
                'cp_reparto' => $direccion->cp,
                'entre_calle_reparto' => $direccion->entre_calle,
                'y_calle_reparto' => $direccion->y_calle,
                'id_estado_reparto' => 28,
                'id_ciudad_reparto' => intVal($direccion->ciudad),
                'id_municipio_reparto' => intVal($direccion->municipio),
                'id_colonia_reparto' => intVal($direccion->colonia),
                'referencias_reparto' => $direccion->referencias
            ];


            $id_carrito = $request->id_carrito;
            $carrito = Carrito::where('id', $id_carrito)->where('estado', 'F')->update(['folio' => $folio, 'total_venta' => $total_carrito]);
            if(!$carrito){
                // dd($carrito);

                $id_carrito = Carrito::insertGetId(['id_usuario' => auth()->user()->id, 'folio' => $folio, 'total_venta' => $total_carrito,
                'recordatorio' => 1, 'mostrar' => 1, 'estado'  => 'F', 'created_at' => $fecha]);

                $articulos = json_decode($request->art_cart);

                for ($i=0; $i < count($articulos) ; $i++) {
                    // $precio_articulo = DB::table('cat_articulos')
                    // ->where('articulo', intVal($articulos[$i]->id))
                    // ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                    // ->first();
                    $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $articulos[$i]->id)->first();
                    $precio_articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                        ':Grupo' => $grupo->grupo,
                        ':Articulo' => $articulos[$i]->id
                    ]);
                    $precio_c = $precio_articulo ? $precio_articulo[0]->precio_contado : $articulos[$i]->precio_unitario;
                    $total_art = floatVal($precio_c) * intVal($articulos[$i]->cantidad);
                    $subtotal_art = $total_art / 1.16;
                    $iva_art = $total_art - $subtotal_art;

                    $articulo = ArticuloCarrito::insertGetId(['id_articulo' => intVal($articulos[$i]->id), 'id_carrito' => intVal($id_carrito),
                    'precio_unitario' => floatVal($precio_c),
                    'cant' => intVal($articulos[$i]->cantidad),
                    'subtotal_venta' => floatVal($subtotal_art),
                    'iva_venta' => floatVal($iva_art),
                    'precio_venta' => floatVal($total_art),
                    'bodega' => strval($articulos[$i]->bodega),
                    'created_at' => $fecha
                    ]);
                }
            }
            $correo = auth()->user()->email;
        }else{ //Si no está autenticado se agregan los articulos y se genera el folio
            // dd('tiene carro');
            // Obtiene la dirección que proporciona el usuario en el formulario
            $direccion = json_decode($request->direccion);
            // dd($direccion->nombre_dir_val);
            $direccion_dat = [
                'persona_recibe_reparto' => $direccion->nombre_dir_val . ' ' . $direccion->paterno_dir_val . ' ' . $direccion->materno_dir_val,
                'persona_tel_contacto_reparto' => $direccion->telefono_dir_val,
                'calle_reparto' => $direccion->calle_dir,
                'numero_casa_reparto' => $direccion->num_ext_dir,
                'cp_reparto' => $direccion->cp_dir,
                'entre_calle_reparto' => $direccion->entre_calle1_dir,
                'y_calle_reparto' => $direccion->entre_calle2_dir,
                'id_estado_reparto' => 28,
                'id_ciudad_reparto' => intVal($direccion->ciudad_select),
                'id_municipio_reparto' => intVal($direccion->municipio_select),
                'id_colonia_reparto' => intVal($direccion->colonia_select),
                'referencias_reparto' => $direccion->referencias_dir
            ];

            $id_carrito = Carrito::insertGetId(['id_usuario' => 160721, 'folio' => $folio, 'total_venta' => $total_carrito, 'recordatorio' => 1, 'mostrar' => 1, 'estado'  => 'F', 'created_at' => $fecha]);
            $articulos = json_decode($request->art_cart);

            for ($i=0; $i < count($articulos) ; $i++) {
                // $precio_articulo = DB::table('cat_articulos')
                // ->where('articulo', intVal($articulos[$i]->id))
                // ->selectRaw('dbo.webPrecioContado (cat_articulos.articulo) as precio_contado')
                // ->first();

                $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $articulos[$i]->id)->first();
                $precio_articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                    ':Grupo' => $grupo->grupo,
                    ':Articulo' => $articulos[$i]->id
                ]);

                $precio_c = $precio_articulo ? $precio_articulo[0]->precio_contado : $articulos[$i]->precio_unitario;
                $total_art = floatVal($precio_c) * intVal($articulos[$i]->cantidad);
                $subtotal_art = $total_art / 1.16;
                $iva_art = $total_art - $subtotal_art;
                $articulo = ArticuloCarrito::insertGetId(['id_articulo' => intVal($articulos[$i]->id), 'id_carrito' => intVal($id_carrito),
                'precio_unitario' => floatVal($precio_c),
                'cant' => intVal($articulos[$i]->cantidad),
                'subtotal_venta' => floatVal($subtotal_art),
                'iva_venta' => floatVal($iva_art),
                'precio_venta' => floatVal($total_art),
                'bodega' => strval($articulos[$i]->bodega),
                'created_at' => $fecha
                ]);
            }

            $correo = $direccion->correo_dir_val;
        }
        // Obtiene el último folio que se generó de la tabla web_orden_venta
        $folio_factura = FoliosOrden::where('descripcion', 'web_orden_venta')->where('campo', 'folio_factura')->select('ultimo_folio')->first();
        $last_f_factura = intVal($folio_factura->ultimo_folio);
        $up_folio = FoliosOrden::where('descripcion', 'web_orden_venta')->where('campo', 'folio_factura')->update(['ultimo_folio' => $last_f_factura+1, 'updated_at' => $fecha]);
        Carrito::where('id', $id_carrito)->update(['estado' => 'T']);  // Actualiza el carrito

        // Si requiere factura, entonces busca el usuario en caso de que se haya iniciado sesión y se seleccionará el id del cliente
        // en caso de no estar iniciado sesión busca el id del cliente
        if($request->isFact == 'true'){

            $id_cliente_mvc = $request->id_cliente;

            $cliente = Cliente::where('cliente', $id_cliente_mvc)->select('persona','nombre','nombres','paterno','materno', 'telefono1','rfc','domicilio','numero_exterior','entrecalle','ycalle','estado','municipio','ciudad','colonia','cp', 'uso_cfdi')->first();
            // dd($cliente);
            $uso = ($cliente->uso_cfdi == ' ' || $cliente->uso_cfdi == null || $cliente->uso_cfdi == '') ? 'G03' : $cliente->uso_cfdi;

            $datos_facturacion = [
                'tipo_persona' => $cliente->persona == 'F' ? 1 : 0,
                'nombre_facturacion' => $cliente->nombres,
                'paterno_facturacion' =>$cliente->paterno,
                'materno_facturacion' => $cliente->materno,
                'razon_social_facturacion' => $cliente->nombre,
                'email_facturacion' => $correo,
                'telefono_facturacion' => $cliente->telefono1,
                'RFC_facturacion' => $cliente->rfc,
                'calle_facturacion' => $cliente->entrecalle,
                'num_ext_facturacion' => $cliente->numero_exterior,
                'id_estado_facturacion' => $cliente->estado,
                'id_municipio_facturacion' => $cliente->municipio,
                'id_ciudad_facturacion' => $cliente->ciudad,
                'id_colonia_facturacion' => $cliente->colonia,
                'cp_facturacion' => $cliente->cp,
                'CFDI_facturacion' => $uso
            ];

            // dd($datos_facturacion);
        }else{

            $nombre_fac = auth()->user() ? $direccion->nombre_contacto : $direccion->nombre_dir_val;
            $paterno_fact = auth()->user() ? $direccion->paterno : $direccion->paterno_dir_val;
            $materno_fact = auth()->user() ? $direccion->materno : $direccion->materno_dir_val;
            $telefono_fact = auth()->user() ? $direccion->telefono : $direccion->telefono_dir_val;

            $datos_facturacion = [
                'tipo_persona' => NULL,
                'nombre_facturacion' => $nombre_fac,
                'paterno_facturacion' => $paterno_fact,
                'materno_facturacion' => $materno_fact,
                'razon_social_facturacion' => $nombre_fac . ' ' . $paterno_fact . ' ' . $materno_fact,
                'email_facturacion' => $correo,
                'telefono_facturacion' => $telefono_fact,
                'RFC_facturacion' => NULL,
                'calle_facturacion' => NULL,
                'num_ext_facturacion' => NULL,
                'num_int_facturacion' => NULL,
                'id_estado_facturacion' => NULL,
                'id_municipio_facturacion' => NULL,
                'id_ciudad_facturacion' => NULL,
                'id_colonia_facturacion' => NULL,
                'cp_facturacion' => NULL,
                'CFDI_facturacion' => NULL
            ];
        }

        // if(auth()->user() && $request->isFact == 'false'){
        //     $cliente_mvc = User::where('id', auth()->user()->id)->first();
        //     if($cliente_mvc->cliente != null){
        //         $id_cliente_mvc = $cliente_mvc->cliente;
        //     }
        // }


        $datos_extras = [
            'id_cliente_mvc' => $id_cliente_mvc,
            'id_carrito' => $id_carrito,
            'id_usuario' => $id_usuario,
            'folio_trans' => $folio,
            'subtotal_venta' => $subtotal,
            'iva_venta' => $iva,
            'total_venta' => $total,
            'fecha_venta' => $fecha,
            'total_carrito' => $total_carrito,
            'precio_flete' => $precio_flete,
            'created_at' => $fecha,
            'updated_at' => $fecha

        ];

        $datos_general = $direccion_dat + $datos_extras + $datos_facturacion;

        $ordenVenta = OrdenVenta::insertGetId($datos_general);

        return $folio;

    }

    // TENF930604BQ5
    public function pruebaResponse(Request $request){
        // dd($request->all());
        // Log::info($request->all());
        // Log::info($request->strResponse);


        // dd($articulos);
        $instanceENCRYPT = new AesCrypto();
        $originalString = urlencode($request->strResponse);
        // Log::info($originalString);
        $decodedString = urldecode($originalString);
        // Log::info($decodedString);
        // dd($decodedString);
        $msg = '';
        $key = '5dcc67393750523cd165f17e1efadd21';
        // $key = '5dcc67393750523cd165f17e1efadd21';
        $decryptedString = $instanceENCRYPT->desencriptar($decodedString, $key);
        // Log::info($decryptedString);
        $stringDecode = simplexml_load_string($decryptedString);
        // Log::info($stringDecode);
        // dd($stringDecode);
        //
        // Log::info($stringDecode->reference);

        $cc_number = $stringDecode->cc_number; //ultimos digitos
        $forma_pago = $stringDecode->cc_type;
        $folio = '';
        foreach ($stringDecode->reference as $key => $value) {
            $folio .= $value;
        }
        // dd($folio);
        // $id_carrito = Carrito::where('folio', $folio)->select('id')->first();
        // dd($stringDecode->reference === 'MIFACTURA001');
        // Log::info($id_carrito);
        // dd($id_carrito->id);
        $estado = '';

        if($stringDecode->response == 'error'){
            $pago_confirmado = 'error';
            $estado = 'E';

        }else if($stringDecode->response == 'denied'){
            $pago_confirmado = 'denied';
            $estado = 'D';

        }else if($stringDecode->response == 'approved'){
            $pago_confirmado = 'approved';
            $estado = 'A';
        }
        $fecha_confirmacion = $stringDecode->date . ' ' .$stringDecode->time;

        $fecha = date("d-m-Y H:i:s", strtotime($fecha_confirmacion));
        $fecha_up = date("d-m-Y H:i:s", strtotime(Carbon::now()));
        // dd($fecha);
        $forma_pago_bus = '';
        foreach ($stringDecode->cc_type as $key => $value) {
            $forma_pago_bus .= $value;
        }
        // dd($forma_pago_bus);
        $c_FormaPago_credito = strpos($forma_pago_bus, 'CREDITO');
        $c_FormaPago_debito = strpos($forma_pago_bus, 'DEBITO');
        if($c_FormaPago_credito !== false){
            $forma_pago = 4;
        }
        else{
            $forma_pago = 28;
        }

        // dd($forma_pago);

        $orden = OrdenVenta::where('id_carrito', 6)->update([
        'forma_pago' => 28,
        'ultimos_digitos' => 4525,
        'pago_confirmado' => 'approved',
        'estado_trans' => 'A',
        'fecha_confirmacion_pago' => $fecha,
        'total_venta' => '5.00',
        'updated_at' => $fecha_up
        ]);
        // dd($orden);

        Carrito::where('id', 6)->update(['estado' => 'A', 'updated_at' => $fecha_up]);

        $articulos = DB::select(DB::raw("SET NOCOUNT ON; exec web_genera_factura_ins :id_carrito"),[
            ':id_carrito' => 6
        ]);

        // return view('/');
        // return view('Carrito/CheckOrdenVenta', ['esPago'=> true, 'estado' => $estado, 'msg' => $msg]);
    }





















}
