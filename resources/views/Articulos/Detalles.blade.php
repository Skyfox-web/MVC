@extends('Shared/Layout')


@section('titulo')

@if($isExist)

- {{$articulo[0]->descripcion_corta}}
@endif
@endsection







<!--body--><!--body--><!--body-->

@section('seccion')

<div class="map-art">
@if($isExist)
<input type="hidden" id='id_dep' value='{{$articulo[0]->departamento}}'>
<input type="hidden" id='id_grup' value='{{$articulo[0]->grupo}}'>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<a href="{{ url('/') }}"> INICIO </a> / <a href="{{url('/Departamento')}}/{{$articulo[0]->departamento}}/{{$articulo[0]->grupo}}"> {{$grupo}} </a> / {{$articulo[0]->descripcion_corta}}
		</div>
	</div>
</div>
</div>


<div class="container">
	<div class="row cont_artG">
		<div class="col-md-7" >
			<div class="productIMG" id="show-Result">
				<a href="{{ asset('articulos_img/')}}/{{$articulo[0]->departamento}}/{{$articulo[0]->articulo}}.jpg" data-lity data-lity-desc="Foto de producto">
					<img id="myimage" src="{{ asset('articulos_img/')}}/{{$articulo[0]->departamento}}/{{$articulo[0]->articulo}}.jpg" alt=""></img>
				</a>
				<small class="display-off-mobil">Pasa el mouse sobre la imágen para hacer zoom</small><br>
				<small>Los artículos de decoración se venden por separado</small>
			</div>
		</div>

		<!--info articulo-->
		<div class="col-md-5 Det_Art">
			<div id="myresult" class="img-zoom-result"></div>

			<h4 class="text-capitalize">{{$articulo[0]->descripcion_corta}}</h4>
			<p>Cod: {{$articulo[0]->articulo}}</p>
			<span id="precio_lista_det"></span>
			<h3 id="precio_c"></h3>
			<input type="hidden" id="precio_contado" value="{{$articulo[0]->precio_contado}}">

			<input type="hidden" id="existencias" value="{{$articulo[0]->exist}}">

			<p><small>Precio de riguroso contado exclusivo para Muebleria-Villarreal.com</small></p>
			<!-- @if($articulo[0]->departamento == 2 || $articulo[0]->departamento == 12 || $articulo[0]->departamento == 5)
				<h6 class="vigencia_date">Vigencia hasta el: 24/12/2020</h6>
			@else
				<h6 class="vigencia_date">Vigencia hasta el: 8/1/2021</h6>
			@endif -->

			<!-- <h6 class="vigencia_date">Vigencia hasta el: 8/1/2021</h6> -->
			<h6 class="vigencia_date" id="fechaVIG"> </h6>
			<hr>
			<div class="table-responsive mb-2">
				<!--info de credito-->
				<table class="table table-sm table-borderless">
					<tbody>
						<tr>
							<td class="pl-0 pb-0 mvc-icon">
								<img class="d-block w-100 " src="../../img/icons/mvc.png">
							</td>
							<td>
								Cómpralo con crédito Villarreal desde</br>
								<strong style="color:#003987;">{{$articulo[0]->plazo}} Meses de ${{$abonos}}</strong></br>
								(${{$enganche}} <strong>Enganche</strong>)</br>
								<a href=""  data-toggle="modal" data-target="#modal-info">Más información</a>
							</td>
						</tr>
					</tbody>
				</table>
				<hr>
			</div>
			<!--boton de compra y cantidad-->
			<div class="row">
				<div class="col-md-12 col-lg-7 col-lx-6 pt-4">
					<h6>Cantidad:</h6>
					<div class="def-number-input number-input count-pr">
						<button id="boton_menos" onclick="cant(false)" class="minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
						<input  id="cant_sel_det" class="quantity" min="1" name="quantity" value="1" >
						<button id="boton_mas" onclick="cant(true)" class="plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
					</div>

				</div>
				<div class="col-md-12 col-lg-5 col-lx-5 pt-4">
					<h6 class="textPD">Producto disponible</h6>
					<div class="bt-shop2">
						<button id="agregarCarrito" onclick="agregaralCarrito()" type="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al carrito</button>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 pt-4">
					<p><i class="fa fa-lock" aria-hidden="true"></i> Tu compra está protegida</p>
				</div>
			</div>
		</div>
		<!--End info articulo-->
	</div>
