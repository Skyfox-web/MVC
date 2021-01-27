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
use App\Carrito;
use App\Departamento;
use App\Grupo;
use App\ArticuloFoto;
use App\ExistenciaArticulo;

use Illuminate\Support\Facades\Log;
class PruebasController extends Controller
{
    /*
    Se obtienen las direcciones y ordenes de venta del cliente logeado
    */
    public function pruebacliente(){
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

                    $dat_array = [
                        'id_carrito' => $value->id_carrito,
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

            // dd(count($lista_direcciones));
            // dd($lista_direcciones, $direccion_principal);
            return view('Usuario.prueba', ['lista_direcciones'=> $lista_direcciones,
            'email' => $email,
            'num_cliente' => $num_cliente,
            'isOrden' => $isOrden,
            'datos_historial' => $datos_historial]);
        }else{
            // dd(auth()->user());
            return redirect('/login');
        }

    }

    public function eliminaDireccion(Request $datos){
        // dd($datos->all());

        if(auth()->user()){
            $direccion = Direccion::where('id_usuario', auth()->user()->id)->where('id', $datos->id_direccion)->delete();
            if($direccion){
                return response(['estado' => true]);
            }else{
                return response(['estado' => false]);
            }
        }

    }

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

        return view('Pruebas/Etc/Departamentos', ['id_d' => $id_d,
                                    'id_g' => $id_g,
                                    'subdepto' => $grupos->descripcion,
                                    'isMarca' => $isMarca,
                                    'total_lista' => $total_marcas,
                                    'descripcion_grupo' => $nom_grupo->descripcion
                                    ]);
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


    /*
    Función usada para envíar correos para comprar en tienda.

    */
    public function enviaCorreo(Request $request){
        // dd($request->all(), $request->id_carrito);

        $total = 0;
        $template = 0;
        /*
            Si está auth buscará el carrito asociado y obtendrá lo precios de los artículos del carrito y posteriormente lo guardará en el json que será enviado al template del correo
        */
        $idc = 529;
        if(auth()->user()){
            $json = collect();
            $actualiza_cart = Carrito::where('id', intVal($idc))->update(['venta_fisica' => 1]);
            $articulos = ArticuloCarrito::where('id_carrito', intVal($idc))->get();
            foreach ($articulos as $key => $value) {
                //Obtiene los artículos y procesa los precios
                $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $value->id_articulo)->first();
                $articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                    ':Grupo' => $grupo->grupo,
                    ':Articulo' => $value->id_articulo
                ]);

