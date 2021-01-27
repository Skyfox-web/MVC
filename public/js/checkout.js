
function getUrlWPP(){
  $.ajax('/pruebaSan', {
  	type: 'GET',
  	data: {

  	},
  	success: function (data) {
        if(data.includes("success")){
            // console.log(data);
            var jsonData = $.parseXML(data);
            $xmlResponse = $(jsonData);
            var url = $xmlResponse.find('nb_url');
            $("#iframeWPP").attr('src', url.text());
            $("#iframeWPP").show();
        }
  	},
  	error: function () {

  	}
  });
}

function getInfDir(id_direccion){

    id_direccion = $("#inputGroupSelect01").val();
    $("#form_check").removeClass('was-validated');
    $.ajax('/getDireccionEsp/'+id_direccion, {
        type: 'GET',
        success: function (data) {
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
            precio_flete = data.precio_flete;
            getTotalFinal(precio_flete);
        },
        error: function () {
        }
    });
}

function addDom(){
    $("#list_dom_sel").hide();
    $("#dir_guard").hide();
    $("#boton_dom_cancel").show();
    $("#form_dir").show();
}

$("#boton_dom_cancel").click(function(event) {
    $("#list_dom_sel").show();
    $("#form_check")[0].reset();
    $('#nombre_dir').val('');
    $("#d_inp_ciud").hide();
    $("#d_inp_col").hide();
    $("#d_inp_ref").hide();
    $("#form_dir").hide();
    $("#dir_guard").show();
    getInfDir();
});

$("#telefono_dir").keypress(function(){

    if (this.value.length > this.maxLength)
    this.value = this.value.slice(0, this.maxLength);
});

$("#cp_dir").keypress(function(){
    if (this.value.length > this.maxLength)
    this.value = this.value.slice(0, this.maxLength);
});



function validaDireccion(tipo){
    var tipo = tipo;
    var elements = document.getElementById("form_check");
    var cont = 0;
    $("#form_check input").each(function(){
        var input = $(this);
        var id = $(this).attr('id');

        if(input.val() === '' && input.attr('required')){
            if(id === 'municipio_select'){
                $(".municipio_select").show();
            }
            else if(id === 'ciudad_select'){
                $(".ciudad_select").show();
            }
            else if(id === 'colonia_select'){
                $(".colonia_select").show();
            }
            else{
                if(id !== 'num_int_dir_val' || id !== 'materno_dir_val'){
                    if(tipo == '0'){
                        if(id !== 'nombre_dir'){
                            $("."+id).show();
                        }
                    }else{
                        $("."+id).show();
                    }
                }
            }
            cont++;
        }
    });
    if(cont > 0){
        $("#sig_step").attr('disabled', true);
    }else{
        $("#sig_step").attr('disabled', false);
    }
}

$("#form_check input:required").on('keyup',function (e){
    id = $(this).attr('id');
    if($(this).val() === ''){
        $("."+id).show();
        $("#sig_step").attr('disabled', true);
    }else{
        $("."+id).hide();
        // $("#sig_step").attr('disabled', false);
    }
});

function getTotalFinal(precio_flete){
    var precio_flete = precio_flete;
    $("#envio_chk").text(formatPesos.format(precio_flete));
    console.log('getTotalFinal');

    subtotal = 0;
    iva_venta = 0;
    total_cont = 0;
    if(localStorage.getItem('carrito')){
        cont_art = 0;
        var articulos = JSON.parse(localStorage.getItem('carrito'));
        for (var i = 0; i < articulos.length; i++) {

            $.ajax('/totart', {
                type: 'GET',
                data:{
                    'articulo' : articulos[i]['id'],
                    'cant': articulos[i]['cantidad'],
                    'precio_flete': precio_flete
                },
                success: function (data) {
                    subtotal += parseInt(data.subtot);
                    iva_venta += parseInt(data.iva_venta);
                    total_cont += parseInt(data.total);
                    var precio_uni_art = formatPesos.format(data.precio_unitario);
                    var total_art_ind = formatPesos.format(data.total);
                    $('#subtotal_chk').html(formatPesos.format(subtotal));
                    $('#iva_chk').html(formatPesos.format(iva_venta));
                    $('#total_chk').html(formatPesos.format(total_cont));
                },
                error: function () {
                }
            });
        }
    }
}
