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
    var estado_temp = 0;
    $.ajax('/getEstado', {
        type: 'GET',
        success: function(data) {
            var mun_html = '<option selected style="color:#757575;" value="">Estado *</option>';
            for (var i = 0; i < data.estados.length; i++) {
                    mun_html += '<option value="' + data.estados[i].estado + '">' + data.estados[i].descripcion + '</option>';
            }

            $("#sel_estado_fact").html(mun_html);
        },
        error: function() {}
    });
}



function getMunicipio(estado, vista) {
    var municipio_temp = 0;

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

            if(vista == 'facturacion'){
                $("#sel_mun_fact").html(mun_html);
                if ($("#municipio_select_fact").val() > 0) {
                    $("#colonia_select_fact").val(0);
                    getCiudad(estado, municipio_temp, vista);
                }
            }else{
                $("#sel_mun_dom").html(mun_html);
                if ($("#municipio_select").val() > 0) {
                    // console.log(estado, municipio_temp);
                    getCiudad(estado, municipio_temp, vista);
                }
            }
        },
        error: function() {}
    });
}

function getCiudad(estado, municipio, vista) {
    var ciudad_temp = 0;
    // console.log(estado);
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

            if(vista == 'facturacion'){
                $("#sel_ciudad_fact").html(ciud_html);
                if ($("#ciudad_select_fact").val() > 0) {
                    $("#colonia_select_fact").val(0);
                    getColonia(estado,municipio, ciudad_temp, vista);
                }
            }else{
                $("#sel_ciud_dom").html(ciud_html);
                // $("#d_inp_ciud").show();
                if ($("#ciudad_select").val() > 0) {
                    getColonia(28, municipio, ciudad_temp, vista);
                }

            }
        },
        error: function() {}
    });
}

function getColonia(estado, municipio, ciudad, vista) {
    var colonia_temp = 0;
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
                    // console.log(data.colonias[i].colonia + ' ' + $("#colonia_select").val(), col_html);
                } else {
                    col_html += '<option onselect="setSelectCol(' + data.colonias[i].colonia + ')" data-value="' + data.colonias[i].colonia + '" value="' + data.colonias[i].descripcion + '" ></option>';
                }
            }
            if(vista == 'facturacion'){
                $("#colonias_fact").html(col_html);
            }else{
                $("#Colonias").html(col_html);
            }


            // $("#d_inp_col").show();
            // $("#d_inp_ref").show();
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
