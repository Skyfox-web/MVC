@extends('Shared/Layout')

<!--titulo de la pagina-->
@section('titulo')
- {{$descripcion_grupo}}
@endsection
<!--body--><!--body--><!--body-->
@section('seccion')

<div class="contDEP">
	<!--<img src="{{ asset('/img/banners/Ago-1.png')}}" alt="">-->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="Grupo-dep">
					<a href="{{ url('/') }}"> INICIO </a> / {{$descripcion_grupo}}
				</div>
			</div>
		</div>
	</div>
</div>

<div class="list-ArtDEP">
<div class="container">
	<div class="row">
		<div class="col-xl-3 col-lg-4 col-md-4">
			<div class="Men-lat">
				<div id="subdepto" class="title-subdep">
					<h5>{{$subdepto ?? ' '}}</h5>
				</div>
				<h5>Filtrar por:</h5>
				<!--filtros activos-->
				<div class="">

				</div>
				<div class="active-filters" id="filt_activ">
					<!-- <span id="txt_"><a href="#"><i class="fa fa-times-circle" aria-hidden="true"></i></a>Hola</span> -->
				</div>
				<!--color Filtro 1-->
				<div class="sub_cat_box">
					<!-- obtener colores de bd y activarlos -->
					<a class="current ct-1">
						<li>Color:</li>
						<i class="fas fa-plus"></i>
						<i class="fas fa-minus flt-1"></i>
					</a>
					<ul>
						<div class="circulosColores" id="">
							<div title="Chocolate" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'CHOCOLATE')" class="cafe_ Ch-105"></div>
							<div title="Blanco"  data-toggle="tooltip" data-placement="top" onclick="filtros(0, 'BLANCO')" class="blanco_ Ch-105"></div>
							<div title="Rojo" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'ROJO')" class="rojo_ Ch-105"></div>
							<div title="Azul" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'AZUL')" class="azul_ Ch-105"></div>
							<div title="Amarillo" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'AMARILLO')" class="amarillo_ Ch-105"></div>
							<div title="Verde" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'VERDE')" class="verde_ Ch-105"></div>
							<div title="Rosa" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'ROSA')" class="rosa_ Ch-105"></div>
							<!-- <div title="Celeste" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'CELESTE')" class="celeste_ Ch-105"></div> -->
							<div title="Beige" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'BEIGE')" class="beige_ Ch-105"></div>
							<div title="Morado" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'MORADO')" class="morado_ Ch-105"></div>
							<div title="Gris" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'GRIS')" class="gris_ Ch-105"></div>
							<div title="Negro" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'NEGRO')" class="negro_ Ch-105"></div>
							<div title="Nogal" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'NOGAL')" class="nogal_ Ch-105"></div>
							<div title="Nogal Oscuro" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'NOGAL OSCURO')" class="nogalO_  Ch-105"></div>
							<div title="Perla" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'PERLA')" class="perla_  Ch-105"></div>
							<div title="Plata" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'PLATA')" class="plata_  Ch-105"></div>
							<div title="Dorado" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'DORADO')" class="dorado_  Ch-105"></div>
						</div>
					</ul>
				</div>


				<!--Marcas Filtro 2-->
				<div class="sub_cat_box" style="display:none;" id="marcas">
					<input type="hidden" id="isMarca" name="" value="{{$isMarca}}">
					<input type="hidden" id="total_lista" name="" value="{{$total_lista}}">
					<!-- <div class="" id="lista_marcas">

					</div> -->
					<a class="current ct-2">
						<li>Marcas:</li>
						<i class="fas fa-plus"></i>
						<i class="fas fa-minus flt-2"></i>
					</a>
					<ul>
						<div class="FiltroFC" id="filtro">


						</div>

					</ul>
				</div>

				<!--precio Filtro 3-->
				<div class="sub_cat_box" id="tipo_price">
					<a class="current ct-3">
						<li>Precio:</li>
						<i class="fas fa-plus"></i>
						<i class="fas fa-minus flt-3"></i>
					</a>
					<ul>
						<div class="FiltroFC">
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '-1', '3000')" name="radio" value=""> Menos de $3,000.00 </label><br>
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '3000', '5000')" name="radio" value=""> $3,000.00 a $5,000.00</label><br>
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '5000', '10000')" name="radio" value=""> $5,000.00 a $10,000.00</label><br>
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '10000', '15000')" name="radio" value=""> $10,000.00 a $15,000.00</label><br>
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '15000', '20000')" name="radio" value=""> $15,000.00 a $20,000.00</label><br>
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '20000', '30000')" name="radio" value=""> $20,000.00 a $30,000.00</label><br>
							<label><input class="chk_precio" type="radio" onclick="filtros(2, '30000', '-1')" name="radio" value=""> Mas de $30,000.00</label><br>
						</div>
						<div class="input-group">
								<input type="text" aria-label="Ancho" class="form-control" id="min_pre" onfocus="validaPrec()" onfocusout="validaPrec()" placeholder="Minimo">
							<div class="input-group-prepend">
								<span class="input-group-text">-</span>
							</div>
							<input type="text" aria-label="largo" class="form-control" id="max_pre" onfocus="validaPrec()" onfocusout="validaPrec()"  placeholder="Máximo">
								<div class="input-group-append">
    								<button class="btn btn-outline-secondary" onclick="enviaFiltro(0)"  type="button" id="button-addon2"><i class="fas fa-angle-right"></i></button>
  								</div>
						</div>
					</ul>

				</div>


				<!--Colchones filtro 4-->
				<div class="sub_cat_box" style="display:none;" id="tipo_colchon">
					<a class="current ct-4">
						<li>Tamaño:</li>
						<i class="fas fa-plus"></i>
						<i class="fas fa-minus flt-4"></i>
					</a>
					<ul>
						<div class="FiltroFC" id="">
							<label><input class="chk_colchon ind" onclick="filtros(4, 'IND')" type="checkbox" value="IND"> Individual </label><br>
							<label><input class="chk_colchon mat" onclick="filtros(4, 'MAT')" type="checkbox" value="MAT"> Matrimonial </label><br>
							<label><input class="chk_colchon queen" onclick="filtros(4, 'QS')" type="checkbox" value="QS"> Queen Size </label><br>
							<label><input class="chk_colchon king" onclick="filtros(4, 'KS')" type="checkbox" value="KS"> King Size </label>
						</div>
					</ul>
				</div>

				<!--Relojes Filtro 5-->
				<!-- <div class="sub_cat_box" style="display:none;" id="tipo_genero">
				<a class="current ct-5">
					<li>Genero:</li>
					<i class="fas fa-plus"></i>
					<i class="fas fa-minus flt-"></i>
				</a>
					<ul>
						<div class="FiltroFC" id="">
							<label><input class="chk_marca" onclick="filtros(5, 'M')" type="checkbox" value=""> Mujeres </label><br>
							<label><input class="chk_marca" onclick="filtros(5, 'H')" type="checkbox" value=""> Hombres </label><br>
						</div>
					</ul>
				</div> -->

				<!--Espacio Filtro 6-->

				<div class="sub_cat_box" style="display:none;" id="area_requerida_">
					<a class="current ct-6">
						<li>Espacio disponible:</li>
						<i class="fas fa-plus"></i>
						<i class="fas fa-minus flt-6"></i>
					</a>
					<ul>
						<div class="FiltroFC">
						</div>
						<div class="input-group">
							<input type="text" aria-label="Largo" class="form-control" id="largo_area" onfocus="validaMedidas()" onfocusout="validaMedidas()" placeholder="Largo" data-toggle="tooltip" data-placement="top" title="Ej. 2.40">
							<div class="input-group-prepend">
								<span class="input-group-text">X</span>
							</div>
							<input type="text" aria-label="Ancho" class="form-control" id="ancho_area" onfocus="validaMedidas()" onfocusout="validaMedidas()"  placeholder="Ancho" data-toggle="tooltip" data-placement="top" title="Ej. 1.40">
							<div class="input-group-append">
								<button class="btn btn-outline-secondary" onclick="enviaFiltro(1)"  type="button" id="button-addon3"><i class="fas fa-angle-right"></i></button>
							</div>
						</div>
					</ul>
				</div>
				@if($id_g == 55)
				<div class="sub_cat_box" id="tipo_colchon">
				    <a class="current ct-7">
				        <li>Tipo de sala:</li>
				        <i class="fas fa-plus"></i>
				        <i class="fas fa-minus flt-7"></i>
				    </a>
				    <ul>
				        <div class="FiltroFC" id="">
				            <label><input class="ch_clas" onclick="filtros(7, '3-2-1')" type="checkbox" value="3-2-1"> 3-2-1 </label><br>
				            <label><input class="ch_clas" onclick="filtros(7, '3-2')" type="checkbox" value="3-2"> 3-2 </label><br>
				            <label><input class="ch_clas" onclick="filtros(7, 'SECCIONAL')" type="checkbox" value="SECCIONAL"> Seccional </label><br>
				            <label><input class="ch_clas" onclick="filtros(7, 'ESQUINERA')" type="checkbox" value="ESQUINERA"> Esquinera </label><br>
				            <label><input class="ch_clas" onclick="filtros(7, 'ESQUINERA DERECHA')" type="checkbox" value="ESQUINERA DERECHA"> Esquinera Derecha </label><br>
				            <label><input class="ch_clas" onclick="filtros(7, 'ESQUINERA IZQUIERDA')" type="checkbox" value="ESQUINERA IZQUIERDA"> Esquinera Izquierda </label><br>

				        </div>
				    </ul>
				</div>
				@endif
			</div>
		</div>

		<!-- <img src="{{asset('articulos_img/6/17023.jpg')}}" alt=""> -->
		<div class="col-xl-9 col-lg-8 col-md-8">
			<div class="ordenar-por">
					<div class="dropdown">
  					<button class="btn btn-drop-ordenar" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    					Ordenar por: <i class="fas fa-angle-down"></i>
  					</button>
  					<div class="dropdown-menu ordenar-drop-opt" aria-labelledby="dropdownMenuButton">
    					<a class="dropdown-item" onclick="filtros(6, 'asc')">Menor precio</a>
						<a class="dropdown-item" onclick="filtros(6, 'desc')">Mayor precio</a>
  					</div>
				</div>
			</div>
			<input type="hidden" id="id_d" name="" value="{{$id_d}}">
			<input type="hidden" id="id_g" name="" value="{{$id_g}}">

			<div class="row" id="articulos">
				<!--despliega articulos-->
			</div>

			<div class="row justify-content-end" id="paginas_txt">
				<table>
	    			<tr>
	      				<th>
							<div class="cont-pag-label">
								<label>Páginas:</label>
							</div>
						</th>
	      				<th>
							<div class="contPAGp">
								<div class="contPAG" id="botones">
								<!--contenedor del paginaor-->
								</div>
								<div class="clearfix">
								</div>
							</div>
						</th>
					</tr>
				</table>
			</div>

		</div>
	</div>
