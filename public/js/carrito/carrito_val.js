var carro_temp_comp = [];


function articuloCarrito(id, total, precio_unitario, cant, existencias, bodega, grupo, departamento, codigo, desc) {
	this.id = id;
	this.total = total;
    this.precio_unitario = precio_unitario;
	this.cantidad = cant;
	this.exist = existencias;
    this.bodega = bodega;
    this.grupo = grupo;
    this.departamento = departamento;
    this.codigo = codigo;
    this.desc = desc;
}


function guardaCarritoLocalStorage(articulo_carrito, precio_carrito, precio_articulo_c, cantidad_carrito, existencias, bodega, grupo, departamento, codigo, desc){

    if(localStorage.getItem("carrito")){
        var carro = JSON.parse(localStorage.getItem("carrito"));
        localStorage.removeItem("carrito");

        for (var i = 0; i < carro.length; i++) {
             var art = new articuloCarrito(carro[i].id,
                carro[i].total,
                carro[i].precio_unitario,
                carro[i].cantidad,
                carro[i].exist,
                carro[i].bodega,
                carro[i].grupo,
                carro[i].departamento,
                carro[i].codigo,
                carro[i].desc);
             carro_temp_comp.push(art);
             localStorage.setItem("carrito", JSON.stringify(carro_temp_comp));
        }
    }

    precio_carrito *= cantidad_carrito;

    var art = new articuloCarrito(articulo_carrito,
        precio_carrito,
        precio_articulo_c,
        cantidad_carrito,
        existencias,
        bodega,
        grupo,
        departamento,
        codigo,
        desc);

    carro_temp_comp.push(art);
    localStorage.setItem("carrito", JSON.stringify(carro_temp_comp));

    carro_temp_comp = [];
    totalesHeader();
    // var total = totalesHeader();

}

function guardaArtCart(){
    if(localStorage.getItem("art")){
        var art = JSON.parse(localStorage.getItem("art"));
        localStorage.removeItem("art");

        for (var i = 0; i < art.length; i++) {
             carrito_art_ind.push(art[i]);
             localStorage.setItem("art", JSON.stringify(carrito_art_ind));
        }
    }

    carrito_art_ind.push(articulo_carrito);
    localStorage.setItem("art", JSON.stringify(carrito_art_ind));
    carrito_art_ind = [];
}


function comprar(){
    const carro = JSON.parse(localStorage.getItem('carrito'));
    if(carro === null){
        aftCarritoVal(existencias, bodega, grupo, departamento);
    }else{
        var encuentra = carro.find(art => art.id === articulo_carrito);
        if(encuentra){

            // console.log(parseInt(encuentra.cantidad), parseInt(cantidad_carrito), parseInt(existencias), (parseInt(encuentra.cantidad)+parseInt(cantidad_carrito)) > parseInt(existencias));
            // return false;
            if((parseInt(encuentra.cantidad)+parseInt(cantidad_carrito)) > parseInt(existencias)){
				var msg = '';
				if(parseInt(existencias) == 1){
					msg = 'Solo se encuentra '+parseInt(existencias) + ' articulo en existencia.'
				}else{
					msg = 'Solo se encuentran '+parseInt(existencias) + ' articulos en existencia.'
				}

				Swal.fire({
					allowOutsideClick: false,
					allowEscapeKey: false,
					allowEnterKey: false,
					icon: 'warning',
					text: msg,
				}).then((result) => {

				})

            }else{
                aftCarritoVal(existencias, bodega, grupo, departamento);
            }
        }else{
            aftCarritoVal(existencias, bodega, grupo, departamento);
        }
    }

    $("#ModalShopping").modal("hide");
}


function aftCarritoVal(existencias, bodega, grupo, departamento){

    if(!localStorage.getItem("art")){
        guardaArtCart();
        guardaCarritoLocalStorage(articulo_carrito, precio_carrito, precio_articulo_c, cantidad_carrito, existencias, bodega, grupo, departamento, false, 0);
    }else{
        var carrArtIn = JSON.parse(localStorage.getItem("art"));

        if(!carrArtIn.includes(articulo_carrito)){
            guardaArtCart();
            guardaCarritoLocalStorage(articulo_carrito, precio_carrito, precio_articulo_c, cantidad_carrito, existencias, bodega, grupo, departamento, false, 0);
        }else{

            if(localStorage.getItem("carrito")){
                pos = carrArtIn.indexOf(articulo_carrito);
                var carro = JSON.parse(localStorage.getItem("carrito"));
                localStorage.removeItem("carrito");
                for (var i = 0; i < carro.length; i++) {
                    if(carro[i].id == articulo_carrito){
                        cant_carr = parseInt(cantidad_carrito) + parseInt(carro[i].cantidad);
                        total = parseFloat(carro[i].precio_unitario) * cant_carr;
                        var art = new articuloCarrito(carro[i].id, total, carro[i].precio_unitario, cant_carr, carro[i].exist, carro[i].bodega, carro[i].grupo, carro[i].departamento, false, 0);
                    }else{
                        var art = new articuloCarrito(carro[i].id, carro[i].total, carro[i].precio_unitario, carro[i].cantidad, carro[i].exist, carro[i].bodega, carro[i].grupo, carro[i].departamento, false, 0);
                    }
                    carro_temp_comp.push(art);
                    localStorage.setItem("carrito", JSON.stringify(carro_temp_comp));
                }
            }
            carro_temp_comp = [];
            totalesHeader();
        }
    }


    // console.log('Articulo: ' + articulo_carrito + ' | Precio: '+ precio_carrito + ' | Cantidad: ' + cantidad_carrito);
    // console.log(isAuth);
    if(isAuth > 0){
        var articulos_local = JSON.parse(localStorage.getItem("carrito"));
        var carritoGuardado = localStorage.getItem("cguard");
        // Si el carrito no se ha registrado en localStorage envía la lista de articulos seleccionados
        if(!carritoGuardado){
            $.ajax({
                url: '/agregar',
                type: 'POST',
                dataType: 'json',
                data:{
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'articulos': articulos_local,
                    'guardado': carritoGuardado,
                },
                success: function (respuesta) {
                    id_carrito = localStorage.setItem('ic', respuesta.id_carrito);
                    localStorage.setItem("cguard", respuesta.carritoGuardado);
					if(respuesta.folio != ''){
                    	localStorage.setItem("fol", respuesta.folio);
					}
                    // cambiar divs de modal carrito, mostrar el modal de carrito guardado.
                    totalesHeader();

                },
            });
        }else{
			var articulos_local = JSON.parse(localStorage.getItem("carrito"));
            // si ya se encuentra registrado envía un solo artículo
            $.ajax({
                url: '/agregar',
                type: 'POST',
                dataType: 'json',
                data:{
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'articulo': articulo_carrito,
                    'cantidad_articulos': cantidad_carrito,
                    'id_carrito': localStorage.getItem('ic'),
                    'guardado' : carritoGuardado,
					'bodega' : bodega,
					'articulos_local': articulos_local,
                    'grupo': grupo,
                    'departamento': departamento
                },
                success: function (respuesta) {
					localStorage.removeItem('ic');
					localStorage.setItem('ic', respuesta['id_carrito']);
					totalesHeader();
                },
            });
        }
    }

}
