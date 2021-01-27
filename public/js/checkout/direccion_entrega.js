var nom_acc = $("#auth_bienv_nom").text().trim().toLowerCase();

function getInfDir(id_direccion) {
    $("#load-Entrega").show();
    $("#load-Totales").show();
    id_direccion = $("#inputGroupSelect01").val();
    $("#form_check").removeClass('was-validated');
    // $("#loaderSimp").show();
    $.ajax('/getDireccionEsp/' + id_direccion, {
        type: 'GET',
        success: function(data) {
            $("#nombre_dir_val").text(data.nombre_contacto);
            $("#paterno_dir_val").text(data.paterno);
            $("#materno_dir_val").text(data.materno);
            $("#telefono_dir_val").text(data.telefono);
            $("#calle_dir_val").text(data.calle);
            $("#num_ext_dir_val").text(data.num_ext);
            $("#num_int_dir_val").text(data.num_int);
            $("#cp_dir_val").text(data.cp);
            $("#entre_calle1_dir_val").text(data.entre_calle);
            $("#entre_calle2_dir_val").text(data.y_calle);
            $("#nom_municipio").text(data.municipio_des);
            $("#nom_ciudad").text(data.ciudad_des);
            $("#nom_colonia").text(data.colonia_des);
            $("#referencias_dir_val").text(data.referencias);
            // $("#envio_chk").text(precio_flete);
            if(data.precio_flete === 'false'){
                precio_flete = 0.00;
                getTotalFinal(precio_flete, true);

                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'warning',
                    text: 'Por el momento no realizamos envíos a esta ciudad, intenta seleccionar otra localidad.',
                }).then((result) => {
                    pasa_envio = false;
                })
                pasa_envio = false;

                // swal('Por el momento no realizamos envíos a esta localidad, intenta seleccionar otra localidad.', {
                //   buttons: {
                //         confirm: {
                //         text: "Aceptar",
                //         value: true,
                //         visible: true,
                //         className: "",
                //         closeModal: true
                //       }
                //   },
                // }).then((value) => {
                //
                // });

            }else{
                precio_flete = data.precio_flete;
                pasa_envio = true;
                getTotalFinal(precio_flete, true);
            }
            $("#load-Entrega").hide();

        // $("#loaderSimp").hide();
        },
        error: function() {}
    });
}

function addDom() {
    $("#list_dom_sel").hide();
    $("#dir_guard").hide();
    $("#boton_dom_cancel").show();
    $("#form_dir").show();
    $("#sig_step").hide();
    $("#sel_ciud_dom").show();
    newDir = true;
    pasa_envio = false;
}

$("#boton_dom_cancel").click(function(event) {
    $("#list_dom_sel").show();
    $("#form_check")[0].reset();
    $('#nombre_dir').val('');
    $("#form_dir").hide();
    $("#dir_guard").show();
    $("#sig_step").show();
    newDir = false;
    pasa_envio = true;
    // console.log($("#cont_lista_direcciones").val());
    if(cont_direcciones > 0){
        getInfDir();
    }
});

function validaDireccion(tipo) {
    var tipo = tipo;
    var elements = document.getElementById("form_check");
    cont_valid = 0;
    $("#form_check input").each(function() {
        var input = $(this);
        var id = $(this).attr('id');

        if (input.val() === '' && input.attr('required')) {
            if (id === 'municipio_select') {
                $(".municipio_select").show();
            } else if (id === 'ciudad_select') {
                $(".ciudad_select").show();
            } else if (id === 'colonia_select') {
                $(".colonia_select").show();
            }else if(id == 'correo_dir'){
                console.log('entra inv');
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3,4})+$/.test($(this).val())){
                    $(".correo_invalid").show();
                } else {
                    $(".correo_invalid").hide();
                }

                if(input.val() === ''){
                    $(".correo_dir_val").show();
                }else{
                    $(".correo_dir_val").hide();
                }
            }else {
                if (id !== 'num_int_dir_val' || id !== 'materno_dir_val') {
                    if (tipo == '0') {
                        if (id !== 'nombre_dir') {
                            $("." + id).show();
                        }
                    } else {
                        $("." + id).show();
                    }
                }
            }
            cont_valid++;
        }
    });

    if (tipo == 0) {
        pasa_form = cont_valid > 0 ? false : true;
        if(pasa_envio && pasa_form){
            stepper1.next();
        }
    }else if(tipo == 2){
        if(pasa_envio){
            pasa_form = true;
            stepper1.next();
        }
    }else if(tipo == 1){

        pasa_form = cont_valid > 0 ? false : true;
        console.log(newDir, pasa_form, pasa_envio);
        if(newDir && !pasa_form && !pasa_envio){
            return false;
        }else{
            guardaDireccionEntrega();
        }
    }
}
$("#correo_dir").change(function (){
    if($(this).val() === ''){
        $(".correo_dir_val").show();
    }else{
        $(".correo_dir_val").hide();
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test($(this).val())){
            console.log('hide');
            $(".correo_invalid").hide();
        } else {
            console.log('show');
            $(".correo_invalid").show();
        }
    }
});



