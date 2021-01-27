<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function (Request $request) {
//     return view('welcome');
// });
Route::get('/', 'IndexController@listarMenu')->name('/');
//Pagos
//PayPal
Route::get('paypal/pay', 'PaymentController@payWithPayPal');
Route::get('paypal/status', 'PaymentController@paypalStatus');
Route::get('pruebaSan', 'PaymentController@prueba');
Route::post('/responsewebpay', 'PaymentController@getResponse');

Route::post('/pruebaResponse', 'FacturacionController@pruebaResponse');
Route::get('/Facturacion', function (Request $request) {
    return view('Facturacion.Facturacion');
});
Route::get('/kliemtheprubajeje', 'PruebasController@pruebacliente');

Route::get('pruebaswp', 'PaymentController@getResponse2');
// ------ Rutas Filtros ------------------------------------------------------------------------------------------
Route::get('busqueda/{dato}', 'FiltrosController@busqueda_barra');
Route::get('search/{dato}', 'FiltrosController@busqueda_vista');
Route::get('/filtros', 'FiltrosController@filtros');
// ------ Rutas Direcciones -----------------------------------------------------------------------------------------
Route::get('/listadirecciones', 'DireccionController@getlistaDirecciones');
Route::post('/guardaDireccion', 'DireccionController@guardaDireccion')->name('guardaDireccion');
Route::get('/getDireccionEsp/{id_direccion}', 'DireccionController@getDireccionEsp');
Route::get('/getFlete', 'DireccionController@getFleteCiudad');

// ------ Rutas Localidades Dirección -----------------------------------------------------------------------------------------
Route::get('/getColonias', 'LocalidadesController@getColonias');
Route::get('/getCiudadL', 'LocalidadesController@getCiudad');
Route::get('/getMunicipio', 'LocalidadesController@getMunicipio');
// ------ Rutas Localidades Facturación -----------------------------------------------------------------------------------------
Route::get('/getEstado', 'LocalidadesController@getEstado');
Route::get('/getColoniasf', 'LocalidadesController@getColoniasF');
Route::get('/getCiudadf', 'LocalidadesController@getCiudadF');
Route::get('/getMunicipiof', 'LocalidadesController@getMunicipioF');

// ------- Rutas Accesos ----------------------------------------------------------------------------------------
Route::get('/login', function (Request $request) {
    return view('Auth.Login');
});
Route::get('login', function () {
    return view('Auth.Login');
});

Route::post('login', 'LoginController@login')->name('login');
Route::post('logout', 'LoginController@logout')->name('logout')->middleware('auth');
Route::post('register', 'Auth\RegisterController@register')->name('register');

Route::get('UserRegistrationForm', function () {
    return view('UserRegistrationForm');
});

Route::get('sendemail', function () {

    $data = array(
        'name' => "Learning Laravel",
    );

    Mail::send('welcome', $data, function ($message) {

        $message->from('yourEmail@domain.com', 'Learning Laravel');

        $message->to('yourEmail@domain.com')->subject('Learning Laravel test email');

    });

    return "Your email has been sent successfully";

});

// ------- Rutas Reset contraseña ----------------------------------------------------------------------------------------
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');


// ------- Rutas Departamentos ----------------------------------------------------------------------------------------
Route::group(['prefix' => 'Departamento'], function() {
    Route::get('{departamento}/{grupo}', 'DepartamentosController@index');
    Route::get('articulosDepto/{departamento}/{grupo}', 'DepartamentosController@articulosDepto');
});
// ------- Rutas Articulos ----------------------------------------------------------------------------------------
Route::get('Articulo', 'ArticulosController@index');
Route::get('Articulo/{articulo}/{grupo}', 'ArticulosController@detalleArticulo');

Route::get('Articulos/Detalles', function () {
    return view('Articulos.Detalles');
});
// ------- Rutas Cliente ----------------------------------------------------------------------------------------
Route::get('cliente', 'ClienteController@index')->middleware('auth');
Route::get('clienteR/{res}/{isCreate}', 'ClienteController@nuevaDireccionR')->middleware('auth');

// ------- Rutas Cliente RFC ----------------------------------------------------------------------------------------
Route::get('getClienteRFC', 'FacturacionController@getClienteRFC');
Route::post('setClienteRFC', 'FacturacionController@setClienteRFC');
Route::get('/getCFDI', 'FacturacionController@CFDI');
Route::get('/getFolio', 'FacturacionController@getFolio');
Route::post('/setCarrito', 'FacturacionController@setCartNoRegistrado');
Route::post('/actCarritoF', 'FacturacionController@actCartRegistrado');
Route::post('/generaOrden', 'FacturacionController@generaOrden');

// Rutas Promociones
Route::get('/aplica_codigo', 'PromocionesController@busca_codigo');


// ------- Rutas Carrito ----------------------------------------------------------------------------------------
Route::get('carrito', 'CarritoController@index')->name('carrito');
Route::post('ajaxUpCart', 'CarritoController@updateCarrito');

Route::get('CarritoCheckOut', 'FacturacionController@CarritoCheckOutView');

Route::get('carrito_info', 'CarritoController@getCarrito');
Route::get('getTotalVenta', 'CarritoController@getCarrito');
Route::get('totart', 'CarritoController@getTotalArticulos');
Route::get('totartLoc', 'CarritoController@getTotalLocal');
Route::get('delArticulo', 'CarritoController@delArticulo');


Route::post('agregar', 'CarritoController@agregarCarrito');

// ------- Rutas Empresa ---------------------------------------------------------------------------------------
Route::get('SubDep', function () {
    return view('Busqueda.Results');
});

Route::get('prueba', function () {
    return view('Prueba');
});
// ------- Rutas Empresa ---------------------------------------------------------------------------------------
Route::group(['prefix' => 'Empresa'], function() {
    Route::get('QuienesSomos', function () {
        return view('Empresa.QuienesSomos');
    });

    Route::get('AvisodePrivacidad', function () {
        return view('Empresa.AvisodePrivacidad');
    });

    Route::get('PoliticasdeDevolucion', function () {
        return view('Empresa.PoliticasdeDevolucion');
    });

    Route::get('TerminosyCondiciones', function () {
        return view('Empresa.TerminosyCondiciones');
    });

    Route::get('Sucursales', function () {
        return view('Empresa.Sucursales');
    });

    Route::get('Contacto', function () {
        return view('Empresa.Contacto');
    });
});

Route::post('/registrarUsuarios', 'LoginController@registrarUsuarios');

Route::get('registros', function () {
    return view('registros');
});

// ------- Rutas Limpia Caché ---------------------------------------------------------------------------------------
Route::get('/artisan/{cmd}', function($cmd) {
    $cmd = trim(str_replace("-",":", $cmd));
    $validCommands = ['cache:clear', 'optimize', 'route:cache', 'route:clear', 'view:clear', 'config:cache'];
    if (in_array($cmd, $validCommands)) {
        Artisan::call($cmd);
        return "<h1>Ran Artisan command: {$cmd}</h1>";
    } else {
        return "<h1>Not valid Artisan command</h1>";
    }
});
