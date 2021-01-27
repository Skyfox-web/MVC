@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- Finalizar compra
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')
<div class="container">
    <div class="row">
<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
        <a href="{{ url('Dinamica') }}">
            <div class="carousel-item active">
                <img class="d-block w-100" src="../img/banners/Checkoutban.png" alt="First slide">
            </div>
        </a>
    </div>
</div>
</div>
</div>

<!--https://github.com/Johann-S/bs-stepper-->
<!-- MultiStep Form -->
<div class="container">
    <div class="row justify-content-between">
        <div class="col-xl-7 col-lg-8 col-md-7">
            <input type="hidden" id="vista" value="facturacion">
            <input type="hidden" id="esPago" value="{{ $esPago }}">

            <div id="stepper1" class="bs-stepper">
                <div class="bs-stepper-header">
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-md-6 col-sm-3 col-3">
                            <div class="step" data-target="#Datos-entrega">
                                <button type="button" class="btn step-trigger" role="tab" aria-controls="logins-part" id="Datos-entrega-part">
                                    <span class="bs-stepper-circle">1</span>
                                    <span class="bs-stepper-label">Datos de entrega</span>
                                </button>
                            </div>
                        </div>
                        <!-- <div class="line"></div> -->
                        <div class="col-xl-3 col-md-6 col-sm-3 col-3">
                            <div class="step" data-target="#datos-facturacion">
                                <button type="button" class="btn step-trigger" role="tab" aria-controls="logins-part" id="Datos-Facturacion-part">
                                    <span class="bs-stepper-circle">2</span>
                                    <span class="bs-stepper-label">Facturación</span>
                                </button>
                            </div>
                        </div>
                        <!-- <div class="line"></div> -->
                        <div class="col-xl-3 col-md-6 col-sm-3 col-3">
                            <div class="step" data-target="#Metodo-pago">
                                <button type="button" class="btn step-trigger" role="tab" aria-controls="logins-part" id="metodo-pago-part">
                                    <span class="bs-stepper-circle">3</span>
                                    <span class="bs-stepper-label">Métodos de pago</span>
                                </button>
                            </div>
                        </div>
                        <!-- <div class="line"></div> -->
                        <div class="col-xl-3 col-md-6 col-sm-3 col-3">
                            <div class="step" data-target="#Last-part">
                                <button type="button" class="btn step-trigger" role="tab" aria-controls="logins-part" id="Last-finish-part">
                                    <span class="bs-stepper-circle">4</span>
                                    <span class="bs-stepper-label">Finalizar compra</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bs-stepper-content">
                    <div id="Datos-entrega" class="content" role="tabpanel" aria-labelledby="Datos-entrega-part">
                        <div class="">

                            @if(auth()->user())
                                <input type="hidden" id="email_ticket" value="{{ auth()->user()->email }}">
                                @if(!$esPago or $response != 'Aprobado')

                                <div class="CarrCOMPStep"  id="dir_guard">

                                    <div class="form-row saved-directions-form " >
                                        <div class="form-card">
                                            <h4>Datos de entrega</h4>
                                        </div>

                                        <div class="col-md-9">
                                            @if(count($lista_direcciones) < 1) <h6>No tiene direcciones guardadas, agregue una dirección para continuar.</h6>
                                            @else
                                            <input type="hidden" id="cont_lista_direcciones" value="{{ count($lista_direcciones)}}">
                                            <h5>Tus direcciones guardadas:</h5>
                                            <select class="custom-select" onchange="getInfDir()" id="inputGroupSelect01">
                                                @foreach($lista_direcciones as $key => $direccion)
                                                <option class="custom-select" onselect='getInfDir({{ $direccion['id_direccion']}})' value='{{ $direccion['id_direccion']}}'>{{ $direccion['nombre_direccion'] }}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>
                                        <button class="col-md-3 btn btn-primary" onclick="addDom()" type="button" name="button">Agregar nueva dirección</button>
                                    </div>
                                    @if(count($lista_direcciones) > 0)
                                    <div class="tabla-dir-checkout" id="list_dom_sel">
                                        <!-- <div id="load-Entrega" class="mini-loader"></div> -->
                                        <div style="display:none;" id="load-Entrega" class="mini-loader">

                                        </div>
                                        <table class="tg">
                                            <thead>
                                                <tr>
                                                    <th class="tg-0lax" colspan="2">¿Quién recibe?</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="tg-0lax1">Nombre:</td>
                                                    <td class="tg-0lax2" id="nombre_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Telefono de contacto:</td>
                                                    <td class="tg-0lax2" id="telefono_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <th class="tg-0lax" colspan="2">Domicilio de la entrega</th>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Calle:</td>
                                                    <td class="tg-0lax2" id="calle_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">N. Exterior:</td>
                                                    <td class="tg-0lax2" id="num_ext_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Codigo postal:</td>
                                                    <td class="tg-0lax2" id="cp_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Entre calle 1</td>
                                                    <td class="tg-0lax2" id="entre_calle1_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Entre calle 2</td>
                                                    <td class="tg-0lax2" id="entre_calle2_dir_val"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Estado:</td>
                                                    <td class="tg-0lax2">TAMAULIPAS</td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Municipio:</td>
                                                    <td class="tg-0lax2" id="nom_municipio"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Ciudad:</td>
                                                    <td class="tg-0lax2" id="nom_ciudad"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Colonia:</td>
                                                    <td class="tg-0lax2" id="nom_colonia"></td>
                                                </tr>
                                                <tr>
                                                    <td class="tg-0lax1">Referencias:</td>
                                                    <td class="tg-0lax2" id="referencias_dir_val"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p class="info-adicional-Checkout">Recuerda que esta dirección sólo será utilizada para la entrega.</p>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            @endif
                            <div class="CarrCOMPStep" id="form_dir" style="display:none;">
                                <div class="mini-loader" style="display:none;" id="load-GuardaEntrega">

                                </div>
                                <div class="form-card">
                                    <h4>Datos de entrega</h4>
                                </div>
                                    <form id="form_check" class="container" autocomplete="off" style="">

                                        @if(auth()->user())
                                        <h6>Nombre para la dirección</h6>
                                        <div class="col-md-12">
                                            <div class="form-group tooltip2" id="inp_nom_dir">
                                                <input type="text" name="nombre_dir" class="form-control" id="nombre_dir"  required oninvalid="setCustomValidity(' ')">
                                                <label for="">Nombre de dirección</label>
                                            </div>
                                            <span class="inptValid nombre_dir" style="display:none;">Este campo es obligatorio</span>
                                        </div>
                                        @endif
                                        <h6>Información del cliente</h6>
                                        <!-- <div class=""> -->
                                        <div class="DomEntBASIC form-row">
                                            <!--Correo-->
                                            <div class="col-md-12">
                                                <div class="tooltip2 form-group">
                                                    <input type="text" name="nombre_dir_val"  class="form-control"  autocomplete="off"  id="nombre_dir_val" value="" required oninvalid="setCustomValidity(' ')">
                                                    <label for="">Nombre *</label>
                                                </div>
                                            <span class="inptValid nombre_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Paterno-->
                                            <div class="col-md-6">
                                                <div class="tooltip2 form-group">
                                                    <input type="text" name="paterno_dir_val"  value="" class="form-control"  autocomplete="off"  id="paterno_dir_val" required oninvalid="setCustomValidity(' ')">
                                                    <label for="">Apellido Paterno *</label>
                                                </div>
                                                <span class="inptValid paterno_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Materno-->
                                            <div class="col-md-6">
                                                <div class="tooltip2 form-group">
                                                    <input type="text" name="materno_dir_val" value="" class="form-control"  autocomplete="off"  id="materno_dir_val" required>
                                                    <label for="">Apellido Materno</label>
                                                </div>
                                                <span class="inptValid materno_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Telefono-->
                                            <div class="col-md-6">
                                                <div class="tooltip2 form-group">
                                                    <input type="number" name="telefono_dir_val"  value="" maxlength="9"  autocomplete="off" class="form-control" id="telefono_dir" required oninvalid="setCustomValidity(' ')">
                                                    <label for="">Telefono *</label>
                                                </div>
                                                <span class="inptValid telefono_dir" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!-- @if(!auth()->user()) -->
                                            <div class="col-md-6">
                                                <div class="tooltip2 form-group">
                                                    <input type="text" name="correo_dir_val"  value="" class="form-control"  autocomplete="off" id="correo_dir" required oninvalid="setCustomValidity(' ')">
                                                    <label for="">Correo *</label>
                                                </div>
                                                <span class="inptValid correo_dir_val" style="display:none;">Este campo es obligatorio</span>
                                                <span class="inptValid correo_invalid" style="display:none;">Ingrese un correo válido.</span>
                                            </div>
                                            <!-- @endif -->
                                        </div>
                                        <!-- </div> -->
                                        <div class="DomEntBASIC">
                                            <h6>Domicilio de entrega</h6>
                                            <div class="form-row">
                                                <!--Calle-->
                                                <div class="col-md-12">
                                                    <div class="tooltip2 form-group">
                                                        <input type="text" name="calle_dir" class="form-control" id="calle_dir_val"  autocomplete="off" required oninvalid="setCustomValidity(' ')">
                                                        <label for="">Calle *</label>
                                                    </div>
                                                    <span class="inptValid calle_dir_val" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <!--Numero Ext-->
                                                <div class="col-md-6">
                                                    <div class="tooltip2 form-group">
                                                        <input type="" name="num_ext_dir" class="form-control" id="num_ext_dir_val"  autocomplete="off" required oninvalid="setCustomValidity(' ')" >
                                                        <label for="">N. Exterior *</label>
                                                    </div>
                                                    <span class="inptValid num_ext_dir_val" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <!--Codigo postal-->
                                                <div class="col-md-6">
                                                    <div class="tooltip2 form-group">
                                                        <input type="number" name="cp_dir" class="form-control" minlength="4" maxlength="4" autocomplete="off"  id="cp_dir" required oninvalid="setCustomValidity(' ')">
                                                        <label for="">CP *</label>
                                                    </div>
                                                    <span class="inptValid cp_dir" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <!--entrecalle 1-->
                                                <div class="col-md-6">
                                                    <div class="tooltip2 form-group">
                                                        <input type="text" name="entre_calle1_dir" class="form-control" id="entre_calle1_dir_val"  autocomplete="off" required oninvalid="setCustomValidity(' ')">
                                                        <label for="">Entre Calle 1 *</label>
                                                    </div>
                                                    <span class="inptValid entre_calle1_dir_val" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <!--entrecalle 2-->
                                                <div class="col-md-6">
                                                    <div class="tooltip2 form-group">
                                                        <input type="text" name="entre_calle2_dir" class="form-control" id="entre_calle2_dir_val" autocomplete="off"  required oninvalid="setCustomValidity(' ')">
                                                        <label for="">Entre Calle 2 *</label>
                                                    </div>
                                                    <span class="inptValid entre_calle2_dir_val" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <!--Estado-->
                                                <div class="tooltip2 form-group col-md-4">
                                                    <input type="hidden" id="estado_select_dom" value="28" required oninvalid="setCustomValidity(' ')">
                                                    <input type="text" name="estado_dir" value="Tamaulipas" class="form-control" id="estado_dir_val" placeholder="Tamaulipas" disabled>
                                                    <span title="¿Vives en otro estado?, hablanos para cotizar el envio." data-toggle="tooltip" data-placement="top" class="fas fa-question-circle question-icon"></span>
                                                </div>

                                                <!--municipio-->
                                                <div class="col-md-4">
                                                    <div class="input-group tooltip2 mb-3" id="d_inp_mun">
                                                        <input type="hidden" id="municipio_select" name="municipio_select" required oninvalid="setCustomValidity(' ')">
                                                        <select class="custom-select" name="municipio_dir" class="form-control" id="sel_mun_dom" placeholder="municipio*">
                                                            <label for="">Municipio *</label>
                                                        </select>
                                                        </div>
                                                    <span class="inptValid municipio_select" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <!--Ciudad-->
                                                <div class="col-md-4">
                                                    <div class="input-group form-group tooltip2 mb-3" id="d_inp_ciud">
                                                        <input type="hidden" id="ciudad_select" name="ciudad_select" required oninvalid="setCustomValidity(' ')">
                                                        <select class="custom-select" name="ciudad_dir" class="form-control" id="sel_ciud_dom">
                                                            <option selected style="color:#757575;">Ciudad *</option>
                                                        </select>
                                                        <span class="loader-icon-2" style="display:none;" id="load-Ciudad"><i class="fas fa-spinner"></i></span>
                                                    </div>
                                                    <span class="inptValid ciudad_select" style="display:none;">Este campo es obligatorio.</span>
                                                </div>
                                                <!--Colonia-->
                                                <div class="col-md-5">
                                                    <div class="tooltip2 form-group" id="d_inp_col">
                                                        <input type="hidden" id="colonia_select" name="colonia_select" required oninvalid="setCustomValidity(' ')">
                                                        <input type="text" id="inp_col_search" name="colonia_dir" data class="form-control" list="Colonias" placeholder="Colonia *" />
                                                        <datalist id="Colonias"> </datalist>
                                                        <span class="loader-icon-2" style="display:none;" id="load-Colonia"><i class="fas fa-spinner"></i></span>
                                                    </div>
                                                    <span class="inptValid no-col" style="display:none;">No se encontraron colonias registradas de la ciudad seleccionada.</span>
                                                    <span class="inptValid colonia_select" style="display:none;">Es necesario seleccionar una colonia.</span>
                                                </div>
                                                <!--Referencias-->
                                                <div class="col-md-7">
                                                    <div class="tooltip2 form-group" id="d_inp_ref">
                                                        <input type="text" name="referencias_dir" class="form-control" id="referencias_dir_val" autocomplete="off"  required oninvalid="setCustomValidity(' ')">
                                                        <label for="">Referencias *</label>
                                                    </div>
                                                    <span class="inptValid referencias_dir_val" style="display:none;">Este campo es obligatorio</span>
                                                </div>
                                                <p>Recuerda que esta dirección sólo será utilizada para la entrega.</p>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 d-flex flex-row-reverse">
                                        </div>
                                        <button type="button" id="boton_dom_cancel" class="btn btn-secondary">Cancelar</button>
                                        @if(auth()->user())
                                        <button type="button" id="boton_dom_sub" onclick="validaDireccion(1)" class="btn btn-success">Guardar dirección</button>
                                        @else
                                        <button type="button" onclick="validaDireccion(0)" class="btn btn-success">Siguiente paso</button>
                                        @endif
                                    </form>
                                </div>
                        </div>
                        @if(auth()->user())
                            <button class="btn btn-primary" id="sig_step" onclick="validaDireccion(2)">Siguiente paso</button>
                        @endif
                    </div>
                    <!--datos de facturacion-->
                    <div id="datos-facturacion" class="content" role="tabpanel" aria-labelledby="Datos-Facturacion-part">
                        <div class="CarrCOMPStep">
                            <div class="form-card">
                                <h4 class="fs-title">Facturación</h4>
                            </div>
                            <div class="alert alert-warning" role="alert">
                                <p>¿Requieres una factura?</p>
                                @if(auth()->user())
                                    <p>Tu factura será enviada al correo asociado a esta cuenta.</p>
                                @else
                                    <p>Tu factura será enviada al correo proporcionado en el paso anterior.</p>
                                @endif
                            </div>

                            <div class="DomEntBASIC" id="requ_fact">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="form-check">
                                            <label><input type="checkbox" class="form-check-input" id="chk_fact" type="radio" onclick="fact_chk()" name="radio" value="">Requiero factura</label>
                                            <!-- <input type="checkbox" onclick="fact_chk()" class="form-check-input" id="chk_fact">
                                            <label class="form-check-label" for="exampleCheck1">Requiero factura</label> -->
                                        </div>
                                    </div>
                                    <div class="col-md-3 align-content-md-end">
                                        <div class="personas_rfc" id="tipo_persona_txt" style="visibility: hidden;">
                                            <span>Tipo de Persona:</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="DomEntBASIC" id="tipo_fact" style="display:none;">
                                <div class="form-check pad-top-btn">
                                    <div class="row">
                                    	<div class="col-md-6">
                                    		<button onclick="tipoFactura('M')" type="button" class="btn-block btn-fact-tipe btn-info pad-top-fact" name="button">Moral</button>
                                    	</div>
                                    	<div class="col-md-6">
                                    		<button onclick="tipoFactura('F')" class="btn-block btn-fact-tipe btn-info" name="button">Fisica</button>
                                    	</div>
                                    </div>
                                </div>
                            </div>
                            <div class="DomEntBASIC" id="frm_fact" style="display:none;">
                                <div class="form-row pad-top-btn">
                                    <div class="form-group col-md-12">
                                        <input type="text" onchange="buscaRFCInpt()"  autocomplete="off"  required autocomplete="off" id="rfc_cli">
                                        <span id="loader-rfc" style="visibility: hidden;" class="fas fa-spinner loader-icon rotating-lader-Rfc"></span>
                                        <span id="load-AprobadoRFC" style="visibility: hidden;" class="fas fa-check loader-icon check-green"></span>
                                        <label for="">RFC* </label>
                                    </div>
                                    <!-- <button type="button" class="btn btn-info" onclick="busca_frc()" name="button">Buscar</button> -->
                                </div>
                            </div>


                            <div class="DomEntBASIC" id="fact_register" style="display:none; margin-top:20px;">
                                <div class="form-row">
                                    <form id="form_fact" class="container" autocomplete="off">
                                        <div class="row">
                                            <!--RFC-->
                                            <input type="hidden" name="tipo_p" id="tipo_p">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="rfc" id="rfc_fact" autocomplete="off"  maxlength="13" minlength="12" required>
                                                    <label for="">RFC *</label>
                                                </div>
                                                <span class="inptValid rfc_fact" style="display:none;">Este campo es obligatorio.</span>
                                                <span class="inptValid rfc_val" style="display:none;">Este RFC no es válido, favor de verificarlo.</span>
                                            </div>
                                            <!--Nombre o razon social-->
                                            <div class="moral col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="razon_fact" autocomplete="off"  id="razon_fact">
                                                    <label for="">Razón social *</label>
                                                </div>
                                                <span class="inptValid razon_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <div class="fisica col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="nombres_fact" autocomplete="off"  id="nombres_fact">
                                                    <label for="">Nombre *</label>
                                                </div>
                                                <span class="inptValid nombres_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <div class="fisica col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="paterno_fact" autocomplete="off"  id="paterno_fact">
                                                    <label for="">Apellido Pat*</label>
                                                </div>
                                                <span class="inptValid paterno_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <div class="fisica col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="materno_fact"  autocomplete="off" id="materno_fact">
                                                    <label for="">Apellido Mat*</label>
                                                </div>
                                                <span class="inptValid materno_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                        <!--Calle-->
                                            <div class=" col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="calle_fact"  autocomplete="off" id="calle_fact" required>
                                                    <label for="">Calle*</label>
                                                </div>
                                                <span class="inptValid calle_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Numero Exterior-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="num_ext_fact" autocomplete="off"  id="num_ext_fact" required>
                                                    <label for="">N. Exterior *</label>
                                                </div>
                                                <span class="inptValid num_ext_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Numero Interior-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="num_int_fact" autocomplete="off"  id="num_int_fact" required>
                                                    <label for="">N. Interior </label>
                                                </div>
                                                <span class="inptValid num_int_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <!--Estado-->
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="estado_select_fact" id="estado_select_fact" required oninvalid="setCustomValidity(' ')">
                                                    <select class="custom-select" id="sel_estado_fact">
                                                    </select>
                                                </div>
                                                <span class="inptValid estado_select_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <!--municipio-->
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="municipio_select_fact" id="municipio_select_fact" required oninvalid="setCustomValidity(' ')">
                                                    <select class="custom-select" id="sel_mun_fact">
                                                        <option selected style="color:#757575;" >Municipio *</option>
                                                    </select>
                                                </div>
                                                <span class="inptValid municipio_select_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--ciudad-->
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <input type="hidden" name="ciudad_select_fact" id="ciudad_select_fact" required oninvalid="setCustomValidity(' ')">
                                                    <select class="custom-select" id="sel_ciudad_fact">
                                                        <option selected style="color:#757575;" >Ciudad *</option>
                                                    </select>
                                                </div>
                                                <span class="inptValid ciudad_select_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--colonia-->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="hidden" name="colonia_select_fact" id="colonia_select_fact" required oninvalid="setCustomValidity(' ')">
                                                    <input type="text" id="inpt_col_fact" data list="colonias_fact" placeholder="Colonia *" />
                                                    <datalist id="colonias_fact">
                                                    </datalist>
                                                </div>
                                                <span class="inptValid colonia_select_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Codigo postal-->
                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                    <input type="number" name="cp_fact" id="cp_fact"  autocomplete="off"  maxlength="4" minlength="4" required placeholder="CP"/>
                                                </div>
                                                <span class="inptValid cp_fact" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Uso del CFDI-->
                                            <div class="col-md-12">
                                                <div class="input-group mb-3">
                                                    <input type="hidden"  name="select_val_cfdi" id="select_val_cfdi" required oninvalid="setCustomValidity(' ')">
                                                    <select class="custom-select" name="select_uso_cfdi" id="select_uso_cfdi" required>
                                                        <option selected style="display:none; color:#757575;">Uso del CFDI *</option>
                                                    </select>
                                                </div>
                                                <span class="inptValid select_val_cfdi" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="form-group col-md-12">
                                        <small>Los campos con * son necesarios.</small>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="alert alert-warning" role="alert">

                            </div> -->
                        <div class="pad-top-btn">
                            <!-- <div class="alert alert-warning" role="alert">
                                <p class="text-center">Tienes hasta el último día del mes de tu compra para facturar.</p>
                            </div> -->
                            <button class="btn btn-primary" onclick="stepper1.previous()">Regresar</button>
                            <button class="btn btn-primary" id="sig_step_fact" onclick="validaFactura()">Siguiente paso</button>
                        </div>
                        </div>
                    </div>
                    <!--metodos de pago-->
                    <div id="Metodo-pago" class="content" role="tabpanel" aria-labelledby="metodo-pago-part">
                        <div class="mini-loader" style="display: none;" id="loader_boton"></div>
                        <div class="Payment-container">
                            <div class="form-card">
                                <h4 class="fs-title">Métodos de pago</h4>
                            </div>
                            <div class="row">
                                <!--pago por santander-->
                            	<div class="col-md-6">
                            		<button onclick="validaInf('wpp')" type="button" class="btn-block btn-sant icon-methodpay" name="button"><i class="fab fa-cc-visa"></i> <i class="fab fa-cc-mastercard"></i></br>Tarjetas de crédito o débito</button>
                            	</div>
                                <!--pago en tienda villarreal-->
                                <!-- <div class="col-md-6">
                                	<button type="button" class="btn-block btn-villa icon-methodpay" name="button">
                                		<span>
                                			<img src="{{ asset('img/icons/white-logo.png') }}" alt="Logo blanco" class="lazyload">
                                		</span>
                                		<br>
                                		Comprar en tienda
                                	</button>
                                </div> -->

                            	<!-- <div class="col-md-6">
                            		<button type="button" onclick="" class="btn-block btn-payp icon-methodpay" name="button"><i class="fab fa-paypal"></i></br>Paypal</button>
                            	</div> -->
                            </div>
                            <button class="btn btn-primary" onclick="stepper1.previous()">Regresar</button>
                        </div>
                    </div>
                    <!--Finalizar-->
                    <div id="Last-part" class="content" role="tabpanel" aria-labelledby="Last-finish-part">

                        @if($esPago)
                            @if($response == 'Aprobado')
                                <div class="last-step-cart">
                                    <picture>
                                        <center><img src="{{ asset('img/icons/2-aprobada.png') }}"></center>
                                    </picture>
                                    <h6> {{$mensaje}}</h6>
                                    <button type="button" onclick="finalizar()" class="btn btn-finish btn-success" name="button">Finalizar</button>
                                </div>

                            @elseif($response == 'Rechazado')
                                <div class="last-step-cart">
                                    <picture>
                                        <center><img src="{{ asset('img/icons/1-denegada.png') }}"></center>
                                    </picture>
                                    <h6> {{$mensaje}}</h6>
                                </div>
                            @elseif($response == 'Error')
                                <div class="last-step-cart">
                                    <picture>
                                        <center><img src="{{ asset('img/icons/0-error.png') }}"></center>
                                    </picture>
                                    <h6> {{$mensaje}}</h6>
                                </div>
                            @endif

                            <input type="hidden" id="response" value="{{ $response }}">
                            <input type="hidden" id="msg" value="{{ $mensaje }}">
                        @endif

                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-4 col-lg-4 col-md-5">

            <div class="CarrCOMP pad-top-134">

                <h4>Resumen de compra</h4>
                <!--
                <table class="resumen-Checkout">
                    <tbody>
                        <tr class="title-prod-checkout">
                            <td>Prod.</td>
                            <td class="text-center">Cant.</td>
                            <td class="text-right">Total</td>
                        </tr>
                        <tr class="prod-resume-checkout">
                            <td>Recamara ks de color negra con remaches</td>
                            <td class="text-center">x3</td>
                            <td class="text-right">$4,949.00</td>
                        </tr>
                    </tbody>
                </table> -->

                <div class="ResCOM">
                    <!-- <div id="load-Totales" class="mini-loader"></div> -->
                    <table>
                        <div class="mini-loader" style="display:none" id="load-Totales">
                        <tbody>
                            <tr class="Csub">
                                <td>Subtotal:</td>
                                <td class="text-right" id="subtotal_chk">$0.00</td>
                            </tr>
                            <tr class="CIVA">
                                <td>IVA:</td>
                                <td class="text-right" id="iva_chk">$0.00</td>
                            </tr>
                            <tr class="Csub2">
                                <td>Gastos de envio:</td>
                                <td class="text-right" id="envio_chk">$0.00</td>
                            </tr>
                            <tr class="CTot">
                                <td>Total de contado:</td>
                                <td class="text-right " id="total_chk">$0.00</td>
                            </tr>
                        </tbody>
                    </table>
                    <p>*La fecha estimada de entrega puede variar debido a la disponibilidad de los productos, al domicilio de entrega y a la forma de pago.</p>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
