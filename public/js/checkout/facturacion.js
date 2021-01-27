/* Validación factura */
function tipoFactura(tipo){ //F: Fisica. M: Moral
    tipo_fact = tipo;
    $("#tipo_p").val(tipo);
    if(tipo_fact == 'F'){
        document.getElementById('tipo_persona_txt').style.visibility = "visible";
        document.getElementById('tipo_persona_txt').textContent = "Persona Física";
        $("#rfc_cli").attr('maxLength', 13);
    }else{
        document.getElementById('tipo_persona_txt').style.visibility = "visible";
        document.getElementById('tipo_persona_txt').textContent = "Persona Moral";
        $("#rfc_cli").attr('maxLength', 12);
    }
    $('#frm_fact').show();
    $("#tipo_fact").hide();
}

function validaFactura() {
    if(requ_fact && !tieneRFC){
        var elements = document.getElementById("form_fact");
        if($('#chk_fact').prop('checked') ) {
            cont_valid = 0;
            $("#form_fact input").each(function() {
                var input = $(this);
                var id = $(this).attr('id');

                if (input.val() === '' && input.attr('required')) {
                    if (id === 'estado_select_fact') {
                        $(".estado_select_fact").show();
                    } else if (id === 'municipio_select_fact') {
                        $(".municipio_select_fact").show();
                    } else if (id === 'ciudad_select_fact') {
                        $(".ciudad_select_fact").show();
                    } else if (id === 'colonia_select_fact') {
                        $(".colonia_select_fact").show();
                    }else if(id === 'select_val_cfdi'){
                        $(".select_val_cfdi").show();
                    }else {
                        $("." + id).show();
                    }
                    cont_valid++;
                }else if(id == 'rfc_fact'){
                    input = document.getElementById('rfc_fact');
                    // console.log($(this).val());
                    estadoRFC = validarInput(input);
                    if(!estadoRFC){
                        console.log(estadoRFC + ' -');
                        $(".rfc_val").show();
                        pasa_rfc = false;
                    }else{
                        console.log(estadoRFC + ' +');
                        pasa_rfc = true;
                        $(".rfc_val").hide();
                    }
                }else{
                    $("." + id).hide();
                }
            });
            if (cont_valid > 0 || !pasa_rfc) {
                pasa_fact = false;
            } else {
                pasa_fact = true;
                if(localStorage.getItem('isClReg') == 'false'){
                    agregaClienteRFC();
                }else{
                    tieneRFC = true;
                    pasa_fact = true;
                    pasa_rfc = true;
                    stepper1.next();
                }

                //funcion agregar cliente

            }
        }else{
            stepper1.next();
        }
    }else if(requ_fact && tieneRFC && pasa_fact){
        stepper1.next();
    }else if(!requ_fact){
        pasa_fact = true;
        pasa_rfc = true;
        stepper1.next();
    }
}

function agregaClienteRFC(){
    // console.log($("#form_fact").serialize());

    form = JSON.stringify($("#form_fact").serialize());

    $.ajax({
        data: $("#form_fact").serialize(),
        type: 'POST',
        url: 'setClienteRFC',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // console.log(response);
            if(response['estado']){
                id_cliente = response['id_cliente'];
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'success',
                    text: 'Su información se registró correctamente.',
                }).then((result) => {
                    pasa_fact = true;
                    localStorage.setItem('isClReg', true);
                    stepper1.next();
                })
            }else{
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'error',
                    text: 'Ocurrió un problema al registrar sus datos, favor de revisar su información.',
                }).then((result) => {
                    localStorage.setItem('isClReg', false);
                    pasa_fact = false;
                })
            }

        }
    });
}

$("#form_fact input:required").on('keyup', function(e) {
    id = $(this).attr('id');
    if ($(this).val() === '') {
        $("." + id).show();
        cont_valid++;

        if(id === 'rfc_fact') $(".rfc_val").hide();
    } else {
        $("." + id).hide();
        cont_valid--;
    }
});

$("#nombres_fact").on('keyup', function(e) {
    if($(this).attr('required')){
        id = $(this).attr('id');
        if ($(this).val() === '') {
            $("." + id).show();
            cont_valid++;
        } else {
            $("." + id).hide();
            cont_valid--;
        }
    }
});

$("#paterno_fact").on('keyup', function(e) {
    if($(this).attr('required')){
        id = $(this).attr('id');
        if ($(this).val() === '') {
            $("." + id).show();
            cont_valid++;
        } else {
            $("." + id).hide();
            cont_valid--;
        }
    }
});

$("#materno_fact").on('keyup', function(e) {
    if($(this).attr('required')){
        id = $(this).attr('id');
        if ($(this).val() === '') {
            $("." + id).show();
            cont_valid++;
        } else {
            $("." + id).hide();
            cont_valid--;
        }
    }
});