// $('#form_check').on('submit',function(e) {
    // e.preventDefault();
function guardaDireccionEntrega(){
    console.log($("#inp_col_search").val(), $("#colonia_select").val(), pasa_envio, pasa_form);
    $("#load-GuardaEntrega").show();
    if($("#inp_col_search").val() != '' && $("#colonia_select").val() != 0 && pasa_envio && pasa_form){
        $.ajax({
            data: $("#form_check").serialize(),
            type: 'POST',
            url: 'guardaDireccion',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var html_txt_agg = '';
                var seAgrego = false;
                $("#load-GuardaEntrega").hide();
                if(response.success){
                    if(response.isCreate){
                        console.log('create');
                        html_txt_agg = '¡La nueva dirección se agregó correctamente!';
                        limpia_campos();
                    }else{
                        html_txt_agg = '¡La dirección se actualizó correctamente!';
                    }
                    seAgrego = true;

                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        icon: 'success',
                        text: html_txt_agg,
                    }).then((result) => {
                        if(seAgrego){
                            console.log('windows');
                            window.location.href = '/CarritoCheckOut';
                        }
                    })


                }else{

                    html_txt_agg = 'Ocurrió un problema al guardar la dirección, intenta de nuevo más tade.';
                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        icon: 'warning',
                        text: html_txt_agg,
                    })

                }

            }
        });
    }
}

//     return false;
// });

$("#telefono_dir").keypress(function() {
    if (this.value.length > this.maxLength)
        this.value = this.value.slice(0, this.maxLength);
});

$("#cp_dir").keypress(function() {
    if (this.value.length > this.maxLength)
        this.value = this.value.slice(0, this.maxLength);
});



$("#form_check input:required").on('keyup', function(e) {
    id = $(this).attr('id');
    if ($(this).val() === '') {
        $("." + id).show();
        cont_valid++;
    } else {
        $("." + id).hide();
        cont_valid--;
        // $("#sig_step").attr('disabled', false);
    }
});

function getTotalFinal(precio_flete_v, isFirstTime) {
    precio_flete = precio_flete_v;
    subtotal = 0;
    iva_venta = 0;
    total_cont = 0;
    total_carrito = 0;
    var articulos = '';
    if (localStorage.getItem('carrito')) {
        cont_art = 0;
        var articulos = JSON.parse(localStorage.getItem('carrito'));
        total_Articulos = articulos.length;
        for (var i = 0; i < articulos.length; i++) {


            $.ajax('/totart', {
                type: 'GET',
                data: {
                    'articulo': articulos[i]['id'],
                    'cant': articulos[i]['cantidad'],
                },
                success: function(data) {
                    subtotal += parseFloat(data.subtot);
                    iva_venta += parseFloat(data.iva_venta);
                    total_cont += parseFloat(data.total);
                    $('#subtotal_chk').html(formatPesos.format(subtotal));
                    $('#iva_chk').html(formatPesos.format(iva_venta));
                    $('#total_chk').html(formatPesos.format(total_cont));
                    cont_art ++;


                    if(cont_art == total_Articulos){
                        total_carrito = total_cont;
                        total_cont += parseFloat(precio_flete);
                        $('#total_chk').html(formatPesos.format(total_cont));
                        $("#envio_chk").text(formatPesos.format(precio_flete));
                        guardado = true;
                        if(guardado){
                            $("#load-Totales").hide();

                           if(isFirstTime){
                               var txt_flete = '';
                               console.log(precio_flete);
                               if(precio_flete == 0){
                                   txt_flete = 'Tu envío es gratis.';
                               }else{
                                   txt_flete = 'Tus gastos de envío son: ' + formatPesos.format(precio_flete);
                               }
                               Swal.fire({
                                   allowOutsideClick: false,
                                   allowEscapeKey: false,
                                   allowEnterKey: false,
                                   imageUrl: '../../img/icons/icon-truk.png',
                                   imageWidth:170,
                                   imageHeight:90,
                                   text: txt_flete,
                               })
                           }

                        }
                    }
                },

                error: function() {}
            });


        }

        // $("#load-Totales").hide();
    }
}