</div>
<!-- <p onclick="send_email()">..</p> -->

<template id="tienda-template">
    <!-- <swal-icon type="warning" color="red"></swal-icon> -->
    <swal-title>
        ¿Deseas hacer tu compra a credito o de contado?
    </swal-title>
    <swal-button type="confirm">
        Credito
    </swal-button>
    <swal-button type="deny">
        Contado
    </swal-button>
    <!-- <swal-button type="cancel">
    Cancel
    </swal-button> -->
    <swal-param name="allowEscapeKey" value="false" />
    <swal-param
    name="customClass"
    value='{ "popup": "my-popup" }' />
</template>


@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{ asset('js/checkout/metodo_pago.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/checkout/facturacion.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/checkout/direccion_entrega.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/serializeToJSON.min.js') }}"></script>

<script type="text/javascript">
var precio_flete = 0;
var subtotal = 0;
var iva_venta = 0;
/*------*/
var total_cont = 0;
var pasa_envio = false;
var pasa_form = false;
var requ_fact = false;
var pasa_fact = false;
var tipo_fact = false;
var pasa_rfc = false;
var newDir = false;

var total_carrito = 0;
/*-----*/
var tipo = '';
var cont_valid = 0;
var actOrden = false;
var id_cliente = 0;
var tieneRFC = false;
var cont_direcciones = $("#cont_lista_direcciones").val();
const formatPesos = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD'
});