                $enganche = $articulo[0]->importe_enganche * $value->cant;
                $mensualiades = $articulo[0]->importe_documentos * $value->cant;
                $json->push([
                    'id_articulo' => $value->id_articulo,
                    'nombre_articulo' => $articulo[0]->descripcion_corta,

                    'precio_unitario_credito' => number_format($articulo[0]->precio_credito, 2, '.', ','),
                    'precio_credito' => number_format($articulo[0]->precio_credito * $value->cant, 2, '.', ','),

                    'precio_unitario_contado' => number_format($articulo[0]->precio_contado, 2, '.', ','),
                    'precio_contado' => number_format($articulo[0]->precio_contado * $value->cant, 2, '.', ','),

                    'cantidad' => $value->cant,
                    'enganche' => number_format($enganche, 2, '.', ','),
                    'meses' => $articulo[0]->plazo,
                    'mensualidades' => number_format($mensualiades, 2, '.', ','),
                    'url' => 'http://www.muebleria-villarreal.com/articulos_img/4',
                    'image' => 'htpp://www.muebleria-villarreal.com/articulos_img/4/79660.jpg'
                    // 'image' => 'htpp://www.muebleria-villarreal.com/articulos_img/4/79660.jpg'.$articulo[0]->departamento . '/' . $articulo[0]->articulo . '.jpg'
                ]);
                if($request->tipo_venta == 'true'){
                    $total += $articulo[0]->precio_credito * $value->cant;
                }else{
                    $total += $articulo[0]->precio_contado * $value->cant;
                }
            }
            // dd($json);

        }else{
            /*
                En caso de ser cliente invitado obtendrá el carrito y el tipo de venta para posteriormente crear el carrito y obtener los precios y totales para ser enviados al template del correo
            */
            $resp_json = $this->setCartNoRegistrado($request->carrito, $request->tipo_venta);
            $correo = $request->email;
            $this->agrega_contacto_sendinblue($correo);
            $total = $resp_json['total'];
            $json = $resp_json['json'];
        }
        $curl = curl_init();
        $data_string = $json;
        // dd($total);
        if($request->tipo_venta == 'true'){
            $template = 315;
        }else{
            $template = 314;
        }
        $total = number_format($total, 2, '.', ',');
        $correo = 'lidk97@gmail.com'; // Cambiar email por email request

        $url = 'http://www.muebleria-villarreal.com/articulos_img/4';

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.sendinblue.com/v3/smtp/email",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"sender\":{\"name\":\"Muebleria Villarreal\",
                \"email\":\"publicidad@mvc.com.mx\"},
                \"to\":[{\"email\":\"lidk97@gmail.com\"}],
                \"replyTo\":{\"email\":\"lidk97@gmail.com\"},
                \"params\":{\"products\":$data_string,
                \"total\":\"$total\",
                \"url\":\"$url\"
                },
                \"templateId\":314}",
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
            dd($message);
            foreach ($message as $key => $value) {
                if($key == 'messageId'){
                    return response(['respuesta' => true]);
                }else if($key == 'code' || $key == 'message'){
                    return response(['respuesta' => false]);
                }
            }
    }



    public function enviaCorreoCheck(Request $request){
        // dd($request['referencia']);

        $referencia = 'C21R508F310';
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
                    \"email\":\"publicidad@mvc.com.mx\"},
                    \"to\":[{\"email\":\"$email\"}],
                    \"replyTo\":{\"email\":\"$email\"},
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
            dd($message);
            foreach ($message as $key => $value) {
                if($key == 'messageId'){
                    return response(['respuesta' => true]);
                }else if($key == 'code' || $key == 'message'){
                    return response(['respuesta' => false]);
                }
            }
        }





    }


    /*
        Obtiene el carrito y el tipo de venta para posteriormente crear el carrito y obtener los precios de cada artículo y calcular los precios y totales finales para envíar en el correo
    */

    public function setCartNoRegistrado($carrito, $tipo_venta){
        $folio = '';
        $json = collect();
        $total_cotizacion = 0;
        $precio_unitario = 0;

        if($carrito){
            $art_cart = $carrito;
            DB::beginTransaction();
            try {
                $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));

                $id_carrito = Carrito::insertGetId(['id_usuario' => '160721',
                'recordatorio' => 1,
                'mostrar' => 1,
                'estado' => 'F',
                'total_venta' => 0,
                'venta_fisica' => 1,
                'created_at' => $fecha]);
                $total_final = 0;
                $total = 0;
                for ($i = 0; $i < count($art_cart); $i++) {
                    $grupo = Articulo::select('grupo', 'descripcion_corta', 'departamento')->where('articulo', $art_cart[$i]['id'])->first();
                    $articulo = DB::select(DB::raw("SET NOCOUNT ON; exec web_articulos_grupo_sel :Grupo, :Articulo"),[
                        ':Grupo' => $grupo->grupo,
                        ':Articulo' => $art_cart[$i]['id']
                    ]);
                    //contado


                    $enganche = $articulo[0]->importe_enganche * $art_cart[$i]['cantidad'];
                    $mensualiades = $articulo[0]->importe_documentos * $art_cart[$i]['cantidad'];
                    $json->push([
                        'id_articulo' => $art_cart[$i]['id'],
                        'nombre_articulo' => $articulo[0]->descripcion_corta,

                        'precio_unitario_credito' => number_format($articulo[0]->precio_credito, 2, '.', ','),
                        'precio_credito' => number_format($articulo[0]->precio_credito * $art_cart[$i]['cantidad'], 2, '.', ','),

                        'precio_unitario_contado' => number_format($articulo[0]->precio_contado, 2, '.', ','),
                        'precio_contado' => number_format($articulo[0]->precio_contado * $art_cart[$i]['cantidad'], 2, '.', ','),

                        'cantidad' => $art_cart[$i]['cantidad'],
                        'enganche' => number_format($enganche, 2, '.', ','),
                        'meses' => $articulo[0]->plazo,
                        'mensualidades' => number_format($mensualiades, 2, '.', ','),
                        'image' => 'www.muebleria-villarreal.com/articulos_img/'.$articulo[0]->departamento . '/' . $articulo[0]->articulo . '.jpg'
                    ]);
                    if($tipo_venta == 'true'){
                        $total_cotizacion += $articulo[0]->precio_credito * $art_cart[$i]['cantidad'];
                        $precio_unitario = $articulo[0]->precio_credito;
                    }else{
                        $total_cotizacion += $articulo[0]->precio_contado * $art_cart[$i]['cantidad'];
                        $precio_unitario = $articulo[0]->precio_contado;
                    }



                    $total = floatVal($precio_unitario) * floatVal($art_cart[$i]['cantidad']);
                    $total_final += $total;
                    $sub_total = floatVal($total) / 1.16;
                    $iva = $total - $sub_total;
                    ArticuloCarrito::insert(['id_carrito' => $id_carrito, 'id_articulo' => $art_cart[$i]['id'], 'precio_unitario' => floatVal($precio_unitario),
                        'cant' => intVal($art_cart[$i]['cantidad']),
                        'subtotal_venta' => $sub_total,
                        'iva_venta' => $iva,
                        'precio_venta' => $total,
                        'bodega' =>  strval($art_cart[$i]['bodega']),
                        'created_at' => $fecha
                    ]);
                }
                $act_cart =  Carrito::where('id', $id_carrito)->update(['total_venta' => $total_final]);

                DB::commit();

                return ['json' => $json, 'total' => $total_cotizacion];
            }catch(Exception $e) {
                DB::rollBack();
                return false;
            }
        }
    }

    public function agrega_contacto_sendinblue($correo){
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.sendinblue.com/v3/contacts",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"updateEnabled\":false,\"email\":\"$correo\"}",
            CURLOPT_HTTPHEADER => [
            "Accept: application/json",
            "Content-Type: application/json",
            "api-key: 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"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }
    }



}