</div>
</div>


<!-- Modal -->


@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/pruebas/despliegue_productos.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/carrito/carrito_val.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/pruebas/filtro.js') }}"></script>

<script>
$(".current").click(function(){
	$(this).next("ul").slideToggle();
});
	$(".ct-1").click(function(){
		$(".flt-1").toggle();
	});
	$(".ct-2").click(function(){
		$(".flt-2").toggle();
	});
	$(".ct-3").click(function(){
		$(".flt-3").toggle();
	});
	$(".ct-4").click(function(){
		$(".flt-4").toggle();
	});
	$(".ct-5").click(function(){
		$(".flt-5").toggle();
	});
	$(".ct-6").click(function(){
		$(".flt-6").toggle();
	});
</script>



<script>
var id_d = $("#id_d").val();
var id_g = $("#id_g").val();
var json = [{}];
var pag = 1;
var totales = 0;
var xPag = 9;
var nPag = 0;
var offset = (pag - 1) * xPag;
var hasta = pag * xPag;
var losBotones = "";
var existencias = 0;
var cant_prod = 1;
var articulo_carrito = 0;
var precio_carrito = 0;
var cantidad_carrito = 0;
var nombre_articulo = '';
var total_compra_carrito = 0;
var img_carrito_confirmacion = '';
var temp = new Object();
var color = [];
var marc = [];
var capacidad = [];
var clasificacion = [];
var lista_filt_act = [];
var carro = [];
var carrito_art_ind = [];
var precio_min = null;
var precio_max = null;
var largo = null;
var ancho = null;
var area_requerida = '';
var txtAct = '';
var txt_bus = '';
var tipo_orden = 0;
var bodega = 0;
const formatPesos = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD'
});