</div>

<div class="container" style="padding-top:20px;">
	<div class="row cont_artG">
		<div class="col-md-8 carct-art">
			<h5>Características del artículo</h5>
			<ul id="car">

			</ul>
		</div>

		<div class="col-md-3 carct-art">
			<h5>Beneficios</h5>
			<table class="vent-index">
				<thead>
  				<tr>
    				<th>
						<img src="{{ asset('img/icons/icon-1.png') }}" alt="">
					</th>
    				<th>
						<h5>Envío gratis</h5>
						<span>Cd.Victoria y Matamoros</span>
					</th>
  				</tr>
				</thead>
			</table>
			<table class="vent-index">
				<thead>
					<tr>
						<th>
							<img src="{{ asset('img/icons/icon-2.png') }}" alt="">
						</th>
						<th>
							<h5>Envío a todo Tamaulipas</h5>
							<span>Hasta la puerta de tu casa</span>
						</th>
					</tr>
				</thead>
			</table>
			<table class="vent-index">
				<thead>
					<tr>
						<th>
							<img src="{{ asset('img/icons/icon-3.png') }}" alt="">
						</th>
						<th>
							<h5>Compra fácil y segura</h5>
							<span>Toda tu información protegida</span>
						</th>
					</tr>
				</thead>
			</table>
			<table class="vent-index">
				<thead>
					<tr>
						<th>
							<img src="{{ asset('img/icons/icon-4.png') }}" alt="">
						</th>
						<th>
							<h5>Hasta 1 año de garantía</h5>
							<span>En productos seleccionados</span>
						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!--te recomendamos-->
<div class="container">
	<h3 class="tit-prin">Te recomendamos</h3>
	<div class="row">

			@if($articuloss != [])
				@foreach($articuloss as $key => $a)
					@if($key == 5)
						@break;
					@endif
						@if($key != 0)
						<div class="col-xl-3 col-md-6  col-sm-6 prod ">
							<a href="/Articulo/{{$a->articulo}}/{{$a->grupo}}"></a>
							<div class="prod-art">
								<a href="/Articulo/{{$a->articulo}}/{{$a->grupo}}"></a>
								<div class="prod-arts">
									<a href="/Articulo/{{$a->articulo}}/{{$a->grupo}}">
										<div class="prod-img view view-second">
											<img id="img" data-src="{{asset('articulos_img/')}}/{{$a->departamento}}/{{$a->articulo}}.jpg" class=" lazyloaded" src="{{asset('articulos_img/')}}/{{$a->departamento}}/{{$a->articulo}}.jpg">
										</div>
										<div class="prod-info">
											<h5 class="text-capitalize">{{$a->descripcion_corta}}</h5>
											<h6>Modelo: {{$a->modelo}}</h6>
											<h6>Cod: {{$a->articulo}}</h6>
											<p>
												<small>${{number_format($a->precio_lista, 2, '.', ',')}}</small>
												<i class="fas fa-arrow-right"></i>
												<span>${{number_format($a->precio_contado, 2, '.', ',')}}</span>
											</p>
											<p>
											</p>
										</div>
									</a>
									<!-- <div class="bt-shop">
										<button type="button" onclick="href({{$a->articulo}}, {{$a->grupo}})" class="btn btn-primary">
											<i class="fa fa-shopping-cart" aria-hidden="true"></i> Ver artículo
										</button>
									</div> -->
								</div>
							</div>
						</div>
						@endif
				@endforeach
			@else

			@endif
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-info" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
	  </button>
      <div class="modal-body modalbody-detalles">
        <h5 class="modal-detalle">¿Quieres tu crédito?</h5>
		<p>Puedes solicitar tu crédito en cualquiera de <a href="{{ url('Empresa/Sucursales') }}">nuestras sucursales</a>.</p>
		<h6 class="modal-subtitle-detalles">¿Tienes dudas?</h6>
		<p>Háblanos vía <a href="javascript:$zopim.livechat.window.show();">
		   chat
		</a> y te ayudaremos con todas tus dudas.</p>
		<p class="horario-atencion">Horario de atención 8:00 a 23:00 horas</p>
		<!-- <button type="button" id="btn-iframe-chat">chat</button> -->
      </div>
    </div>
  </div>