getMunicipio(28);



function finalizar(){
    window.location.href = '/';
}


$(document).ready(function() {
    isCarrito = localStorage.getItem('carrito');
    var pas = false;
    // console.log($("#esPago").val(), $("#response").val() == 'Aprobado');
    if($("#esPago").val()){
        if($("#response").val() == 'Aprobado'){
            id_carr = localStorage.getItem('ic');
            // compra_finalizada();
            localStorage.removeItem('carrito');
            localStorage.removeItem('art');
            totalesHeader();
            stepper1.next();
            stepper1.next();
            stepper1.next();
            localStorage.removeItem('cguard');
            localStorage.removeItem('ic');

        }else{
            // $("#load-Entrega").show();
            // $("#load-Totales").show();
            localStorage.removeItem('cguard');
            validaAuthCarrito();
            Swal.fire({
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                icon: 'error',
                text: $("#msg").val(),

            }).then((result) => {
                ObtCart();
                // $("#load-Entrega").hide();
                // $("#load-Totales").hide();
            })
        }
    }else{
        ObtCart();
    }
});


function ObtCart(){
    if(isCarrito && (!$("#esPago").val() || $("#response").val() != 'Aprobado')){
        var nom_acc_h3 = ucFirstAllWords(nom_acc);
        $("#acc_bienv_nom").text(nom_acc_h3);

        $("#boton_dom_cancel").hide();
        var isAuth = $("#isAuth").val();
        // getFolio();

        if($("#isAuth").val() === 'false'){

            $("#form_dir").show();
            $("#sig_step").attr('disabled', true);
            getTotalFinal(0, false);
        }else{
            $("#form_dir").hide();
            if ($("#cont_lista_direcciones").val() > 0) {
                $("#sig_step").attr('disabled', false);
                getInfDir();
            } else {
                $("#sig_step").attr('disabled', true);
            }
        }

        $("#frm_fact").hide();
    }else{

        Swal.fire({
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            icon: 'warning',
            text: 'No se encontraron artículos en el carrito. Agregue artículos a su carrito para realizar una compra.',
        }).then((result) => {
            window.location.href = '/';
        })


    }
}

