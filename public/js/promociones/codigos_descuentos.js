
function aplica_codigo(){
    console.log($(".isAuth").val());
    var codigo = '';
    var carrito = localStorage.getItem('carrito');

    if($(".isAuth").val() === '1'){

        codigo = $("#codigo_descuento_auth").val();

        $.ajax({
            data: {
                'codigo': codigo,
                'carrito': carrito,
                'total_carrito': total_contado_fin
            },
            type: 'GET',
            url: '/aplica_codigo',
            success: function(response) {
                var mensaje = '';
                if(response){
                    switch(response['estado']){
                        case 0:
                            mensaje = 'Ocurrió un problema al recibir el código, intenta de nuevo.';
                        break;
                        case 1:
                            mensaje = 'Código invalido.';
                        break;
                        case 2:
                            mensaje = 'Ha sobrepasado el límite de uso.';
                        break;

                    }

                    Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        icon: 'warning',
                        text: mensaje,
                    })


                }else{

                }


            }
        });

    }else{

        codigo = $("#codigo_descuento_local").val();

    }




}
