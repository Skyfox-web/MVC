var cont_valid = 0;
function guardaFolio(){
    // console.log('pasó');
    // return false;
    $.ajax({
        data: $("#frm_dinamica").serialize(),
        type: 'POST',
        url: '/registra_participante',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {

            var mensaje = "Se ha registrado con éxito";
            if(!response['existe'] || response['existe'] == false){
                if(response || response == 'true' || response == 1){
                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        icon: 'success',
                        text: mensaje
                    }).then((result) => {
                        $("#frm_dinamica")[0].reset();
                    });
                }else{
                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        icon: 'warning',
                        text: mensaje+', revisa tu información y vuelve a intentarlo',

                    });
                }
            }else{
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    icon: 'warning',
                    text: "Esta factura ya ha sido registrada, intenta de nuevo con otra factura.",


                }).then((result) => {
                    // $("#folio").val('');
                    // $("#serie").prop('selectedIndex',0);
                });
            }

        }
    });
}


function validaDireccion(tipo) {
    var tipo = tipo;
    var elements = document.getElementById("frm_dinamica");
    cont_valid = 0;
    $("#frm_dinamica input").each(function() {
        var input = $(this);
        var id = $(this).attr('id');
        console.log(id);
        if ((input.val() === 'serie-w' || input.val() === '') && input.attr('required')) {

            $("." + id).show();
            cont_valid++;

        }else{
            if(id == 'correo'){
                if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test($(this).val())){
                    $(".correo_invalid").hide();
                } else {
                    cont_valid++;
                    $(".correo_invalid").show();
                }
            }
            $("." + id).hide();

        }

    });
    if(!(cont_valid > 0)){
        guardaFolio();
    }

}


function setSerie(){

    $("#serie_hidden").val($("#serie").val());
    if($("#serie_hidden").val() != ""){
        $(".serie_hidden").hide();
    }else{
        $(".serie_hidden").show();
    }

}



$("#frm_dinamica input:required").on('keyup', function(e) {
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


$("#telefono").keypress(function() {
    if (this.value.length > this.maxLength)
        this.value = this.value.slice(0, this.maxLength);
});
