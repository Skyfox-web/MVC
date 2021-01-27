@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- Clientes
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')




<div class="container">
    <div class="row">
        <div class="col-md-12 Pag-cli">
            <div class="cliente-box">
                <input type="hidden" id="nom_acc" value="">
                <p id="auth_bienv_nom" style="display:none">
                    @if(auth()->user())
                        @if(auth()->user()->nombre)
                            {{auth()->user()->nombre }} {{ auth()->user()->paterno}}
                        @else
                            {{auth()->user()->nombre_completo }}
                        @endif
                    @endif
                </p>
                <h3 id="acc_bienv_nom"></h3>
                @if(auth()->user())
                    <h5 class="usr_mail">Correo electrónico: {{ $email }}</h5>
                    <!-- <h6 class="usr_id">Número de cliente: {{ $num_cliente }}</h6> -->

                @endif
                <button type="button" class="btn btn-success" name="button" onclick="compra_finalizada(0)">Enviar Email</button>
                <ul class="nav nav-tabs nav-top" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="contact-tab" data-toggle="tab" href="#Dom-entregas" role="tab" aria-controls="contact" aria-selected="false">Domicilios de entrega</a>
                    </li>
                    <!--<li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#EstadoDeCuenta" role="tab" aria-controls="profile" aria-selected="false">Estado de pedidos</a>
                    </li>-->
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#Historial" role="tab" aria-controls="contact" aria-selected="false">Historial</a>
                    </li>

                </ul>

                <!--Domicilios de entrega-->

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade row show active" id="Dom-entregas" role="tabpanel" aria-labelledby="home-tab">

                        <input type="hidden" id="cont_lista_direcciones" value="{{ count($lista_direcciones)}}">
                        @if(count($lista_direcciones) == 0)
                        <div class="col-md-12 Carr-1 Historial-title" id="direcciones_vacio">
                            <h4>Mis direcciones</h4>
                            <h4 class="text-center">Tu lista de direcciones está vacía</h4>
                            <p class="text-center">Agrega una nueva dirección para facilitar tus procesos de compras.</p>
                            <div class="btn-midle-car">
                                <button type="button" class="btn btn-success" name="button" id="frstDom">Agregar dirección</button>
                            </div>
                        </div>

                        @endif



                        <!--direcciones guardadas-->


                        <!--parte superior boton y direcciones guardadas-->
                        <!--Agregar una nueva direccion-->
                        <!--quien recibe el pedido-->

                        <form id="frm_gp" class="needs-validation container" novalidate autocomplete="off" style="display:none;">
                            <div class="alert" id="direccion_agregada" style="display: none;" role="alert">
                            </div>
                            <input type="hidden" id="tipoOperacion" value="1">
                            @csrf

                            <div class="col-lx-6 col-lg-7 col-md-8 infClien2">
                                <h4 id="nombre_vista_dir">Tus direcciones guardadas:</h4>

                                <div class="input-group">
                                    <div class="" id="div_agg_dom" style="display:flex">
                                        <div class="">
                                            <select class="custom-select" onchange="getInfDir()" id="inputGroupSelect01">
                                                @if(!$lista_direcciones)
                                                    <input type="hidden" name="" value="">
                                                    <option value="principal" class="custom-select">Principal</option>
                                                @endif
                                                @foreach($lista_direcciones as $key => $direccion)
                                                    <option class="custom-select" onselect='getInfDir({{ $direccion['id_direccion']}})' value='{{ $direccion['id_direccion']}}'>{{ $direccion['nombre_direccion'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="new-dir-btn">
                                            <button id="newDIR" class="btn btn-primary" type="button" name="button">Agregar nuevo domicilio</button>
                                        </div>
                                    </div>
                                    <div class=" col-md-12">
                                        <div class="Dom-entrega form-group" id="inp_nom_dir" style="display:none">
                                            <input type="text" name="nombre_dir" class="form-control" id="nombre_dir" value="Principal" required>
                                            <label for="">Nombre de la dirección*</label>
                                        </div>
                                        <span class="inptValid nombre_dir" style="display:none;">Este campo es obligatorio</span>
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-md-center clearfix" style="">
                                <!-- <input type="text" name="vista" class="form-control" id="vista_prov" value="" > -->
                                <div class="col-xl-3 col-lg-4 col-md-5">
                                    <div class="DomEntBASIC">
                                        <h4 class="subtitle-account">Quien recibe el pedido</h4>
                                        <div class="form-row">

                                            <!--NOMBRE-->
                                            <div class=" col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="nombre_dir_val" class="form-control" id="nombre_dir_val" value="" required>
                                                    <label for="">Nombre*</label>
                                                </div>
                                                <span class="inptValid nombre_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <!--Paterno-->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="paterno_dir_val" value="" class="form-control" id="paterno_dir_val" required>
                                                    <label for="">Apellido Pat*</label>
                                                </div>
                                                <span class="inptValid paterno_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Materno-->
                                            <div class=" col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="materno_dir_val" value="" class="form-control" id="materno_dir_val" required>
                                                    <label for="">Apellido Mat*</label>
                                                </div>
                                                <span class="inptValid materno_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Telefono-->
                                            <div class="col-md-12">
                                                <div class="form-group ">
                                                    <input type="number" name="telefono_dir_val" value="" maxlength="10" class="form-control" id="telefono_dir_val" required>
                                                    <label for="">Telefono*</label>
                                                </div>
                                                <span class="inptValid telefono_dir" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <p class="info-adicional-client">Esta informacion es para contactar al momento de la entrega.</p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="DomEntBASIC">
                                        <h4 class="subtitle-account">Domicilio de entrega</h4>
                                        <div class="form-row">
                                            <!--Calle-->
                                            <div class=" col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="calle_dir" value="" class="form-control" id="calle_dir_val" required>
                                                    <label for="">Calle *</label>
                                                </div>
                                                <span class="inptValid calle_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Numero Ext-->
                                            <div class=" col-md-6">
                                                <div class="form-group">
                                                    <input type="" name="num_ext_dir" value="" class="form-control" id="num_ext_dir_val" required>
                                                    <label for="">N. exterior *</label>
                                                </div>
                                                <span class="inptValid num_ext_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Numero Int-->
                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="" name="num_int_dir" value="" class="form-control" id="num_int_dir_val" required>
                                                    <label for="">N. Interior *</label>
                                                </div>
                                                <span class="inptValid num_int_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div> -->

                                            <!--Codigo postal-->
                                            <div class="col-md-6">
                                                <div class="form-group ">
                                                    <input type="number" name="cp_dir" value="" class="form-control" minlength="4" maxlength="5" id="cp_dir_val" required>
                                                    <label for="">CP *</label>
                                                </div>
                                                <span class="inptValid cp_dir" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <!--entrecalle 1-->
                                            <div class=" col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="entre_calle1_dir" value="" class="form-control" id="entre_calle1_dir_val" required>
                                                    <label for="">Entre calle 1 *</label>
                                                </div>
                                                <span class="inptValid entre_calle1_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--entrecalle 2-->
                                            <div class=" col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="entre_calle2_dir" value="" class="form-control" id="entre_calle2_dir_val" required>
                                                    <label for="">Entre calle 2 *</label>
                                                </div>
                                                <span class="inptValid entre_calle2_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>
                                            <!--Estado-->
                                            <div class="form-group col-md-4">
                                                <input type="hidden" id="estado_select_dom" value="28">
                                                <input type="text" name="estado_dir" value="Tamaulipas" class="form-control" id="estado_dir_val" required placeholder="Tamaulipas" disabled>
                                                <span title="¿Vives en otro estado?, hablanos para cotizar el envio." data-toggle="tooltip" data-placement="top" class="fas fa-question-circle question-icon"></span>

                                            </div>

                                            <!--municipio-->
                                            <div class=" col-md-4">
                                                <input type="hidden" id="municipio_select" value="">
                                                <div class="input-group mb-3" id="d_inp_mun">
                                                    <select class="custom-select" name="municipio_dir" class="form-control" required id="sel_mun_dom" placeholder="municipio*">
                                                    </select>
                                                </div>
                                                <span class="inptValid municipio_select" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <!--Ciudad-->
                                            <div class=" col-md-4">
                                                <div class="input-group mb-3" id="d_inp_ciud">
                                                    <input type="hidden" id="ciudad_select" value="">
                                                    <select class="custom-select" name="ciudad_dir" class="form-control" required id="sel_ciud_dom">
                                                        <option selected style="color:#757575;">Ciudad *</option>
                                                    </select>
                                                    <span class="loader-icon-2" style="display:none;" id="load-Ciudad"><i class="fas fa-spinner"></i></span>
                                                </div>
                                                <span class="inptValid ciudad_select" style="display:none;">Este campo es obligatorio.</span>
                                            </div>

                                            <!--Colonia-->
                                            <div class="col-md-4">
                                                <div class="form-group " id="d_inp_col">
                                                    <input type="hidden" id="colonia_select" value="">
                                                    <input type="text" id="inp_col_search" name="colonia_dir" class="form-control" placeholder="Colonia*" required list="Colonias" />
                                                    <datalist id="Colonias"> </datalist>
                                                    <span class="loader-icon-2" style="display:none;" id="load-Colonia"><i class="fas fa-spinner"></i></span>
                                                </div>
                                                <span class="inptValid colonia_select" style="display:none;">Es necesario seleccionar una colonia.</span>
                                            </div>



                                            <!--Referencias-->
                                            <div class="col-md-8">
                                                <div class="form-group " id="d_inp_ref">
                                                    <input type="text" name="referencias_dir" value="" class="form-control" id="referencias_dir_val" required>
                                                    <label for="">Referencias, ¿Que se encuentra cerca? *</label>
                                                </div>
                                                <span class="inptValid referencias_dir_val" style="display:none;">Este campo es obligatorio</span>
                                            </div>

                                            <!--boton de guardado-->
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 d-flex flex-row-reverse">
                                        <button type="submit" id="boton_dom_sub" onclick="" class="btn btn-success">Guardar dirección</button>
                                        <button type="button" id="boton_dom_cancel" class="btn btn-secondary">Cancelar</button>
                                        <button type="button" id="boton_dom_delete" class="btn btn-danger">Eliminar</button>
                                    </div>
                                    <small style="color:red;">Los campos con * son necesarios.</small>
                                    <p class="info-adicional-client">Si quieres modificar una direccion de reparto solo cambia los campos necesarios y da click en "guardar dirección" y listo, tu direccion esta actualizada.</p>
                                </div>
                            </div>

                        </form>

                    </div>
                    <!--historial-->

                    <div class="tab-pane fade" id="Historial" role="tabpanel" aria-labelledby="contact-tab">
                        @if(!$isOrden)
                        <div class="row">
                            <div class="col-md-12 Carr-1 Historial-title">
                                <h4>Mis compras</h4>
                                <h4 class="text-center">Tu historial está vacio.</h4>
                                <p class="text-center">Navega en muebleria-villarreal.com y agrega los productos que buscas.</p>
                                <div class="btn-midle-car">
                                    <a class="btn btn-primary" type="button" name="button" href="{{ url('') }}">Seguir comprando</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <input type="hidden" id="historial" value="{{$datos_historial}}">
                        <div class="row" id="historial_comp">
                            <div class="col-md-12">
                                <div class="Historial-title">
                                    <h4>Mis compras</h4>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')


<script type="text/javascript" src="{{ asset('js/direcciones/direccion_ajax.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/direcciones/validacion_direccion.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/general.js') }}"></script>

<script>
    // $("#d_inp_ciud").hide();
    // $("#d_inp_col").hide();
    // $("#d_inp_ref").hide();
    var ban = false;
    var tieneDireccion = true;
    getMunicipio(28);

    function compra_finalizada(id_carr){
        console.log('compra finalizada');
        sendinblue.track(
          'Checkout',
          {
            "nombre": "Prueba"
          },
          {
            "id": "cart"+id_carr,
            "params": {
              "products": [
                {
                  "id": 1234,
                  "name": "a",
                  "amount": 1,
                  "price": 220
                },
                {
                  "id": 5768,
                  "name": "b",
                  "amount": 5,
                  "price": 1058
                }
              ]
            }
          },
        );
    }

    $("#frstDom").on('click', function(){
        $("#frm_gp").show();
        $("#frstDom").hide();
        $("#boton_dom_cancel").show();
        $("#boton_dom_delete").hide();
        $("#div_agg_dom").hide();
        tieneDireccion = false;
        $("#direcciones_vacio").hide();
        $("#nombre_vista_dir").html('Nueva dirección');
    });

    $(".order-histo").click(function(){
        $(this).next(".Detalles-Compra").slideToggle();
        $('.line-left-Closed').toggleClass('line-left-Open', 1000);
    });

    function despHisto(id_orden){
        $('#ord'+id_orden).next(".Detalles-Compra").slideToggle();
        $('#det'+id_orden).toggleClass('line-left-Open', 1000);
        $('#ord'+id_orden).toggleClass('line-left-Open', 1000);
    }

    function agregaHistorial(){
        historial = JSON.parse($("#historial").val());

        for (var i = 0; i < historial.length; i++) {
            var datos_orden = historial[i]["datos_orden"];
            var datos_articulos = datos_orden['articulos'];


            html_historial = '<div class="col-md-12">'
                +'<div class="order-histo line-left-Closed" id="ord'+i+'" onclick="despHisto('+i+')">'
                    +'<div class="row">'
                        +'<div class="col-md-6">'
                            +'<div class="order-detail">'
                                +'<h5 class="title-detail-tlt">Orden de Venta</h5>'
                                +'<h6 class="subtitle-detail-tlt">FW - ' + datos_orden["folio_factura"] + '</h6>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-5">'
                            +'<div class="order-detail">'
                                +'<h5 class="title-detail-tlt">' + datos_orden["fecha_venta"] + '</h5>'
                                +'<h6 class="subtitle-detail-tlt">$' + datos_orden["total_venta"] + '</h6>'
                            +'</div>'
                        +'</div>'
                        +'<div class="col-md-1">'
                            +'<div class="icon-detail">'
                                +'<i class="fas fa-chevron-down"></i>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                +'</div>'
                +'<div class="Detalles-Compra line-left-Closed" id="det'+i+'">'
                    +'<div class="row justify-content-md-center">'
                        +'<div class="col-md-12">'
                            +'<div class="all-detailss">'
                                +'<div class="payment-detail">'
                                    +'<h5>Método de pago</h5>'
                                    +'<h6>' + datos_orden["forma_pago"] + ' **** **** **** ' + datos_orden["ultimos_digitos"] + '</h6>'
                                +'</div>';

                                for (var j = 0; j < datos_articulos.length; j++) {
                                    html_historial += '<div class="arts-detail">'
                                        +'<div class="row">'
                                            +'<div class="col-md-4">'
                                                +'<picture>'
                                                    +'<img class="img-fluid" src="{{asset("articulos_img/")}}/'+datos_articulos[j].departamento+'/'+datos_articulos[j].id_articulo +'.jpg">'
                                                +'</picture>'
                                            +'</div>'
                                            +'<div class="col-md-4">'
                                                +'<h4>' + datos_articulos[j].descripcion_art + '</h4>'
                                                +'<h6>$' + datos_articulos[j].precio_unitario + '</h6>'
                                                +'<table style="width:50%; margin-bottom:20px;">'
                                                    +'<tr>'
                                                        +'<td>Cod:</td>'
                                                        +'<td>' + datos_articulos[j].id_articulo + '</td>'
                                                    +'</tr>'
                                                    +'<tr>'
                                                        +'<td>Piezas:</td>'
                                                        +'<td>' + datos_articulos[j].cant + '</td>'
                                                    +'</tr>'
                                                    +'<tr>'
                                                        +'<td>total:</td>'
                                                        +'<td>$' + datos_articulos[j].total + '</td>'
                                                    +'</tr>'
                                                +'</table>'
                                            +'</div>'

                                        +'</div>'
                                    +'</div>';
                                }




                                html_historial += '<div class="dir-envio">'
                                    +'<h5>Dirección de envío</h5>'
                                    +'<h6>' + datos_orden["persona_recibe"] + '</h6>'
                                    +'<p style="margin: 0; font-weight: bold;">' + datos_orden["telefono"] + '</p>'
                                    +'<p>' + datos_orden["direccion"] + '</p>'
                                +'</div>'
                                +'<div class="row justify-content-end">'
                                    +'<div class="col-md-4">'
                                        +'<table class="total-pago">'
                                            +'<tbody>'
                                                +'<tr class="P">'
                                                    +'<td>Subtotal:</td>'
                                                    +'<td class="text-right">$' + datos_orden["subtotal_venta"] + '</td>'
                                                +'</tr>'
                                                +'<tr class="PCIVA">'
                                                    +'<td>IVA:</td>'
                                                    +'<td class="text-right ">$' + datos_orden["iva_venta"] + '</td>'
                                                +'</tr>'
                                                +'<tr class="PCsub2">'
                                                    +'<td>Gastos de envio:</td>'
                                                    +'<td class="text-right">$' + datos_orden["precio_flete"] + '</td>'
                                                +'</tr>'
                                                +'<tr class="PCTot">'
                                                    +'<td>Total de contado:</td>'
                                                    +'<td class="text-right ">$' + datos_orden["total_venta"] + '</td>'
                                                +'</tr>'
                                            +'</tbody>'
                                        +'</table>'

                                    +'</div>'

                                +'</div>'
                            +'</div>'
                        +'</div>'
                    +'</div>'
                +'</div>'
            +'</div>';


            $("#historial_comp").append(html_historial);
            html_historial = '';
        }

    }

    $("#boton_dom_cancel").click(function(event) {
        $("#frm_gp")[0].reset();
        $('#nombre_dir').val('Principal');
        $("#boton_dom_delete").show();
        // $("#d_inp_ciud").hide();
        // $("#d_inp_col").hide();
        // $("#d_inp_ref").hide();
        getInfDir();
    });

    $("#newDIR").click(function(event) {
        $("#frm_gp")[0].reset();
        $('#nombre_dir').val('');
        // $("#d_inp_ciud").hide();
        $("#boton_dom_delete").hide();
        // $("#d_inp_col").hide();
        // $("#d_inp_ref").hide();
    });

    function getInfDir(){

        id_direccion = $("#inputGroupSelect01").val();

        $("#frm_gp").removeClass('was-validated');
        $.ajax('/getDireccionEsp/'+id_direccion, {
            type: 'GET',
            success: function (data) {
                $("#nombre_dir").val(data.nombre_direccion);
                $("#nombre_dir_val").val(data.nombre_contacto);
                $("#paterno_dir_val").val(data.paterno);
                $("#materno_dir_val").val(data.materno);
                $("#telefono_dir_val").val(data.telefono);
                $("#calle_dir_val").val(data.calle);
                $("#num_ext_dir_val").val(data.num_ext);
                $("#num_int_dir_val").val(data.num_int);
                $("#cp_dir_val").val(data.cp);
                $("#entre_calle1_dir_val").val(data.entre_calle);
                $("#entre_calle2_dir_val").val(data.y_calle);
                let sel_mun_dom = document.getElementById('sel_mun_dom');
                sel_mun_dom.value = data.municipio;
                $("#municipio_select").val(data.municipio);
                $("#ciudad_select").val(data.ciudad);
                $("#colonia_select").val(data.colonia);
                // console.log($("#colonia_select").val());
                // console.log(data.colonia);
                getCiudad(28, data.municipio);
                $("#referencias_dir_val").val(data.referencias);
            },
            error: function () {
            }
        });
    }

    $("#boton_dom_cancel").on('click',function(){
        $("#boton_dom_cancel").hide();
        $("#boton_dom_delete").show();
        $('#nombre_dir').val('Principal');
        $("#inp_nom_dir").hide();
        if(!tieneDireccion){
            $("#frstDom").show();
            $("#direcciones_vacio").show();
            $("#frm_gp").hide();
        }else{
            $("#nombre_vista_dir").html('Mis direcciones');
            $("#div_agg_dom").show();
        }
    });

    $(document).ready(function(){
        // $("#boton_dom_cancel").show();
        $("#boton_dom_cancel").hide();
        var nom_acc_h3 = ucFirstAllWords(nom_acc);
        $("#acc_bienv_nom").text(nom_acc_h3);

        if($("#cont_lista_direcciones").val() > 0){
            $("#frm_gp").show();
            getInfDir();
        }
        agregaHistorial();

    });

    $("#boton_dom_delete").on('click', function(){
        id_direccion_del = $("#inputGroupSelect01").val();
        $.ajax({
            data: {
                'id_direccion': id_direccion_del
            },
            type: 'POST',
            url: '/delDir',
            headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'success',
                    text: 'La dirección se eliminó correctamente.',
                }).then((result) => {
                    window.location.href = '/kliemtheprubajeje';
                })

            }
        });


    });



</script>


@endsection