$("#razon_fact").on('keyup', function(e) {
    if($(this).attr('required')){
        id = $(this).attr('id');
        if ($(this).val() === '') {
            $("." + id).show();
            cont_valid++;
        } else {
            $("." + id).hide();
            cont_valid--;
        }
    }
});

function fact_chk(){
    $("#rfc_cli").val('');
    $("#form_fact")[0].reset();

    // $("#loader-rfc").hide();
    document.getElementById('loader-rfc').style.visibility = "hidden";
    document.getElementById('load-AprobadoRFC').style.visibility = "hidden";


    if($('#chk_fact').prop('checked') ) {
        // $("#frm_fact").show();
        document.getElementById('tipo_persona_txt').style.visibility = "visible";
        document.getElementById('tipo_persona_txt').textContent = "Tipo de Persona:";
        $("#fact_register").hide();
        $("#tipo_fact").show();
        requ_fact = true;
    }else{
        document.getElementById('tipo_persona_txt').style.visibility = "hidden";
        $("#frm_fact").hide();
        $("#fact_register").hide();
        $("#tipo_fact").hide();
        requ_fact = false;
        localStorage.removeItem('isClReg');
    }
}

/* Valida RFC */

//Función para validar un RFC
// Devuelve el RFC sin espacios ni guiones si es correcto
// Devuelve false si es inválido
// (debe estar en mayúsculas, guiones y espacios intermedios opcionales)
function rfcValido(rfc, aceptarGenerico = true) {
    const re       = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
    var   validado = rfc.match(re);

    if (!validado)  //Coincide con el formato general del regex?
        return false;

    //Separar el dígito verificador del resto del RFC
    const digitoVerificador = validado.pop(),
          rfcSinDigito      = validado.slice(1).join(''),
          len               = rfcSinDigito.length,

    //Obtener el digito esperado
          diccionario       = "0123456789ABCDEFGHIJKLMN&OPQRSTUVWXYZ Ñ",
          indice            = len + 1;
    var   suma,
          digitoEsperado;

    if (len == 12) suma = 0
    else suma = 481; //Ajuste para persona moral

    for(var i=0; i<len; i++)
        suma += diccionario.indexOf(rfcSinDigito.charAt(i)) * (indice - i);
    digitoEsperado = 11 - suma % 11;
    if (digitoEsperado == 11) digitoEsperado = 0;
    else if (digitoEsperado == 10) digitoEsperado = "A";

    //El dígito verificador coincide con el esperado?
    // o es un RFC Genérico (ventas a público general)?
    if ((digitoVerificador != digitoEsperado)
     && (!aceptarGenerico || rfcSinDigito + digitoVerificador != "XAXX010101000"))
        return false;
    else if (!aceptarGenerico && rfcSinDigito + digitoVerificador == "XEXX010101000")
        return false;
    return rfcSinDigito + digitoVerificador;
}
//Handler para el evento cuando cambia el input
// -Lleva la RFC a mayúsculas para validarlo
// -Elimina los espacios que pueda tener antes o después
function validarInput(input) {
    var rfc         = input.value.trim().toUpperCase(),
        resultado   = document.getElementById("resultado"),
        valido;

    var rfcCorrecto = rfcValido(rfc);   // ⬅️ Acá se comprueba

    if (rfcCorrecto) {
        return true;
    } else {
        return false;
    }


}

/* Control factura */
$("#cp_fact").keypress(function() {
    if (this.value.length > this.maxLength)
        this.value = this.value.slice(0, this.maxLength);
});

$("#rfc_fact").change(function (){
    if (this.value.length > this.maxLength){
        this.value = this.value.slice(0, this.maxLength);
    }else{
        validRFC(this);
    }
});

$("#rfc_fact").keypress(function() {
    if (this.value.length > this.maxLength){
        this.value = this.value.slice(0, this.maxLength);
    }else if(this.value.length+1 >= this.maxLength-1){
        validRFC(this);
    }
});

function validRFC(val){
    estadoRFC = validarInput(val);
    if(!estadoRFC){
        console.log('hola');
        $(".rfc_val").show();
        pasa_rfc = false;
    }else{
        console.log('hide');
        pasa_rfc = true;
        $(".rfc_val").hide();
    }
}

$("#sel_estado_fact").on('change', function (event){
    $("#estado_select_fact").val($("#sel_estado_fact").val());
    $("#sel_mun_fact").html('<option selected style="display:none; color:#757575;" value="">Municipio *</option>');
    $("#municipio_select_fact").val('');
    getMunicipioF($("#sel_estado_fact").val());
    if($("#estado_select_fact").val() === ''){
        $(".estado_select_fact").show();

    }else{
        $(".estado_select_fact").hide();
    }

});

