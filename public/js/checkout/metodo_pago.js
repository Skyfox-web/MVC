function validaInf(servicio) {
    $("#loader_boton").show();
    // console.log(requ_fact, pasa_fact, pasa_envio, pasa_form);
    var p_fact_final = false;
    var p_env_final = false;
    var mensaje = '';
    var p_fin = false;
    p_fact_final = !requ_fact ? false : ((pasa_fact && pasa_rfc) ? true : false);
    // console.log(p_fact_final, requ_fact, (pasa_fact && pasa_rfc), pasa_fact,  pasa_rfc);
    p_env_final = (pasa_envio && pasa_form) ? true : false;

    if(p_env_final){
        mensaje = (requ_fact && !p_fact_final) ? 'Los datos de facturación son incorrectos, favor de verificarlos.' : '';
        if(mensaje === ''){
            p_fin = true;
        }
    }else{
        mensaje =  (requ_fact && !p_fact_final) ? 'Su información de entrega y facturación están incompletos, favor de verificarlos.' : 'La información de entrega está incompleta, favor de verifiacarla.';
        p_fin = false;
    }

    if(p_fin){
        generaOrden(servicio);
    }else{
        // console.log(mensaje);
        $("#loader_boton").hide();
        Swal.fire({
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            icon: 'warning',
            text: mensaje,

        });
    }

}

function generaOrden(servicio){
    //Generará primeramente la orden de venta para guardar el id de la orden en localStorage
    var direccion_dat = [];

    $("#form_check input").each(function() {
        // console.log($(this).attr('id'), $(this).val());
        val = $(this).val();
        direccion_dat.push(val);
    });
    direccion_dat = JSON.stringify(direccion_dat);
    // console.log(direccion_dat);



    var formdata = $("#form_check").serializeArray();
    var data = {};
    $(formdata ).each(function(index, obj){
        data[obj.name] = obj.value;
    });
    dir = JSON.stringify(data);

    var formfact = $("#form_fact").serializeArray();
    var fact = {};
    $(form_fact ).each(function(index, obj){
        fact[obj.name] = obj.value;
    });
    fac = JSON.stringify(fact);

    id_dir = isAuth !== 'false' ? document.getElementById("inputGroupSelect01").value : false;
    id_car = isAuth !== 'false' ? localStorage.getItem('ic') : false;
    art_cart = localStorage.getItem('carrito');

    $.ajax('/generaOrden', {
        type: 'POST',
        data: {
            'isFact':requ_fact,
            'tipo_fact':tipo_fact,
            'total_cont':total_cont,
            'total_carrito':total_carrito,
            'precio_flete':precio_flete,
            'id_dir' : id_dir,
            'direccion' : dir,
            'facturacion':fac,
            'id_cliente': id_cliente,
            'id_carrito' : id_car,
            'art_cart' : art_cart
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $("#loader_boton").hide();
            localStorage.removeItem('cguard');
            // return false;
            if(servicio == 'wpp'){
                getWPP(data);
            }else{
                getUrlPayPal();
            }
        },
        error: function() {

        }
    });
}

function getWPP(folio){
    var id_carrito = localStorage.getItem('ic');
    $.ajax('/pruebaSan', {
        type: 'GET',
        data: {
            'total': total_cont,
            'correo': $("#correo_dir").val(),
            'folio' : folio
        },
        success: function(data) {
            if (data.includes("success")) {
                // console.log(data);
                var jsonData = $.parseXML(data);
                $xmlResponse = $(jsonData);
                var url = $xmlResponse.find('nb_url');
                window.open(url.text(), '_self');
                // $("#iframeWPP").attr('src', url.text());
                //     $("#iframeWPP").show();
            }
        },
        error: function() {

        }
    });
}
