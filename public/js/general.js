$("#sel_mun_dom").on('change', function (event){
    $("#municipio_select").val($("#sel_mun_dom").val());

    getCiudad($("#estado_select_dom").val(), $("#sel_mun_dom").val());
    $("#colonia_select").val('');
    $("#ciudad_select").val('');
    if($("#municipio_select").val() === ''){
        $(".municipio_select").show();

    }else{
        $(".municipio_select").hide();
    }
});

$("#sel_ciud_dom").on('change', function (event){
    $("#ciudad_select").val($("#sel_ciud_dom").val());
    if($("#ciudad_select").val() === ''){
        $(".ciudad_select").show();
    }else{
        $(".ciudad_select").hide();
    }
    $("#colonia_select").val('');
});


$("#inp_col_search").on('change', function (event){
    $("#colonia_select").val($("#inp_col_search").prop("data-value"));

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
    $.ajax('/getColonias', {
        type: 'GET',
        data:{
            'estado' : $("#estado_select_dom").val(),
            'municipio':$("#sel_mun_dom").val(),
            'ciudad': $("#sel_ciud_dom").val()
        },
        success: function (data) {
            var col_html = '';
            // console.log($("#colonia_select").val());
            for (var i = 0; i < data.colonias.length; i++) {
                col_html += '<option data-value="'+ data.colonias[i].colonia +'" value="'+ data.colonias[i].descripcion +'" ></option>';
            }
            $("#inp_col_search").val('');
            $("#Colonias").html(col_html);

            $("#d_inp_col").show();
            $("#d_inp_ref").show();
        },
        error: function () {

        }
    });

});


$('#frm_gp').on('submit',function(e) {
    e.preventDefault();
    $("#frm_gp").removeClass('was-validated');
    // console.log($("#inp_col_search").val(), $("#colonia_select").val());
    if($("#inp_col_search").val() != '' && $("#colonia_select").val() != 0){
        $.ajax({
            data: $(this).serialize(),
            type: 'POST',
            url: 'guardaDireccion',
            headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var html_txt_agg = '';
                var seAgrego = false;
                if(response.success){
                    if(response.isCreate){
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
                        window.location.href = '/cliente';
                    })


                }else{
                    if(response.isCreate){
                        limpia_campos();
                        html_txt_agg = 'Ocurrió un problema al agregar la dirección, intenta de nuevo más tade.';
                    }else{
                        html_txt_agg = 'Ocurrió un problema al actualizar la dirección, intenta de nuevo más tade.';
                    }

                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        icon: 'error',
                        text: html_txt_agg,
                    }).then((result) => {

                    })


                }
            }
        });
    }

    return false;
});