$("#sel_mun_fact").on('change', function (event){
    $("#municipio_select_fact").val($("#sel_mun_fact").val());
    $("#sel_ciudad_fact").html('<option selected style="display:none; color:#757575;" value="">Ciudad *</option>');
    $("#ciudad_select_fact").val('');
    getCiudadF($("#estado_select_fact").val(), $("#municipio_select_fact").val());
    if($("#municipio_select_fact").val() === ''){
        $(".municipio_select_fact").show();

    }else{
        $(".municipio_select_fact").hide();
    }
});

$("#sel_ciudad_fact").on('change', function (event){
    $("#ciudad_select_fact").val($("#sel_ciudad_fact").val());
    $("#colonia_select_fact").val('');
    $("#colonias_fact").html('');
    getColoniaF($("#estado_select_fact").val(), $("#municipio_select_fact").val(), $("#ciudad_select_fact").val());
    if($("#ciudad_select_fact").val() === ''){
        $(".ciudad_select_fact").show();

    }else{
        $(".ciudad_select_fact").hide();
    }

});

$("#select_uso_cfdi").on('change', function (event){
    $("#select_val_cfdi").val($("#select_uso_cfdi").val());
    if($("#select_val_cfdi").val() === ''){
        $(".select_val_cfdi").show();

    }else{
        $(".select_val_cfdi").hide();
    }
});

$("#inpt_col_fact").on('change', function (event){
    $("#colonia_select_fact").val($("#inpt_col_fact").prop("data-value"));

    if($("#colonia_select_fact").val() === ''){
        $(".colonia_select_fact").show();
    }else{
        $(".colonia_select_fact").hide();
    }

});

$("#inpt_col_fact").change(function(){

  var proName=$("#inpt_col_fact").val();
   var value = $('#colonias_fact option').filter(function() {
     return this.value == proName;
   }).data('value');
   var msg = value ? value : '';
   $("#colonia_select_fact").val(msg)

   if($("#colonia_select_fact").val() === ''){
       $(".colonia_select_fact").show();
   }else{
       $(".colonia_select_fact").hide();
   }
});


function buscaRFCInpt(){
    bus_rfc_inpt = document.getElementById('rfc_cli');
    document.getElementById('load-AprobadoRFC').style.visibility = "hidden";
    pasa_fact = false;
    console.log(bus_rfc_inpt.value.length, bus_rfc_inpt.maxLength);
    if(tipo_fact == 'F' && bus_rfc_inpt.value.length == bus_rfc_inpt.maxLength){
        busca_frc();
    }
    if(tipo_fact == 'M' && bus_rfc_inpt.value.length == bus_rfc_inpt.maxLength){
        busca_frc();
    }
}


/* Funciones Ajax */
function busca_frc(){
    var rfc = $("#rfc_cli").val() != '' ? $("#rfc_cli").val() : 'NOINGRESO';
    document.getElementById('loader-rfc').style.visibility = "visible";
    $.ajax('/getClienteRFC', {
        type: 'GET',
        data: {
            'rfc' : rfc
        },
        success: function (data) {
            document.getElementById('loader-rfc').style.visibility = "hidden";
            if(data.esCliente){
                // $("#load-AprobadoRFC").show();
                document.getElementById("load-AprobadoRFC").style.visibility = "visible";
                id_cliente = data.idCliente;
                // Swal.fire({
                //     allowOutsideClick: false,
                //     allowEscapeKey: false,
                //     allowEnterKey: false,
                //     icon: 'success',
                //     text: 'Sus datos se encontraron en el sistema, puede continuar al siguiente paso.' ,
                // }).then((result) => {
                //     pasa_fact = true;
                //     pasa_rfc = true;
                //     tieneRFC = true;
                // })
                console.log('aprobado');
                tieneRFC = true;
                pasa_fact = true;
                pasa_rfc = true;
                localStorage.setItem('isClReg', true);
                stepper1.next();
            }else{

                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'warning',
                    text: 'No se encontraron sus datos en el sistema, favor de ingresar su información de facturación.' ,
                }).then((result) => {
                    localStorage.setItem('isClReg', false);
                    $("#form_fact input").each(function() {
                        var input = $(this);
                        var id = $(this).attr('id');

                        if (input.val() === '' && input.attr('required')) {
                            if (id === 'estado_select_fact') {
                                $(".estado_select_fact").hide();
                            } else if (id === 'municipio_select_fact') {
                                $(".municipio_select_fact").hide();
                            } else if (id === 'ciudad_select_fact') {
                                $(".ciudad_select_fact").hide();
                            } else if (id === 'colonia_select_fact') {
                                $(".colonia_select_fact").hide();
                            }else if(id === 'select_val_cfdi'){
                                $(".select_val_cfdi").hide();
                            }else {
                                $("." + id).hide();
                            }
                        }
                    });


                    getEstado();
                    getCFDI();
                    if(tipo_fact === 'F'){
                        $(".fisica").show();
                        $(".moral").hide();

                        $("#razon_fact").attr('required', false);

                        $("#nombres_fact").attr('required', true);
                        $("#paterno_fact").attr('required', true);
                        $("#materno_fact").attr('required', true);
                    }else{
                        $(".moral").show();
                        $(".fisica").hide();

                        $("#razon_fact").attr('required', true);

                        $("#nombres_fact").attr('required', false);
                        $("#paterno_fact").attr('required', false);
                        $("#materno_fact").attr('required', false);
                    }
                    $("#fact_register").show();
                    tieneRFC = false;
                    pasa_rfc = false;
                    pasa_fact = false;
                    id_cliente = 0;
                    $("#frm_fact").hide();
                    $("#tipo_fact").hide();
                    $('html, body').animate({scrollTop:0}, 'slow');
                })

            }
        },
        error: function () {

        }
    });


}