$("#button-addon2").attr('disabled',true);
$("#button-addon3").attr('disabled',true);

$( document ).ready(function(){
	$("#cant_sel").prop("disabled", true );
	$("#boton_menos").prop("disabled", true );

	$.ajax({
		url: '/Departamento/articulosDepto/'+ id_d +'/' + id_g,
		dataType: 'json',
		success: function (respuesta) {
			json = respuesta.articulos;
			totales = json.length;

			nPag = Math.ceil(totales / xPag);
			// console.log(offset, hasta);
			mostrarLista(offset,hasta);
			if(totales > 9){
				$("#paginas_txt").show();
				mostrarBotones(nPag);
				botones_click();
			}else{
				$("#paginas_txt").hide();
			}

			if(id_g == 132){
				$("#tipo_colchon").show();
			}
			if(id_d == 2 || id_d == 4){
				$("#area_requerida_").show();
			}
			if($("#isMarca").val()){
				$("#marcas").show();
				var total_lista = JSON.parse($("#total_lista").val());
				var html_filtros = '';
				// console.log(total_lista);
				total_lista.forEach((item, i) => {
					var marca = "'" + item['marca'] + "'";
					html_filtros += '<label><input class="chk_marca" onclick="filtros(1, '+marca+')" type="checkbox" id="cbox1" value="'+item['marca']+'"> '+item['marca'] +' ('+ item['total'] +')</label><br>';
				});

				$("#filtro").html(html_filtros);
			}
		}
	});
});


