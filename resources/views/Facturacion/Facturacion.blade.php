@extends('Shared/Layout')
@section('titulo')
- Facturacion
@endsection
@section('seccion')

<div class="container">
    <div class="cliente-box-Facturacion">
        <div class="row justify-content-between">
            <div class="col-md-8">
                <h5>Bienvenido al Servicio de Facturación Electrónica de Muebleira Villarreal Caballero, S.A. de C.V.</h5>
                <h6>Factura compra FW-blabla</h6>

                <div class="DomEntBASIC" id="requ_fact">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-check">
                            </div>
                        </div>
                        <div class="col-md-3 align-content-md-end">
                            <div class="personas_rfc" id="tipo_persona_txt" style="visibility: hidden;">
                                <span>Tipo de Persona:</span>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="DomEntBASIC">
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
                        <div class="form-group col-md-12 input-group">
                            <input type="text" class="form-control"  autocomplete="off"  required autocomplete="off" id="rfc_cli">
                            <span id="loader-rfc" style="visibility: hidden;" class="fas fa-spinner loader-icon rotating-lader-Rfc"></span>
                            <span id="load-AprobadoRFC" style="visibility: hidden;" class="fas fa-check loader-icon check-green"></span>
                            <label class="label_rfcCSS" for="">RFC* </label>
                            <button class="btn btn-outline-secondary" onclick="buscaRFCInpt()" type="button" id="rfc_cli"><i class="fas fa-search"></i></button>
                        </div>
                        <span class="inptValid rfc_fact" style="display:none;" id="span_rfc">Ingresa tu RFC completo.</span>
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
                    <div class="pad-top-btn">
                        <button class="btn btn-primary" id="sig_step_fact" onclick="validaFactura()">Facturar</button>
                    </div>
                </div>


            </div>
            <div class="col-md-3">
                <h5>Ayuda</h5>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
<script type="text/javascript" src="{{ asset('js/facturacion/facturacion.js') }}"></script>

@endsection
