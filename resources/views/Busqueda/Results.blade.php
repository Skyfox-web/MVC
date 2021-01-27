@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- {{$text_bus}}
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')

<div class="container">
	<div class="row map-art">
		<div class="col-md-12">
			<a href="{{ url('/') }}"> INICIO </a> > {{$text_bus}}
		</div>
	</div>
</div>
<!-- busqueda no encontrada -->
@if(count($articulos) == 0)
<div class="container" id="noEnc">
	<div class="row justify-content-md-center">
		<div class="col-md-8">
			<div class="busqueda-panel-nf">
				<h3>Tu búsqueda</h3>
				<h4 class="text-center">Tu búsqueda "{{$text_bus}}" arrojó "0" resultados</h4>
				<p class="text-center">Navega en muebleria-villarreal.com y agrega los productos que buscas.</p>
				<div class="btn-midle-car">
					<a class="btn btn-primary" type="button" name="button" href="{{ url('') }}">Seguir explorando</a>
				</div>
				<p class="text-center">Consejos de Búsqueda:</p>
				<p class="text-center">- Usa palabras más simples y revisa tu ortografía.</p>
				<p class="text-center">- Busca términos más genéricos (ej. "blanco" o "silla")</p>
			</div>
		</div>
	</div>
</div>
@else
<div class="container" id="esProd">
  <div class="row">
    <div class="col-md-3" id="lateral">
		<div class="Men-lat">
			<h5>Filtrar por:</h5>
			<!--filtros activos-->
			<div class="">

			</div>
			<div class="active-filters" id="filt_activ">
				<!-- <span id="txt_"><a href="#"><i class="fa fa-times-circle" aria-hidden="true"></i></a>Hola</span> -->
			</div>
			<div class="sub_cat_box">
				<!-- obtener colores de bd y activarlos -->
				<a  class="current"><li>Colores:<i class="fa fa-plus" id="showoff" aria-hidden="true"></i></li></a>
				<ul>
					<div class="circulosColores" id="">
						<div title="Café" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'CAFE')" class="cafe_ Ch-105"></div>
						<div title="Blanco"  data-toggle="tooltip" data-placement="top" onclick="filtros(0, 'BLANCO')" class="blanco_ Ch-105"></div>
						<div title="Rojo" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'ROJO')" class="rojo_ Ch-105"></div>
						<div title="Azul" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'AZUL')" class="azul_ Ch-105"></div>
						<div title="Amarillo" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'AMARILLO')" class="amarillo_ Ch-105"></div>
						<div title="Verde" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'VERDE')" class="verde_ Ch-105"></div>
						<div title="Rosa" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'ROSA')" class="rosa_ Ch-105"></div>
						<div title="Celeste" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'CELESTE')" class="celeste_ Ch-105"></div>
						<div title="Beige" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'BEIGE')" class="beige_ Ch-105"></div>
						<div title="Morado" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'MORADO')" class="morado_ Ch-105"></div>
						<div title="Gris" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'GRIS')" class="gris_ Ch-105"></div>
						<div title="Negro" data-toggle="tooltip" data-placement="top"  onclick="filtros(0, 'NEGRO')" class="negro_ Ch-105"></div>
					</div>
				</ul>

			</div>
			<div class="sub_cat_box" style="display:none;" id="marcas">
				<!-- <div class="" id="lista_marcas">

				</div> -->
				<a  class="current"><li>Marca:<i class="fa fa-plus" id="showoff" aria-hidden="true"></i></li></a>
				<ul>
					<div class="FiltroFC" id="filtro">


					</div>

				</ul>
			</div>
			<div class="sub_cat_box" id="tipo_price">
				<a class="current"><li>Precio: <i  class="fa fa-plus" aria-hidden="true"></i></li></a>
				<ul>
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

		</div>
	</div>

    <div class="col-md-9" >
		<input type="hidden" value="{{$tipo}}" id="tipo">
		<input type="hidden" id="isMarca" name="" value="{{$isMarca}}">
		<input type="hidden" id="lista_marcas" name="" value="{{$lista_marcas}}">
		<input type="hidden" id="txt_bus" name="" value="{{$text_bus}}">

		<div class="row" id="grupos_filtro">
			@if($tipo == 0)
				@foreach($articulos as $val)
					<div class="col-md-6">
						<div class="GrupoSTY">
							<a href="/Departamento/{{$val->departamento}}/{{$val->grupo}}">
								<picture>
									<img  src="{{asset('/grupos_img')}}/{{$val->departamento}}/{{$val->grupo}}.jpg" class="img-fluid" alt="Responsive image">
								</picture>
								<p>{{$val->descripcion}}</p>
							</a>
						</div>
					</div>
				@endforeach
			@endif
		</div>
		@if($tipo == 1)
		<input type="hidden" id="articulos_list" value="{{json_encode($articulos)}}">
		@endif
		<div class="row" id="articulos_filtro">
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
@endif