function send_email(){
    var tipo_venta = false;
    Swal.fire({
        template: '#tienda-template',
        text: 'Visitanos en tu sucursal mas cercana, con una impresion del correo electronico que te haremos llegar',
        denyButtonColor: '#003987',
        confirmButtonColor: '#003987',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,

    }).then((value) => {
        Swal.fire({
            title: 'Revisa tu correo',
            text: 'En breves te llegará un correo, revisa tu bandeja de entrada, promociones o tu carpeta de spam.',
        })

        // Crédito = true
        // Contado = false
        if(value['value']){
            tipo_venta = true;
        }else{
            tipo_venta = false;
        }

        var isAuth = $("#isAuth").val();
        var email = '';
        if(isAuth != 'false'){
            email = $("#email_ticket").val();
        }else{
            email = $("#correo_dir").val();
        }

        listaCarrito = JSON.parse(localStorage.getItem('carrito'));
        id_carrito = JSON.parse(localStorage.getItem('ic'));

        $.ajax({
    		url: '/enviaCorreo',
    		dataType: 'json',
            data:{
                'email': email,
                'id_carrito':id_carrito,
                'carrito': listaCarrito,
                'tipo_venta': tipo_venta
            },
    		success: function (respuesta) {




    		}
    	});

    });

    return false;

}


