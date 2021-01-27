
function buscar(){
    var dato_busqueda = $("#inp_bus").val();

    $.ajax('/busqueda/'+dato_busqueda, {
        type: 'GET',
        success: function (data) {
            window.location.href = '/search/'+data.datos;
        },
        error: function () {
        }
    });
}

function ucFirstAllWords(str)
{
    var pieces = str.split(" ");
    for ( var i = 0; i < pieces.length; i++ ){
        var j = pieces[i].charAt(0).toUpperCase();
        pieces[i] = j + pieces[i].substr(1).toLowerCase();
    }
    return pieces.join(" ");
}

// Funcion usada para ejecutarse la primera vez que se entra a la página,
// si está auteniticado y no tiene carrito guardado le genera uno
function validaAuthCarrito(){
    var array_articulos = [];
    var carritoGuardado = localStorage.getItem('cguard');
	var articulos_local_g = JSON.parse(localStorage.getItem("carrito"));
	var tot, tot_art = 0;
    if($("#vista").val() != 'facturacion'){
        if($("#isUser").val() == 'true' && !carritoGuardado){
            loginUsuario($("#isAuth").val(), $("#isEmail").val());
            email = $("#isEmail").val();
            $.ajax('/carrito_info', {
                type: 'GET',
                data:{
                    'articulos' : articulos_local_g
                },
                success: function (data) {

                    if(articulos_local_g == null){
                        localStorage.setItem('carrito', JSON.stringify(data.articulos));
                    }
                    // localStorage.setItem('carrito_completo', JSON.stringify(data.articulos));
                    localStorage.setItem('cguard', 'true');
                    localStorage.removeItem('ic');
                    localStorage.setItem('ic', data.id_carrito);
                    totalesHeader();
                },
                error: function () {
                }
            });

        }else{

        }
    }else{
        if($("#esPago").val()){
            if($("#response").val() == 'Aprobado'){
                localStorage.removeItem('carrito');
                localStorage.removeItem('art');
                localStorage.removeItem('cguard');
                localStorage.removeItem('ic');
            }
        }

    }
}


function totalesHeaderT(){
    $.ajax('/getTotalVenta', {
        type: 'GET',
        data:{
            'id_carrito' : localStorage.setItem('ic', respuesta.id_carrito)
        },
        success: function (data) {

        },
        error: function () {
        }
    });
}



function totalesHeader(){
    total = 0;
    total_art = 0;
    if(localStorage.getItem("carrito")){
        var carro = JSON.parse(localStorage.getItem("carrito"));

        for (var i = 0; i < carro.length; i++) {
            total +=  parseFloat(carro[i].total);
            total_art += parseInt(carro[i].cantidad);
        }

        const formatPesos = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD'
        });
        total_header = formatPesos.format(total);
        $("#tot_carr_num_txt").text(total_header);
        $("#tot_carr_num_h").text(total_art);
    }else{
        $("#tot_carr_num_txt").text('$0.00');
        $("#tot_carr_num_h").text('0');
    }
}



function limpiarHeader(){
    $("#tot_carr_num_txt").text('$0.00');
    $("#tot_carr_num_h").text(0);
    localStorage.removeItem("carrito");
    localStorage.removeItem("cguard");
    localStorage.removeItem('ic');
    localStorage.removeItem('art');
    localStorage.removeItem('fol');
    $("#local_art").html('');
}