$("#sel_mun_dom").on('change', function (event){
    // console.log($("#sel_mun_dom").val());
    $("#municipio_select").val($("#sel_mun_dom").val());
    $("#ciudad_select").val('');
    $("#colonia_select").val('');
    getCiudad($("#estado_select_dom").val(), $("#sel_mun_dom").val());
    if($("#municipio_select").val() === ''){
        $(".municipio_select").show();

    }else{
        $(".municipio_select").hide();
    }
});


$("#sel_ciud_dom").on('change', function (event){
    $("#colonia_select").val('');
    $("#ciudad_select").val($("#sel_ciud_dom").val());
    $(".no-col").hide();
    $("#load-Colonia").show();
    $.ajax('/getFlete', {
        type: 'GET',
        data:{
            'estado': $("#estado_select_dom").val(),
            'ciudad': $("#sel_ciud_dom").val(),
            'municipio': $("#municipio_select").val()
        },
        success: function (data) {
            // console.log(data);

            if(data == 'false'){
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'error',
                    text: 'Ocurrió un problema al obtener el precio de envío, no se puede continuar.',
                }).then((result) => {
                    pasa_envio = false;
                })
                pasa_envio = false;

            }else{
                pasa_envio = true;
                getTotalFinal(data, true);
            }
        },
        error: function(data){

        }
    });

    if($("#ciudad_select").val() === ''){
        $(".ciudad_select").show();
    }else{
        $(".ciudad_select").hide();
    }

});




$("#inp_col_search").on('change', function (event){
    $("#colonia_select").val($("#inp_col_search").prop("data-value"));
    //
    if($("#colonia_select").val() === ''){
        $(".colonia_select").show();
    }else{
        $(".colonia_select").hide();
    }

});


$("#inp_col_search").change(function(){

  var proName=$("#inp_col_search").val();
   var value = $('#Colonias option').filter(function() {
     return this.value == proName;
   }).data('value');
   var msg = value ? value : '';
   $("#colonia_select").val(msg)

   if($("#colonia_select").val() === ''){
       $(".colonia_select").show();
   }else{
       $(".colonia_select").hide();
   }
});



$("#sel_ciud_dom").on('change', function (event){
    // console.log('onchange select col');
    // $("#load-Colonias").show();
    $(".no-col").hide();
    $("#load-Colonia").show();
    $.ajax('/getColonias', {
        type: 'GET',
        data:{
            'estado': $("#estado_select_dom").val(),
            'municipio':$("#sel_mun_dom").val(),
            'ciudad':$("#sel_ciud_dom").val()
        },
        success: function (data) {
            var col_html = '';
            // console.log($("#colonia_select").val());
            for (var i = 0; i < data.colonias.length; i++) {
                col_html += '<option data-value="'+ data.colonias[i].colonia +'" value="'+ data.colonias[i].descripcion +'" ></option>';
            }
            $("#inp_col_search").val('');
            $("#Colonias").html(col_html);
            // $("#load-Colonias").hide();
            $("#d_inp_col").show();
            $("#d_inp_ref").show();
            // console.log(data.colonias.length);

            if(data.colonias.length == 0){
                $(".no-col").show();
            }else{
                $(".no-col").hide();
            }
            $("#load-Colonia").hide();
        },
        error: function () {

        }
    });

});