@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/despliegue_productos.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/carrito/carrito_val.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/filtro.js') }}"></script>

<script>
$(".current").click(function(){
	$(this).next("ul").slideToggle();
});
var pag = 1;
var totales = 0;
var xPag = 9;
var nPag = 0;
var offset = (pag - 1) * xPag;
var hasta = pag * xPag;
var json = [{}];
var color = [];
var marc = [];
var capacidad = [];
var lista_filt_act = [];
var carro = [];
var carrito_art_ind = [];
var precio_min = null;
var precio_max = null;
var largo = null;
var ancho = null;
var area_requerida = '';
var txtAct = '';
var tipo_orden = 0;
var id_g = 0;
var txt_bus = $("#txt_bus").val();
//-------------------------------------
var grupo = 0;
var departamento = 0;
//-------------------------------------

const formatPesos = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD'
});
despliegaInfo();


function despliegaInfo(){
	var tipo = $("#tipo").val();

	if(tipo){
		$("#lateral").show();
		var articulos = $("#articulos_list").val();
		var cont = 0;
		var html_productos = '';
		json = JSON.parse(articulos);
		totales = json.length;
		nPag = Math.ceil(totales / xPag);
		mostrarLista(offset,hasta);
		if(totales > 9){
			$("#paginas_txt").show();
			mostrarBotones(nPag);
			botones_click();
		}else{
			$("#paginas_txt").hide();
		}
	}else{
		$("#lateral").hide();
	}

	if($("#isMarca").val()){
		$("#marcas").show();
		var lista_marcas = JSON.parse($("#lista_marcas").val());
		var html_filtros = '';

		lista_marcas.forEach((item, i) => {
			var marca = "'" + item['marca'] + "'";
			html_filtros += '<label><input class="chk_marca" onclick="filtros(1, '+marca+')" type="checkbox" id="cbox1" value="'+item['marca']+'"> '+item['marca'] +' ('+ item['total'] +')</label><br>';
		});

		$("#filtro").html(html_filtros);
	}
}


function mostrarLista(desde,hasta){
    var lista = '';
	if(hasta > totales){
		hasta = totales;
	}
    for(var i = desde; i < hasta; i++){
        var fila = '';
		grupo = '"' + json[i].grupo + '"';
		articulo = '"' + json[i].articulo + '"';
		precio_contado = formatPesos.format(json[i].precio_contado);
		precio_lista = formatPesos.format(json[i].precio_lista);
        fila += '<div class="col-md-4 col-sm-6 prod ">'+
					'<a href="/Articulo/'+json[i].articulo+'/'+json[i].grupo+'">'+
						'<div class="prod-art">'+
						'<div class="prod-arts">'+
		                 '<div class="prod-img view view-second">'+
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
    $('#articulos_filtro').html(lista);
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
	$("#modelo_art").text('Modelo: '+art_info.modelo);
	$("#codigo_art").text('Cod: '+art_info.articulo);
	$("#precio_contado").text(formatPesos.format(art_info.precio_contado));
	$("#ModalShopping").modal("show");
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
	//-------------------------------------
	grupo = art_info.grupo;
	departamento = art_info.departamento;
	//-------------------------------------
}

</script>


@endsection