var isSelected = false;
var stepper1Node = document.querySelector('#stepper1')
var stepper1 = new Stepper(document.querySelector('#stepper1'))

stepper1Node.addEventListener('show.bs-stepper', function(event) {
    // console.warn('show.bs-stepper', event)
})
stepper1Node.addEventListener('shown.bs-stepper', function(event) {
    // console.warn('shown.bs-stepper', event)
})




function getUrlPayPal(){
    window.open('https://pruebasweb.muebleria-villarreal.com/paypal/pay', '_blank');
}

// function getFolio(){
//     var isAuth = $("#isAuth").val();
//     var folio = localStorage.getItem('fol');
//     console.log(folio === null || folio === undefined || folio != '');
//     if(folio === null || folio === undefined){
//         console.log($("#isAuth").val());
//         if($("#isAuth").val() === 'false'){
//             $.ajax('/setCarrito', {
//                 type: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//                 },
//                 data:{
//                     'carrito': JSON.parse(localStorage.getItem('carrito'))
//                 },
//                 success: function (data) {
//                     if(data){
//                         folio = data.folio;
//                         id_carrito = data.id_carrito;
//                         localStorage.setItem('fol', folio);
//                         localStorage.setItem('ic', id_carrito);
//                         localStorage.setItem('cguard', true);
//                     }else{
//
//                     }
//                 },
//                 error: function () {
//                 }
//             });
//         }else {
//             $.ajax('/getFolio', {
//                 type: 'GET',
//                 success: function (data) {
//                     if(data){
//                         folio = data.folio;
//                         localStorage.setItem('fol', folio);
//                     }
//                 },
//                 error: function () {
//                 }
//             });
//         }
//     }else{
//         $.ajax('/actCarritoF', {
//             type: 'POST',
//             headers: {
//                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//             },
//             data:{
//                 'carrito': JSON.parse(localStorage.getItem('carrito')),
//                 'folio': folio
//             },
//             success: function (data) {
//                 if(data){
//                 }
//             },
//             error: function () {
//             }
//         });
//     }
//
//     // $.ajax('/getFolio', {
//     //     type: 'GET',
//     //     success: function (data) {
//     //         if(data){
//     //             folio = data.folio;
//     //             localStorage.setItem('fol', folio);
//     //         }
//     //     },
//     //     error: function () {
//     //     }
//     // });
//
//
// }

</script>
@endsection
