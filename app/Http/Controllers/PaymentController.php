<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use \PayPal\Rest\ApiContext;
use \PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use App\OrdenVenta;
use App\Carrito;
// use App\AesCrypto;
use App\Dinamica_Enero_2021;
use App\cryptoAES;
use DB;
use App\ArticuloCarrito;
use \PayPal\Exception\PayPalConnectionException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    private $apiContext;

    public function __construct(){

        $payPalConfig = Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],     // ClientID
                $payPalConfig['secret']      // ClientSecret
            )
        );
    }

    public function payWithPayPal(){
        //Crea objeto del usuario que va a pagar
        $dato_cliente = collect();

        $payer = new Payer();
        $payer->setPaymentMethod('paypal'); //Asigna el método de pago PayPal

        $item2 = new Item();
        $item2->setName('Granola bars')
        ->setCurrency('MXN')
        ->setQuantity(1)
        ->setSku("321321") // Similar to `item_number` in Classic API
        ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems(array($item2));

        // Total que va a pagar
        $amount = new Amount();
        $amount->setTotal('2'); //Modificar cantidad en base al total de compra
        $amount->setCurrency('MXN'); //Tipo de moneda
        // Se crea la transacción
        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setItemList($itemList)
        ->setDescription("Payment description")
        ->setInvoiceNumber(uniqid());

        $callbackUrl = url('/paypal/status');
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)
            ->setCancelUrl($callbackUrl);

        $payment = new Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            // ->setItemList($itemList)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);
        dd($payment);
        try {
            $payment->create($this->apiContext);
            //echo $payment;
            return redirect()->away($payment->getApprovalLink());
        }
        catch (PayPalConnectionException $ex) {
            // This will print the detailed information on the exception.
            //REALLY HELPFUL FOR DEBUGGING
            echo $ex->getData(); // hacer redirect a ruta e informar
            echo $ex->getCode();
            die($ex);
        }

    }

    public function paypalStatus(Request $request){

        $paymentId = $request->input('paymentId');
        $payer = $request->input('PayerID');
        $token = $request->input('token');
        // dd($paymentId, $payer, $token);
        if(!$paymentId || !$payer || !$token){
            $status = 'No se pudo proceder con el pago a través de PayPal.';
            return redirect('/paypal/failed')->with('status', $status);
        }

        $payment = Payment::get($paymentId, $this->apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($payer);

        //Se ejecuta el pago
        $result = $payment->execute($execution, $this->apiContext);
        dd($result);
        if($result->getState() === 'approved'){
            //Aqui se guarda la información en la base de datos web_ordenes_venta

            $status = 'Su pago se ha realizado correctamente.';
            return redirect('/CarritoCheckOut')->with('status', $status);
        }

        $status = 'El pago a través de PayPal no se pudo realizar.';
        return redirect('/CarritoCheckOut')->with('status', $status);


    }

    public function prueba(Request $request){
        // dd($request->all());
        $instanceENCRYPT = new cryptoAES();
        // dd($instanceENCRYPT);
        $key = '51C787C51590F9ED7491219F14476B9A';
        $data0 = '9265655531';
        $folio = $request->folio;
        $total = $request->total;
        $id_carrito = $request->id_carrito;
        if(auth()->user()){
            $correo = auth()->user()->email;
        }else{
            $correo = $request->correo;
        }
        $fecha_ultimo_mes = Carbon::now()->endOfMonth();
        $dia = $fecha_ultimo_mes->day;
        $mes = $fecha_ultimo_mes->month;
        $año = $fecha_ultimo_mes->isoFormat('YYYY');
        $vigencia = $dia.'/'.$mes.'/'.$año;

        $string = '<?xml version="1.0" encoding="UTF-8"?>
        <P>
        <business>
            <id_company>01DA</id_company>
            <id_branch>0009</id_branch>
            <user>01DASIUS0</user>
            <pwd>5868MVC965V2</pwd>
        </business>
        <url>
            <reference>'.$folio.'</reference>
            <amount>'.$total.'</amount>
            <moneda>MXN</moneda>
            <canal>W</canal>
            <omitir_notif_default>1</omitir_notif_default>
            <promociones>C</promociones>
            <st_correo>1</st_correo>
            <fh_vigencia>'.$vigencia.'</fh_vigencia>
            <mail_cliente>'.$correo.'</mail_cliente>
        </url>
        </P>';

        $cadenaEncriptada = $instanceENCRYPT->encriptar($string,$key);

        $cadenaEnviar='<pgs>';
        $cadenaEnviar.='<data0>'.$data0.'</data0>';
        $cadenaEnviar.='<data>'.$cadenaEncriptada.'</data>';
        $cadenaEnviar.='</pgs>';

        $data = array('xml'=>$cadenaEnviar);

        $sendData= http_build_query($data) . "\n";
        $endpoints = "https://bc.mitec.com.mx/p/gen";

        $ch = curl_init();
        	    curl_setopt($ch, CURLOPT_URL, $endpoints);
        	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        		curl_setopt($ch, CURLOPT_POST,true);
        	    curl_setopt($ch, CURLOPT_POSTFIELDS,$sendData);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        		 $responseData = curl_exec($ch);
		if ( curl_errno($ch) ) {
	        echo 'cURL ERROR -> ' . curl_errno($ch) . ': ' . curl_error($ch);
	    }else {

			$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);

            switch($returnCode){
	            case 200:
	            	$responseData=utf8_encode($responseData);
					#para ver la respuesta del servidor(desencriptar respuesta)
					$stringdesencriptar = $instanceENCRYPT->desencriptar($responseData,$key);
					// echo "</br>desencriptar:</br>";
                    // dd($stringdesencriptar);
                    // print_r($stringdesencriptar);

                    // for ($i=0; $i < strlen($stringdesencriptar); $i++) {
                    //     if($stringdesencriptar[$i] === 'h'){
                    //         dd('h');
                    //     }
                    // }
                    // curl_getinfo($ch, ['http_code']);
                    // dd($stringdesencriptar);
                    return $stringdesencriptar;
                    curl_close($ch);
					die();
	            	$xmlDoc = new \DOMDocument();

	            	$xmlDoc->loadXML($stringdesencriptar);
	            	echo $xmlDoc->SaveXML();
                    // dd($xmlDoc->SaveXML());
	            	$xpath = new \DOMXPath($xmlDoc);
   					$MITresponse= $xpath->query("//P_RESPONSE/cd_response");

	            	foreach($MITresponse as $xmlRes){
	            		echo $webpayResp=$xmlRes->textContent;
    	            }
	                break;
	            default:
	               echo 'ErrorHTTP';
	               echo $returnCode;
	               break;
			}
		}
        /**
        * Close the handle
        */
        // dd($ch);



        curl_close($ch);
        return $ch;

    }

    public function getResponse2(Request $request){
        // dd($request->all());
        $uso_cfdi = ' ';
        $uso = ($uso_cfdi == ' ' || $uso_cfdi == null || $uso_cfdi == '') ? 'G03' : $uso_cfdi;
        dd($uso);
        Log::warning('---------------------------- INICIA -------------------------------');
        Log::warning('---------------------------- FINALIZA ------------------------------');
        dd('hola');
        $strResponse = '<CENTEROFPAYMENTS>null    <reference>C161220203</reference>
        <response>approved</response>    <foliocpagos>000551635</foliocpagos>
        <auth>0SNBX1</auth>
        <cd_response>0C</cd_response>
        <cd_error/>    <nb_error/>
        <time>04:49:33</time>
        <date>16/12/2020</date>
        <nb_company>SANDBOX WEBPAY</nb_company>
        <nb_merchant>1234567 WEBPAYPLUS</nb_merchant>
        <cc_type>CREDITO/BANCO MIT/Visa</cc_type>
        <tp_operation>VENTA</tp_operation>
        <cc_name/>
        <cc_number>0001</cc_number>
        <amount>120000.00</amount>
        <id_url>SNDBX001</id_url>
        <email>nospam@gmail.com</email>
        <cc_mask>545454XXXXXX1234</cc_mask>
        <datos_adicionales>
        <data id="1">            <label>Talla</label>            <value>Grande</value>        </data>        <data id="2">            <label>Color</label>            <value>Azul</value>        </data>     </datos_adicionales><st_stored>0</st_stored><number_tkn>ABCD545454545454</number_tkn></CENTEROFPAYMENTS>';
        $key = '5dcc67393750523cd165f17e1efadd21'; //Llave de 128 bits
        dd(cryptoAES::encriptar($strResponse, $key));
        $decodedString = urldecode($strResponse);
        $decryptedString = cryptoAES::desencriptar($decodedString, $key);
        dd($decryptedString);
        $stringDecode = simplexml_load_string($decryptedString);
        if($stringDecode->response == 'error'){

        }else if($stringDecode->response == 'denied'){

        }else if($stringDecode->response == 'approved'){

        }

    }

    public function getResponse(Request $request){
        Log::warning('---------------------------- INICIA -------------------------------');
        Log::warning($request->all());
        $instanceENCRYPT = new cryptoAES();
        $originalString = urlencode($request->strResponse);

        $decodedString = urldecode($originalString);

        $msg = '';
        $key = '51C787C51590F9ED7491219F14476B9A';
        // $key = '5dcc67393750523cd165f17e1efadd21';
        $decryptedString = $instanceENCRYPT->desencriptar($decodedString, $key);
        Log::warning($decryptedString);
        $stringDecode = simplexml_load_string($decryptedString);
        Log::warning($stringDecode);
        Log::warning($stringDecode->reference);

        $cc_number = $stringDecode->cc_number; //ultimos digitos
        $forma_pago = $stringDecode->cc_type;
        $folio = '';
        foreach ($stringDecode->reference as $key => $value) {
            $folio .= $value;
        }

        $id_carrito = Carrito::where('folio', $folio)->select('id')->first();

        if(!$id_carrito || $id_carrito == null || $id_carrito == []){
            Log::emergency('Ocurrió un problema al procesar la venta, revisar Debug.');
        }else{
            Log::warning('id_carrito '. $id_carrito);
        }
        Log::warning($id_carrito);
        // dd($id_carrito->id);
        Log::warning('---------------------------- FINALIZA ------------------------------');
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
            $forma_pago = '04';
        }
        else{
            $forma_pago = '28';
        }

        $orden = OrdenVenta::where('id_carrito', $id_carrito->id)->update([
        'forma_pago' => $forma_pago,
        'ultimos_digitos' => $cc_number,
        'pago_confirmado' => $pago_confirmado,
        'estado_trans' => $estado,
        'fecha_confirmacion_pago' => $fecha,
        'updated_at' => $fecha_up
        ]);
        // dd($orden);

        Carrito::where('id', intVal($id_carrito->id))->update(['estado' => $estado, 'updated_at' => $fecha_up]);

        if($estado === 'A'){
            DB::select(DB::raw("SET NOCOUNT ON; exec web_genera_factura_ins :id_carrito"),[
                ':id_carrito' => intVal($id_carrito->id)
            ]);

            $orden = OrdenVenta::where('id_carrito', $id_carrito->id)->first();
            $fecha = date("d-m-Y H:i:s", strtotime(Carbon::now()));

            $registra = Dinamica_Enero_2021::insertGetId(['serie' => 'FW', 'folio' => intVal($orden->folio_factura),
            'nombre' => strVal($orden->persona_recibe_reparto),
            'correo' => strVal($orden->email_facturacion),
            'telefono' => strVal($orden->persona_tel_contacto_reparto),
            'created_at' => $fecha]);



            Log::notice('Compra realizada perteneciente al id carrito: '. $id_carrito->id . ' con folio: ' . $folio);
        }else{
            Log::info('Compra denegada perteneciente al id carrito: '. $id_carrito->id . ' con folio: ' . $folio);
        }
        // return view('/');
        // return view('Carrito/CheckOrdenVenta', ['esPago'=> true, 'estado' => $estado, 'msg' => $msg]);
    }



}