</div>


<input type="hidden" name="" id="caracteristicas" value="{{$articulo[0]->descripcion}}">
<input type="hidden" name="" id="articulo_carrito" value="{{$articulo[0]->articulo}}">
<input type="hidden" name="" id="precio_articulo_c" value="{{$articulo[0]->precio_contado}}">
<input type="hidden" name="" id="precio_articulo_l" value="{{$articulo[0]->precio_lista}}">
<input type="hidden" name="" id="bodega" value="{{$bodega}}">
@else
<div class="container" id="noEnc">
	<div class="row justify-content-md-center">
		<div class="col-md-12">
			<div class="busqueda-panel-nf">
				<h3>Tu búsqueda</h3>
				<h5>{{$descripcion_art}}</h5>
				</br>
				<h4 class="text-center">Este artículo ya no se encuentra disponible</h4>
				<p class="text-center">Navega en muebleria-villarreal.com y encuentra productos similares.</p>
				<div class="btn-midle-car">
					@if($isArt)
					    <a class="btn btn-primary" type="button" name="button" href="/Departamento/{{$departamento}}/{{$grupo}}">Seguir explorando</a>
					@else
					    <a class="btn btn-primary" type="button" name="button" href="/">Seguir explorando</a>
					@endif
				</div>
				<div class="row " id="list_art">

					@if($isArt)

					    @foreach($articulos as $key => $articulo)

					        @if($key == 4)
					            @break;
					        @endif

					            <div class="col-xl-3 col-md-6  col-sm-6 prod ">
					                <a href="/Articulo/{{$articulo->articulo}}/{{$articulo->grupo}}"></a>
					                <div class="prod-art">
					                    <a href="/Articulo/{{$articulo->articulo}}/{{$articulo->grupo}}"></a>
					                    <div class="prod-arts">
					                        <a href="/Articulo/{{$articulo->articulo}}/{{$articulo->grupo}}">
					                            <div class="prod-img view view-second">
					                                <img id="img" data-src="{{asset('articulos_img/')}}/{{$articulo->departamento}}/{{$articulo->articulo}}.jpg" class=" lazyloaded" src="{{asset('articulos_img/')}}/{{$articulo->departamento}}/{{$articulo->articulo}}.jpg">
					                            </div>
					                            <div class="prod-info">
					                                <h5 class="text-capitalize">{{$articulo->descripcion_corta}}</h5>
					                                <h6>Modelo: {{$articulo->modelo}}</h6>
					                                <h6>Cod: {{$articulo->articulo}}</h6>
					                                <p>
					                                    <small>${{number_format($articulo->precio_lista, 2, '.', ',')}}</small>
					                                    <i class="fas fa-arrow-right"></i>
					                                    <span>${{number_format($articulo->precio_contado, 2, '.', ',')}}</span>
					                                </p>
					                                <p>
					                                </p>
					                            </div>
					                        </a>
					                        <div class="bt-shop">
					                            <button type="button" onclick="href({{$articulo->articulo}}, {{$articulo->grupo}})" class="btn btn-primary">
					                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> Ver artículo
					                            </button>
					                        </div>
					                    </div>
					                </div>
					            </div>

					    @endforeach
					@endif


				</div>
				<!-- <p class="text-center">Consejos de Búsqueda:</p>
				<p class="text-center">- Usa palabras más simples y revisa tu ortografía.</p>
				<p class="text-center">- Busca términos más genéricos (ej. "blanco" o "silla")</p> -->
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@section('scripts')

<script type="text/javascript">

</script>

<script type="text/javascript">
$('#modal-info').on('shown.bs.modal', function () {
$('#modal-info').trigger('focus')
})
</script>
<script type="text/javascript">
var date = new Date();
var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
var lastDayWithSlashes = (lastDay.getDate()) + '/' + (lastDay.getMonth() + 1) + '/' + lastDay.getFullYear();
document.getElementById("fechaVIG").innerHTML = "Vigencia hasta el: " + lastDayWithSlashes;

</script>

<script>
var id_dep = $('#id_dep').val();
var id_grup = $('#id_grup').val();