function mostrarLista(desde,hasta){
    var lista = '';
	if(hasta > totales){
		hasta = totales;
	}
	// console.log(desde + " - " + hasta);
    for(var i = desde; i < hasta; i++){
        var fila = '';
		grupo = '"' + json[i].grupo + '"';
		articulo = '"' + json[i].articulo + '"';

        precio_lista = formatPesos.format(json[i].precio_lista);
		precio_contado = formatPesos.format(json[i].precio_contado);
        fila += '<div class="col-xl-4 col-md-6  col-sm-6 prod ">'+
					'<a href="/Articulo/'+json[i].articulo+'/'+json[i].grupo+'">'+
						'<div class="prod-art">'+
							'<div class="prod-arts">';
							if(json[i].departamento == 2 || json[i].departamento == 12 || json[i].departamento == 5){
								fila += '<div id="pointer"><span class="horizontal"></span></div>';
							}
			                 fila += '<div class="prod-img view view-second">'+
			                 	'<img id="img" data-src="{{asset("articulos_img/")}}/'+json[i].departamento+'/'+json[i].articulo +'.jpg" class="lazyload">'+
			                 '</div>'+
			                 '<div class="prod-info">'+
				                 '<h5 class="text-capitalize">'+json[i].descripcion_corta+'</h5>'+
								 '<h6>Modelo: ' + json[i].modelo + '</h6>'+
								 '<h6>Cod: ' + json[i].articulo + '</h6>'+
								 '<p><small>' + precio_lista + '</small> <i class="fas fa-arrow-right"></i> <span>' + precio_contado + '</span><p> '+
			                 '</div>'+
					 '</a>'+
			                 '<div class="bt-shop">'+
			                     '<button type="button" onclick=detalle_producto('+ articulo +','+ grupo +') class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al carrito</button>'+
			                 '</div>'+
			         	 '</div>'+
					'</div>'+
				'</div>';

        lista += fila;
    }
    $('#articulos').html(lista);
}



function detalle_producto(articulo,grupo){
	$("#cant_sel").val(1);
	$.ajax({
		url: '/Articulo',
		dataType: 'json',
		data:{
			'articulo': articulo,
			'grupo': grupo,
			'tipo': 1
		},
		success: function (respuesta) {
			art_info = respuesta.articulo[0];
			bodega = respuesta.bodega;
			const carro = JSON.parse(localStorage.getItem('carrito'));
			if(carro === null){
				desp_modal_info(respuesta.articulo[0]);
			}else{
				var encuentra = carro.find(art => art.id === articulo);
				if(encuentra){
					if(parseInt(encuentra.cantidad) === parseInt(art_info.exist)){
						swal('Solo se encuentra '+parseInt(art_info.exist) + ' articulo en existencia.', {
						  buttons: {
								confirm: {
								text: "Aceptar",
								value: true,
								visible: true,
								className: "",
								closeModal: true
							  }
						  },
						});
					}else{
						desp_modal_info(respuesta.articulo[0]);
					}
				}else{
					desp_modal_info(respuesta.articulo[0]);
				}
			}
		}
	});
}

function desp_modal_info(art_info){
	img = art_info.departamento+'/'+art_info.articulo+'.jpg';
	$("#existencias_art").val(art_info.exist);
	$("#img_modal_confirmacion").attr('src', "{{asset('articulos_img')}}/"+img);
	$("#img_modal").attr('src', "{{asset('articulos_img')}}/"+img);
	$("#nombre_art").text(art_info.descripcion_corta);
	$("#codigo_art").text('Cod: '+art_info.articulo);
	$("#precio_contado").text(formatPesos.format(art_info.precio_contado));
	$("#ModalShopping").modal("show");
	$("#hart").attr('href', '/Articulo/'+art_info.articulo+'/'+art_info.grupo);
	formatPesos.format(art_info.precio_contado);
	nombre_articulo = art_info.descripcion_corta;
	existencias = art_info.exist;
	// img_carrito_confirmacion = respuesta.articulo.img;
	articulo_carrito = art_info.articulo;
	precio_articulo_c = art_info.precio_contado;
	// console.log(precio_articulo_c);
	precio_carrito = art_info.precio_contado;
	cantidad_carrito = $("#cant_sel").val();
	valida_info_ajax();
}


</script>
@endsection