function getCFDI(){
    $.ajax('/getCFDI', {
        type: 'GET',
        success: function(data) {
            var uso_cfdi_html = '<option selected style="display:none; color:#757575;" value="">Uso CFDI *</option>';
            for (var i = 0; i < data.uso_cfdi.length; i++) {
                uso_cfdi_html += '<option value="' + data.uso_cfdi[i].uso_cfdi + '">' + data.uso_cfdi[i].descripcion + '</option>'
            }

            $("#select_uso_cfdi").html(uso_cfdi_html);
        },
        error: function() {}
    });
}

function getEstado() {
    var estado = '';

    $.ajax('/getEstado', {
        type: 'GET',
        success: function(data) {
            var estado = '<option selected disabled style="display:none; color:#757575;" value="">Estado *</option>';
            for (var i = 0; i < data.estados.length; i++) {
                estado += '<option value="' + data.estados[i].estado + '">' + data.estados[i].descripcion + '</option>'
            }
            $("#sel_estado_fact").html(estado);
        },
        error: function() {}
    });
}

function getMunicipioF(estado) {

    $.ajax('/getMunicipiof', {
        type: 'GET',
        data:{
            'estado':$("#estado_select_fact").val()
        },
        success: function(data) {
            var mun_html = '<option selected style="display:none; color:#757575;" value="">Municipio *</option>';
            for (var i = 0; i < data.municipios.length; i++) {
                mun_html += '<option value="' + data.municipios[i].municipio + '">' + data.municipios[i].descripcion + '</option>'
            }
            $("#sel_mun_fact").html(mun_html);
        },
        error: function() {}
    });
}

function getCiudadF(estado, municipio) {
    var ciud_html = 0;
    $.ajax('/getCiudadf', {
        type: 'GET',
        data:{
            'estado':$("#estado_select_fact").val(),
            'municipio': municipio
        },
        success: function(data) {
            var ciud_html = '<option selected style="display:none; color:#757575;" value="">Ciudad *</option>';
            for (var i = 0; i < data.ciudades.length; i++) {
                ciud_html += '<option value="' + data.ciudades[i].ciudad + '">' + data.ciudades[i].descripcion + '</option>';
            }
            $("#sel_ciudad_fact").html(ciud_html);
        },
        error: function() {}
    });
}

function getColoniaF(estado, municipio, ciudad) {
    $.ajax('/getColoniasf', {
        type: 'GET',
        data:{
            'estado': $("#estado_select_fact").val(),
            'municipio':municipio,
            'ciudad': ciudad
        },
        success: function(data) {
            var col_html = '';
            for (var i = 0; i < data.colonias.length; i++) {
                col_html += '<option onselect="setSelectCol(' + data.colonias[i].colonia + ')" data-value="' + data.colonias[i].colonia + '" value="' + data.colonias[i].descripcion + '" ></option>';
            }
            // console.log(col_html);
            $("#colonias_fact").html(col_html);
            // console.log($("#colonias_fact").text());
        },
        error: function() {}
    });
}

function getDirecciones() {
    $.ajax('/listadirecciones', {
        type: 'GET',
        success: function(data) {
            var html_listaDirecciones = '<option selected style="display:none; color:#757575;">Principal</option>';
            for (var i = 0; i < data.lista_direcciones.length; i++) {
                html_listaDirecciones += '<option color:#757575;" value="' + data.lista_direcciones[i].id_direccion + '">' + data.lista_direcciones[i].nombre_direccion + '</option>';
            }
            $("#inputGroupSelect01").html(html_listaDirecciones);
        },
        error: function() {}
    });
}