var articulo_carrito = $("#articulo_carrito").val();
var carrito_art_ind = [];
var precio_carrito = 0;
var carro_temp_comp = [];
const formatPesos = new Intl.NumberFormat('en-US', {
	style: 'currency',
	currency: 'USD'
});

$("#precio_c").text(formatPesos.format($("#precio_articulo_c").val()));
$("#precio_lista_det").text(formatPesos.format($("#precio_articulo_l").val()));
	// inicializa zoom effect en detalles:
	imageZoom("myimage", "myresult");
	$('.img-zoom-result').hide();

	$('#show-Result').mouseover(function () {
		$('.img-zoom-result').show();
	});
	$('#show-Result').mouseout(function () {
		$('.img-zoom-result').hide();
	});


	// console.log($("#precio_contado").val() + " hoalsd");
	var cant_prod = 1;
	var existencias = $("#existencias").val();

	function href(articulo, grupo){
		window.location.href = '/Articulo/'+articulo+'/'+grupo;
	}

	function obtenerCaracteristicas(){
		var car = $("#caracteristicas").val();

		var arrCar = [];
		var aux = 0;
		var elem = "";
		for (var i = 0; i < car.length; i++) {
			if(car.includes("|")){

				if(car[i] != '|'){
					elem += car[i];
					if(i === car.length-1){
						arrCar[aux] = elem;
						elem = "";
						aux++;
					}
				}else{
					arrCar[aux] = elem;
					elem = "";
					aux++;
				}
			}
		}
		if(!car.includes("|")){
			arrCar = [car];
		}
		// console.log(arrCar);
		colCaracteristicas(arrCar);

	}

	function colCaracteristicas(carArr){
		var lista = "";
		// console.log(carArr);
		if(carArr.length != 0){
			for (var i = 0; i < carArr.length; i++) {
				lista += '<li>' +  carArr[i] + '</li>';
			}
			// console.log(lista);
			$("#car").html(lista);
		}
	}

	function cant(val){
		existencias = $("#existencias").val();
		if(val){
			if(cant_prod == existencias-1){
				$("#boton_mas").prop("disabled", true );
			}else{
				$("#boton_menos").prop("disabled", false );
			}
			cant_prod++;
			$('#cant_sel_det').val(cant_prod);
		}else{
			if(cant_prod != 2){
				cant_prod--;
				$('#cant_sel_det').val(cant_prod);
				// console.log(cant_prod);
			}else{
				cant_prod--;
				$('#cant_sel_det').val(cant_prod);
				$("#boton_menos").prop("disabled", true );
				$("#boton_mas").prop("disabled", false );

			}
		}


	}



	function validaciones(){
		if(cant_prod == existencias){
			$("#boton_mas").prop("disabled", true );
		}

		if($("#precio_contado").val() == 0){
			$("#precio_c").html("Nota: No se pudo obtener el precio del producto.");
			$("#agregarCarrito").hide();
			$("#disp_prod").hide();
		}
	}

	$( document ).ready(function(){
		$("#cant_sel_det").prop("disabled", true );
		$("#boton_menos").prop("disabled", true );

		validaciones();


		obtenerCaracteristicas();
    });


	function agregaralCarrito(){

		var cantidad_carrito = $("#cant_sel_det").val();

		const carro = JSON.parse(localStorage.getItem('carrito'));


	    if(carro === null){
	        afCarritoVal(cantidad_carrito);
	    }else{
	        var encuentra = carro.find(art => art.id === articulo_carrito);
	        if(encuentra){

	            // console.log(parseInt(encuentra.cantidad), parseInt(cantidad_carrito), parseInt(existencias), (parseInt(encuentra.cantidad)+parseInt(cantidad_carrito)) > parseInt(existencias));
	            // return false;
	            if((parseInt(encuentra.cantidad)+parseInt(cantidad_carrito)) > parseInt(existencias)){
					var msg = '';
					if(parseInt(existencias) < 2){
						msg = 'Solo se encuentra '+parseInt(existencias) + ' artículo en existencia.';
					}else {
						msg = 'Solo se encuentran '+parseInt(existencias) + ' artículos en existencias.'
					}


					Swal.fire({
	                    allowOutsideClick: false,
	                    allowEscapeKey: false,
	                    allowEnterKey: false,
	                    icon: 'warning',
	                    text: msg ,
	                })

	            }else{
	                afCarritoVal(cantidad_carrito);
	            }
	        }else{
	            afCarritoVal(cantidad_carrito);
	        }
	    }
	}

	function afCarritoVal(cantidad_carrito){

		var precio_articulo_c = $("#precio_articulo_c").val();
		var precio_carrito = $("#precio_articulo_c").val();
		var existencias = $("#existencias").val();
		var bodega = $("#bodega").val();
		precio_carrito *= parseInt(cantidad_carrito);


	    if(!localStorage.getItem("art")){
	        guardaArtCart();
	        guardaCarritoLocalStorage(articulo_carrito, precio_carrito, precio_articulo_c, parseInt(cantidad_carrito), existencias, bodega, id_grup, id_dep, false, 0);
	    }else{
	        var carrArtIn = JSON.parse(localStorage.getItem("art"));

	        if(!carrArtIn.includes(articulo_carrito)){
	            guardaArtCart();
	            guardaCarritoLocalStorage(articulo_carrito, precio_carrito, precio_articulo_c, cantidad_carrito, existencias, bodega, id_grup, id_dep, false, 0);
	        }else{
	            // console.log('existe', localStorage.getItem('art'));

	            if(localStorage.getItem("carrito")){
	                // console.log("entra if getitem");
	                pos = carrArtIn.indexOf(articulo_carrito);
	                // console.log(pos);
	                var carro = JSON.parse(localStorage.getItem("carrito"));
	                localStorage.removeItem("carrito");
	                for (var i = 0; i < carro.length; i++) {
	                    if(carro[i].id == articulo_carrito){
	                        cant_carr = parseInt(cantidad_carrito) + parseInt(carro[i].cantidad);
	                        total = parseInt(carro[i].precio_unitario) * cant_carr;
							var art = new articuloCarrito(carro[i].id, 
							total, 
							carro[i].precio_unitario, 
							cant_carr, 
							carro[i].exist, 
							carro[i].bodega, 
							carro[i].grupo, 
							carro[i].departamento, 
							carro[i].codigo, 
							carro[i].desc);
	                    }else{
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
	                    }
	                    carro_temp_comp.push(art);
	                    localStorage.setItem("carrito", JSON.stringify(carro_temp_comp));
	                    // console.log(JSON.parse(localStorage.getItem('carrito')));
	                }
	            }
	            carro_temp_comp = [];
	            // totalesHeader();
	        }
	    }


	    // console.log('Articulo: ' + articulo_carrito + ' | Precio: '+ precio_carrito + ' | Cantidad: ' + cantidad_carrito);
	    // console.log(isAuth);
	    if(isAuth > 0){
	        // console.log("Auth");
	        var articulos_local = JSON.parse(localStorage.getItem("carrito"));

	        var carritoGuardado = localStorage.getItem("cguard");

	        // Si el carrito no se ha registrado en localStorage envía la lista de articulos seleccionados
	        if(!carritoGuardado){
	            // console.log("!carritoGuardado");
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

						Swal.fire({
		                    allowOutsideClick: false,
		                    allowEscapeKey: false,
		                    allowEnterKey: false,
		                    icon: 'success',
		                    text: 'Se ha agregado el artículo a su carrito.' ,
		                })


	                },
	            });
	        }else{
	            // console.log("carritoGuardado");
				// si ya se encuentra registrado envía un solo artículo
				var articulos_local = JSON.parse(localStorage.getItem("carrito"));
				console.log(id_dep, id_grup);
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
						'articulos_local': articulos_local,
						'grupo': id_grup,
						'departamento': id_dep
	                },
	                success: function (respuesta) {
	                    // cambiar divs de modal carrito, mostrar el modal de carrito guardado.
	                    totalesHeader();

						Swal.fire({
			                allowOutsideClick: false,
			                allowEscapeKey: false,
			                allowEnterKey: false,
			                text: 'Se ha agregado el artículo a su carrito.',
			            })

	                },
	            });
	        }
	    }else{
			totalesHeader();
			Swal.fire({
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false,
				text: 'Se ha agregado el artículo a su carrito.',
			})
		}

	}




</script>

@endsection

