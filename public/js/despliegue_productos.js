

function valida_info_ajax(){
	cant_prod = 1;
	existencias = $("#existencias_art").val();
	$("#cant_sel").val(cant_prod);
	$("#boton_menos").prop("disabled", true);
	$("#boton_mas").prop("disabled", false);
	if(cant_prod == existencias){
		$("#boton_mas").prop("disabled", true );
	}
}

function cant(val){
	existencias = $("#existencias_art").val();
	if(val){
		if(cant_prod == existencias-1){
			$("#boton_mas").prop("disabled", true );
		}else{
			$("#boton_menos").prop("disabled", false );
		}
		cant_prod++;
		$('#cant_sel').val(cant_prod);
	}else{
		if(cant_prod != 2){
			cant_prod--;
			$('#cant_sel').val(cant_prod);
			// console.log(cant_prod);
		}else{
			cant_prod--;
			$('#cant_sel').val(cant_prod);
			$("#boton_menos").prop("disabled", true );
			$("#boton_mas").prop("disabled", false );

		}
	}
	cantidad_carrito = $("#cant_sel").val();


}

function mostrarBotones(t){
    var botones = '';
    for(var i = 0; i < t; i++){
        var cada = '';
        cada = "<button onclick='deslizaArriba()' type='button' "+
            "class='btn btn-info'>"+(i+1)+
            "</button>";
        botones += cada;
    }

    $('#botones').append(botones);
}


function deslizaArriba(){
	$('html, body').animate({scrollTop:0}, 'slow');
}

function quitarActivo(){
    var losBotones = document.querySelectorAll('#botones button');
    for(var i = 0; i < losBotones.length; i++){
        $(losBotones[i]).removeClass('active');
    }
}

function botones_click(){
	$('#botones button:first-child').addClass('active');
	var losBotones = document.querySelectorAll('#botones button');
	for(var i = 0; i < losBotones.length; i++){
		losBotones[i].addEventListener('click',function(){
			quitarActivo();
			var indice = parseInt(this.textContent);
			var o = (indice - 1) * xPag;
			var paginador = Math.ceil(totales/xPag);
			var saldo=totales%xPag;
			var h;

			if(paginador === indice){
				h = (indice * xPag) - saldo;
			}else{
				h = indice * xPag;
			}

			mostrarLista(o,h);
			$(this).addClass('active');
		});
	}
}