function limpia_campos(){
    $("#nombre_dir_val").val('');
    $("#nombre_dir_val").val('');
    $("#paterno_dir_val").val('');
    $("#materno_dir_val").val('');
    $("#telefono_dir_val").val('');
    $("#calle_dir_val").val('');
    $("#num_ext_dir_val").val('');
    $("#num_int_dir_val").val('');
    $("#cp_dir_val").val('');
    $("#entre_calle1_dir_val").val('');
    $("#entre_calle2_dir_val").val('');
    $("#inp_col_search").val('');
    $("#referencias_dir_val").val('');
}



function getMunicipio(estado) {
    var municipio_temp = 0;
    $(".no-col").hide();
    $.ajax('/getMunicipio', {
        type: 'GET',
        data:{
            'estado':estado
        },
        success: function(data) {
            var mun_html = '<option selected style="color:#757575;" value="">Municipio *</option>';
            for (var i = 0; i < data.municipios.length; i++) {
                if (data.municipios[i].municipio == $("#municipio_select").val()) {
                    mun_html += '<option selected value="' + data.municipios[i].municipio + '">' + data.municipios[i].descripcion + '</option>'
                    municipio_temp = data.municipios[i].municipio;
                } else {
                    mun_html += '<option value="' + data.municipios[i].municipio + '">' + data.municipios[i].descripcion + '</option>'
                }
            }

            $("#sel_mun_dom").html(mun_html);
            if ($("#municipio_select").val() > 0) {
                // console.log(estado, municipio_temp);
                getCiudad(estado, municipio_temp);
            }

        },
        error: function() {}
    });
}

function getCiudad(estado, municipio) {
    var ciudad_temp = 0;
    // console.log(estado);
    $(".no-col").hide();
    $("#load-Ciudad").show();
    $.ajax('/getCiudadL', {
        type: 'GET',
        data:{
            'estado':estado,
            'municipio': municipio
        },
        success: function(data) {
            var ciud_html = '<option selected style="color:#757575;" value="">Ciudad *</option>';
            for (var i = 0; i < data.ciudades.length; i++) {

                if (data.ciudades[i].ciudad == $("#ciudad_select").val()) {
                    ciud_html += '<option selected value="' + data.ciudades[i].ciudad + '">' + data.ciudades[i].descripcion + '</option>';
                    ciudad_temp = data.ciudades[i].ciudad;
                } else {
                    ciud_html += '<option value="' + data.ciudades[i].ciudad + '">' + data.ciudades[i].descripcion + '</option>';
                }
            }

            $("#sel_ciud_dom").html(ciud_html);
            if ($("#ciudad_select").val() > 0) {
                getColonia(28, municipio, ciudad_temp);
            }
            $("#load-Ciudad").hide();

        },
        error: function() {}
    });
}

function getColonia(estado, municipio, ciudad) {
    var colonia_temp = 0;
    $("#load-Colonia").show();
    $.ajax('/getColonias', {
        type: 'GET',
        data:{
            'estado': estado,
            'municipio':municipio,
            'ciudad': ciudad
        },
        success: function(data) {
            var col_html = '';
            for (var i = 0; i < data.colonias.length; i++) {
                if (data.colonias[i].colonia == $("#colonia_select").val()) {
                    col_html = '<option selected onselect="setSelectCol(' + data.colonias[i].colonia + ')" data-value="' + data.colonias[i].colonia + '" value="' + data.colonias[i].descripcion + '"></option>' + col_html;
                    $("#inp_col_search").val(data.colonias[i].descripcion);
                    $("#colonia_select").val(data.colonias[i].colonia);
                    console.log(data.colonias[i].colonia + ' ' + $("#colonia_select").val(), col_html);
                } else {
                    col_html += '<option onselect="setSelectCol(' + data.colonias[i].colonia + ')" data-value="' + data.colonias[i].colonia + '" value="' + data.colonias[i].descripcion + '" ></option>';
                }
            }
            // console.log(data.colonias.length);
            if(data.colonias.length == 0){
                $(".no-col").show();
            }else{
                $(".no-col").hide();
            }
            $("#Colonias").html(col_html);
            $("#load-Colonia").hide();
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
