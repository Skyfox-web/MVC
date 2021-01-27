@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- Carrito
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')
  <!--Esto es en caso de no tener articulos en el carrito -->
  <div class="container" id="noCart" style="display:none;">
      <div class="row">
          <div class="col-md-12 Carr-1">
              <h3>Tu carrito</h3>
              <h4 class="text-center">Tu carrito está vacío.</h4>
              <p class="text-center">Navega en muebleria-villarreal.com y agrega los productos que buscas.</p>
              <div class="btn-midle-car">
                  <a class="btn btn-primary" type="button" name="button" href="{{ url('') }}">Seguir comprando</a>
              </div>
          </div>
      </div>

      <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
              <a href="{{ url('Dinamica') }}">
                  <div class="carousel-item active">
                      <img class="d-block w-100" src="../img/banners/BanE0.png" alt="First slide">
                  </div>
              </a>
          </div>
      </div>

      <!-- <h3 class="tit-prin">Te recomendamos</h3>
      <div class="row">

          <div class="col-md-3 col-sm-6 prod ">
              <a href="">
                  <div class="prod-art">
                      <div class="prod-arts">
                          <div class="prod-img view view-second">
                              <img class="img-fluid" src="../img/prod-P/84753.jpg">
                          </div>
                          <div class="prod-info">
                              <h5>Recamara KS</h5>
                              <h6>Cod: 85858</h6>
                              <p><small>$17,829.00</small> <i class="fas fa-arrow-right"></i> <span>$10,699.00</span></p>
                          </div>
              </a>
              <div class="bt-shop">
                  <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al carrito</button>
              </div>
          </div>
      </div>
    </div>
  </div> -->
  </div>

  <input type="hidden" class='isAuth' value="{{$isAuth}}">

  <!--Esto es en caso de tener el carrito con articulos -->

  <div class="container" id="isCart">
      <input type="hidden" id="lista_carrito_articulos" value='{{ $lista_carrito }}'>
      <div class="row">
          <div class="col-md-12 Carr-1">
              <h3>Tu carrito</h3>
              <div class="card">
                  <div class="card-body panel-car-1">
                      <h5>¡Enví­o gratis a Cd.Victoria y Matamoros!</h5>
                      <!-- @if(auth()->user())
                        <a type="button" class="btn btn-primary float-right" href="{{url('/CarritoCheckOut')}}">Pagar</a>
                      @else
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#staticBackdrop">Pagar</button>
                      @endif -->
                  </div>
              </div>
          </div>
      </div>

      <div class="art-cartito">
          <div class="row carrito-title-prod">
              <div class="col-xs-12 col-sm-4 col-md-5">Producto </div>
              <div class="col-xs-8 col-sm-2 text-center col-md-2" abbr="Precio unitario">Precio unitario</div>
              <div class="col-xs-8 col-sm-1 col-md-1 text-center" abbr="Cantidad">Cantidad </div>
              <div class=" col-xs-3 col-sm-3 text-center col-md-3 text-center" abbr="Precio total">Total</div>
          </div>
          <!-- Esto seria cada uno de los articulos que tiene el cliente en el carrito-->
          <div class="" id="auth_art" style="display:none;">
              @if(auth()->user())
              @if($lista_carrito)
              @foreach($lista_carrito as $articulos)
              <div class="art-car" id="art_car{{$articulos['id_articulo']}}">
                  <div class="row">

                      <!--info basica del articulo-->
                      <div class="col-xs-12 col-sm-4 col-md-5">
                          <div class="car-art">
                              <div class="car-img">
                                  <img class="img-fluid" src="{{ asset($articulos['img']) }}">
                              </div>
                              <div class="carPI">
                                  <h5 id="nom_art_ca">{{ $articulos['nombre_articulo'] }}</h5>
                                  <p id="cod_art">Cod: {{ $articulos['id_articulo'] }}</p>
                                  <!-- <a onclick="delArt({{$articulos['id_articulo']}})"><i class="fas fa-trash"></i> Eliminar</a> -->
                              </div>
                          </div>
                      </div>
                      <!--valor unitario-->

                      <div class="col-xs-8 col-sm-2 text-center col-md-2 art-midle" abbr="Precio unitario" id="uni_art{{$articulos['id_articulo']}}"> ${{ $articulos['precio_unitario'] }}</div>
                      <!--Cantidad de arituclos-->
                      <div class="col-xs-8 col-sm-1 col-md-1 text-center art-midle" abbr="Cantidad">
                          <div class="def-number-input number-input count-pr-min">
                              <input type="hidden" id="{{$articulos['id_articulo']}}totex" value="{{ $articulos['total_existencias'] }}">

                              <input  type="number" id="id{{$articulos['id_articulo']}}" onfocusout="valida_vacio({{$articulos['id_articulo']}})" onfocus="upStore({{$articulos['id_articulo']}})"
                                  onkeyup="upCart({{$articulos['id_articulo']}}, {{$articulos['id']}})" class="quantity" min="1" max="{{ $articulos['total_existencias'] }}" name="quantity" value="{{ $articulos['cant'] }}">

                          </div>
                      </div>
                      <!--Total-->
                      <div class="col-xs-3 col-sm-3 text-center col-md-2 art-midle" abbr="Precio total" id="tot_art{{$articulos['id_articulo']}}">${{ $articulos['precio_venta'] }}
                          <div class="spiner_" style="display:none;" id="loading_{{$articulos['id_articulo']}}">
                              <div class="ball_"></div>
                          </div>
                      </div>

                      <div class="col-xs-3 col-sm-1 text-center col-md-2 art-midle Elim-AST" id="tot_art{{$articulos['id_articulo']}}">
                          <a onclick="delArt({{$articulos['id_articulo']}})"><i class="fas fa-trash"></i></a>
                      </div>

                  </div>
              </div>
              @endforeach
              @endif
              @endif
          </div>
          <div id="local_art">

          </div>

      </div>

      <div class="row justify-content-between">
          <div class="col-md-5">
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
          <div class="col-lg-6 col-xl-4 col-md-8" id="res_comp_auth">
            <div class="CarrCOMP ">
                <h4>Resúmen de compra</h4>
                <div class="ResCOM">

                      <table>
                          <tbody>
                              <tr class="Csub">
                                  <td>Subtotal:</td>
                                  <td class="text-right" id="pre_sub_fin">${{ $subtot }}</td>
                              </tr>
                              <tr class="CIVA">
                                  <td>IVA:</td>
                                  <td class="text-right " id="pre_iva_fin">${{ $iva_tot }}</td>
                              </tr>
                              <tr class="CTot">
                                  <td>Total de contado:</td>
                                  <td class="text-right " id="pre_tot_fin">${{$total_final}}</td>
                              </tr>
                          </tbody>
                      </table>

                  </div>
                <!--CUPON DE DESCUENTO-->
                <div class="input-group input-cupon-descuento">
                        <div class="form-group input-group">
                            <input id="codigo_descuento_auth" type="text" class="form-control input-rfccss"  autocomplete="off"  required autocomplete="off">
                            <!-- <span id="loader-rfc" style="visibility: hidden;" class="fas fa-spinner loader-icon rotating-lader-Rfc"></span>
                            <span id="load-AprobadoRFC" style="visibility: hidden;" class="fas fa-check loader-icon check-green"></span> -->
                            <label class="label_rfcCSS" for="">Codigo de descuento* </label>
                            <button class="btn btn-outline-secondary btn-rfccss" type="button" onclick="aplica_codigo()" id="" style="right:0px;">Aplicar</button>
                        </div>
                        <span class="inptValid nombre" style="display:none;">Codigo de descuento no valido</span>
                        <!-- <button type="button" class="btn btn-info" onclick="busca_frc()" name="button">Buscar</button> -->
                </div>
                <a href="{{url('/CarritoCheckOut')}}" type="button" class="btn btn-primary" name="button">Continuar</button>
                <a class="text-center" href="{{ url('') }}">Seguir comprando</a>
                <p>*La fecha estimada de entrega puede variar debido a la disponibilidad de los productos, al domicilio de entrega y a la forma de pago.</p>
            </div>
        </div>
        <!--segundo con condicioal-->
        <div class="col-lg-6 col-xl-4 col-md-8" style="display:none;" id="res_comp_local">
            <div class="CarrCOMP ">
                <h4>Resúmen de compra</h4>
                <div class="ResCOM">

                        <table>
                          <tbody>
                              <tr class="Csub">
                                  <td>Subtotal:</td>
                                  <td class="text-right" id="pre_sub_fin_loc"></td>
                              </tr>
                              <tr class="Csub">
                                <td>Descuento:</td>
                                <td class="text-right" id="pre_sub_fin">-$0000</td>
                            </tr>
                              <tr class="CIVA">
                                  <td>IVA:</td>
                                  <td class="text-right " id="pre_iva_fin_loc"></td>
                              </tr>
                              <tr class="CTot">
                                  <td>Total de contado:</td>
                                  <td class="text-right " id="pre_tot_fin_loc"></td>
                              </tr>
                          </tbody>
                      </table>
                </div>
                <!--CUPON DE DESCUENTO-->
                <div class="input-group input-cupon-descuento">
                        <div class="form-group input-group">
                            <input type="text" onchange="" id="codigo_descuento_local" class="form-control input-rfccss"  autocomplete="off"  required autocomplete="off">
                            <!-- <span id="loader-rfc" style="visibility: hidden;" class="fas fa-spinner loader-icon rotating-lader-Rfc"></span>
                            <span id="load-AprobadoRFC" style="visibility: hidden;" class="fas fa-check loader-icon check-green"></span> -->
                            <label class="label_rfcCSS" for="">Codigo de descuento* </label>
                            <button  onclick="aplica_codigo()" class="btn btn-outline-secondary btn-rfccss" type="button" id="" style="right:0px;">Aplicar</button>
                        </div>
                        <span class="inptValid nombre" style="display:none;">Codigo de descuento no valido</span>
                        <!-- <button type="button" class="btn btn-info" onclick="busca_frc()" name="button">Buscar</button> -->
                </div>
                @if(auth()->user())
                  <a type="button" class="btn btn-primary btn-block" href="{{url('/CarritoCheckOut')}}">Pagar</a>
                @else
                  <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#staticBackdrop">Pagar</button>
                @endif
                <!-- <a href="{{url('/CarritoCheckOut')}}" type="button" class="btn btn-primary" name="button">Pagar</a> -->
                <a class="text-center" href="{{ url('') }}">Seguir comprando</a>
                <p>*La fecha estimada de entrega puede variar debido a la disponibilidad de los productos, al domicilio de entrega y a la forma de pago.</p>
            </div>
            </div>
        </div>
      </div>
  </div>


  <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
          <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-body">
                  <div class="Modal-body-cool">
                      <h4 class="title-carrito-modal">¿No has iniciado sesion?</h4>
                      <h5>Compra sin registrarte</h5>
                      <a type="button" onclick="conMod" class="btn btn-dark btn-block" href="{{url('/CarritoCheckOut')}}">Continuar</a>

                      <h5>Inicia sesión para comprar</h5>
                      <a href="{{url('login')}}" type="button" class="btn btn-primary btn-block">Iniciar sesión</a>
                      <a href="#">¿Olvidaste tu contraseña?</a>
                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/carrito/carrito_val.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/promociones/codigos_descuentos.js') }}"></script>
<script>
    var isCompleto = false;
    const formatPesos = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    });
    var banValid = false;
    var total_contado_fin = 0;
    function conMod(){
        $("#staticBackdrop").hide();
    }


    if($(".isAuth").val() === '1'){
        $("#res_comp_auth").show();
        $("#local_art").show();
        $("#auth_art").hide();
        $("#res_comp_local").hide();
        obtArtCart();
        // $("#auth_art").show();
        // $("#local_art").hide();
        // $("#res_comp_auth").show();
        // $("#res_comp_local").hide();
        // $("#local_art").html('');
    }else{
        $("#res_comp_auth").hide();
        $("#local_art").show();
        $("#auth_art").hide();
        $("#res_comp_local").show();
        obtArtCart();
    }

    if(localStorage.getItem('carrito')){
        $("#isCart").show();
        $("#noCart").hide();
    }else{
        $("#isCart").hide();
        $("#noCart").show();
    }


    function delArt(id_articulo){
        localStorage.removeItem('qty_'+id_articulo);
        // console.log($(".isAuth").val());
        if(localStorage.getItem("carrito")){
            var id_carrito = localStorage.getItem('ic');
            if($(".isAuth").val() == '1'){
                // console.log('auth', id_carrito);
                // $('#page-loader').show();
                $.ajax({
                    data: {
                        'id_articulo': id_articulo,
                        'id_carrito':id_carrito
                    },
                    type: 'GET',
                    url: 'delArticulo',
                    success: function(response) {

                        delArtLoc(id_articulo);
                        // $('#page-loader').fadeOut(500);

                    }
                });
            }else{
                delArtLoc(id_articulo);
            }
        }



    }

    function delArtLoc(id_articulo){
        // console.log('local');
        var carro = JSON.parse(localStorage.getItem("carrito"));
        // console.log(carro);
        localStorage.removeItem("carrito");
        localStorage.removeItem('art');


        var carro_temp_loc = [];
        var carrito_art_ind = [];
        var carro_temp = [];
        var sutot_res = 0;
        var iva_res = 0;
        var tot_res = 0;

        if(carro.length != 1){
            for (var i = 0; i < carro.length; i++) {
                if(carro[i].id != id_articulo){
                    carrito_art_ind.push(carro[i].id);
                    var art = new articuloCarrito(carro[i].id, carro[i].total , carro[i].precio_unitario, carro[i].cantidad, carro[i].exist, carro[i].bodega, carro[i].grupo, carro[i].departamento, carro[i].codigo,
                carro[i].desc);

                    carro_temp_loc.push(art);
                    localStorage.setItem("carrito", JSON.stringify(carro_temp_loc));
                    localStorage.setItem('art', JSON.stringify(carrito_art_ind));

                }else{
                    // localStorage.removeItem("carrito");
                }
            }
        }

        // totalesHeader();
        window.location.href = '/carrito';

    }

    function upStore(id_articulo){
        localStorage.setItem('qty_'+id_articulo, $('#id'+id_articulo).val());
    }

    function valida_vacio(id_articulo){
        if($('#id'+id_articulo).val() == 0){
            $('#id'+id_articulo).val(localStorage.getItem('qty_'+id_articulo));
            // console.log(id_articulo);
            $("#loading_"+id_articulo).hide();
        }
    }

    function upCart(id_articulo, id){
        // console.log('olas');
        var id_carrito = localStorage.getItem('ic');
        $("#loading_"+id_articulo).show();
        $("#tot_art"+id_articulo).hide();
        $('#page-loader').show();
        $.ajax({
            data: {
                'id_carrito': id_carrito,
                'id_articulo': id_articulo,
                'id': id,
                'cant': $('#id'+id_articulo).val()
            },
            type: 'POST',
            url: 'ajaxUpCart',
            headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {

                if(!response.estado){
                    if(response.mensaje != 'null'){
                        swal(response.mensaje, {
                          buttons: {
                                confirm: {
                                text: "Aceptar",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                              }
                          },
                        })
                        .then((value) => {
                            $('#id'+id_articulo).val(localStorage.getItem('qty_'+id_articulo));
                        });
                    }

                }else{
                    $("#tot_art"+id_articulo).html(formatPesos.format(response.total));
                    $("#pre_sub_fin").html(formatPesos.format(response.sum_subtot));
                    $("#pre_iva_fin").html(formatPesos.format(response.sum_iva));
                    $("#pre_tot_fin").html(formatPesos.format(response.sum_tot));

                    if(localStorage.getItem("carrito")){
                        var carro = JSON.parse(localStorage.getItem("carrito"));
                        localStorage.removeItem("carrito");
                        carro_temp_loc = [];
                        for (var i = 0; i < carro.length; i++) {
                            if(carro[i].id == id_articulo){
                                var art = new articuloCarrito(carro[i].id, response.total, carro[i].precio_unitario, $('#id'+id_articulo).val());
                            }else{
                                var art = new articuloCarrito(carro[i].id, carro[i].total , carro[i].precio_unitario, carro[i].cantidad);
                            }
                            carro_temp_loc.push(art);
                            localStorage.setItem("carrito", JSON.stringify(carro_temp_loc));
                            // console.log(JSON.parse(localStorage.getItem('carrito')));

                        }
                        totalesHeader();
                    }

                }
                $("#loading_"+id_articulo).hide();
                $("#tot_art"+id_articulo).show();

                // $('#page-loader').fadeOut(500);
            }
        });

    }

    function obtArtCart(){

        var subtotal = 0;
        var iva_venta = 0;
        var total_cont = 0;
        var html_art_cart = '';
        var cont_art = 0;
        var i = 0;
        var articulos = [];
        if(localStorage.getItem('carrito')){
            cont_art = 0;
            articulos = JSON.parse(localStorage.getItem('carrito'));
            console.log(articulos);
            for (i = 0; i < articulos.length; i++) {
                var id_art_del = articulos[i]['id'];
                $.ajax('/totart', {
                    type: 'GET',
        			data:{
        				'articulo' : articulos[i]['id'],
                        'cant': articulos[i]['cantidad']
        			},
                    success: function (data) {


                        if(data.isExistencia){
                            // console.log(' art' . articulos);
                            subtotal += parseFloat(data.subtot);
                            iva_venta += parseFloat(data.iva_venta);
                            total_cont += parseFloat(data.total);
                            // console.log(iva_venta);
                            var precio_uni_art = formatPesos.format(data.precio_unitario);
                            var total_art_ind = formatPesos.format(data.total);
                            html_art_cart += '<div class="art-car" id="art_car'+data.articulo+'">'
                            +'<div class="row" >'
                            +'<div class="col-xs-12 col-sm-4 col-md-5" >'
                            +'<div class="car-art">'
                            +'<div class="car-img">'
                            +'<img class="img-fluid" src="{{ asset('') }}'+data.img+'">'
                            +'</div>'
                            +'<div class="carPI">'
                            +'<h5><a id="nom_art_ca" href="{{url("/Articulo")}}'+'/'+data.articulo+'/'+data.grupo+'" target="_blank">'+data.nombre_articulo+'</a></h5>'
                            +'<p id="cod_art">Cod: '+data.articulo+'</p>'
                            +'</div>'
                            +'</div>'
                            +'</div>'

                            +'<div class="col-xs-8 col-sm-2 text-center col-md-2 art-midle" abbr="Precio unitario" id="uni_art">'+precio_uni_art+'</div>'

                            +'<div  class="col-xs-8 col-sm-2 col-md-1 text-center art-midle" abbr="Cantidad">'
                            +'<div class="def-number-input number-input count-pr-min">'
                            +'<input type="hidden" id="totex" value="">'
                            // if($(".isAuth").val() == 1){
                            //     html_art_cart += '<input type="number" id="id'+data.articulo+'" onfocusout="valida_vacio('+data.articulo+')" onfocus="upStore('+data.articulo+')" onkeyup="upCart('+data.articulo+')" class="quantity" min="1" name="quantity" value='+ data.cantidad +'>';
                            // }else{
                            //     html_art_cart += '<input type="number" id="id'+data.articulo+'" onfocusout="valida_vacio('+data.articulo+')" onfocus="upStore('+data.articulo+')" onkeyup="upCartLoc('+data.articulo+')" class="quantity" min="1" name="quantity" value='+ data.cantidad +'>';
                            // }
                            html_art_cart += '<input type="number" id="id'+data.articulo+'" onfocusout="valida_vacio('+data.articulo+')" readonly disabled onfocus="upStore('+data.articulo+')" onkeyup="upCart('+data.articulo+')" class="" min="1" name="quantity" value='+ data.cantidad +'>';
                            html_art_cart += '</div>'
                            +'</div>'
                            +'<div class="col-xs-3 col-sm-1 text-center col-md-3 art-midle" abbr="Precio total" id="tot_art'+data.articulo+'">'+total_art_ind
                            +'<div class="spiner_" style="display:none;" id="loading_'+data.articulo+'">'
                            +'<div class="ball_"></div>'
                            +'</div>'
                            +'</div>'

                            +'<div class="col-xs-1 col-sm-3 text-center col-md-1 art-midle Elim-AST" id="tot_art'+data.articulo+'">';

                            if($(".isAuth").val() == '1'){
                                // console.log('auth for');
                                html_art_cart += '<a onclick="delArt('+data.articulo+')"><i class="fas fa-trash"></i></a>';
                            }else{
                                // console.log('local for');
                                html_art_cart += '<a onclick="delArtLoc('+data.articulo+')"><i class="fas fa-trash"></i></a>';
                            }

                            html_art_cart += '</div>'
                            +'</div>'
                            +'</div>';

                            // console.log(html_art_cart);
                            $("#local_art").html(html_art_cart);
                            $("#local_art").show();

                            $('#pre_sub_fin_loc').html(formatPesos.format(subtotal));
                            $('#pre_iva_fin_loc').html(formatPesos.format(iva_venta));
                            $('#pre_tot_fin_loc').html(formatPesos.format(total_cont));
                            total_contado_fin = total_cont;
                        }else{

                            Swal.fire({
    		                    allowOutsideClick: false,
    		                    allowEscapeKey: false,
    		                    allowEnterKey: false,
    		                    icon: 'warning',
    		                    text: 'Uno de los artículos que has seleccionado se ha quedado sin existencias.' ,
    		                }).then((result) => {
                                delArt(id_art_del);
                            })
                        }
                    },
                    error: function () {
                    }
                });
            }



            html_art_cart = '';
        }


    }

    function upCartLoc(id_articulo){
        if($('#id'+id_articulo).val() != 0){
            var carrito_loc = JSON.parse(localStorage.getItem('carrito'));
            $.ajax({
                data: {
                    'articulo': id_articulo,
                    'cant': $('#id'+id_articulo).val(),
                    'carrito': carrito_loc
                },
                type: 'GET',
                url: '/totartLoc',
                headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.estado){
                        if(response.mensaje != 'null'){
                            swal(response.mensaje, {
                              buttons: {
                                    confirm: {
                                    text: "Aceptar",
                                    value: true,
                                    visible: true,
                                    className: "",
                                    closeModal: true
                                  }
                              },
                            })
                            .then((value) => {
                                $('#id'+id_articulo).val(localStorage.getItem('qty_'+id_articulo));
                            });
                        }else{

                            $("#tot_art"+id_articulo).html(formatPesos.format(response.total));
                            $("#pre_sub_fin_loc").html(formatPesos.format(response.subtot));
                            $("#pre_iva_fin_loc").html(formatPesos.format(response.iva_venta));
                            $("#pre_tot_fin_loc").html(formatPesos.format(response.total_compra));

                            if(localStorage.getItem("carrito")){
                                var carro = JSON.parse(localStorage.getItem("carrito"));
                                localStorage.removeItem("carrito");
                                carro_temp_loc = []
                                for (var i = 0; i < carro.length; i++) {
                                    if(carro[i].id == id_articulo){

                                        var art = new articuloCarrito(carro[i].id, response.total, carro[i].precio_unitario, $('#id'+id_articulo).val());
                                    }else{
                                        var art = new articuloCarrito(carro[i].id, carro[i].total , carro[i].precio_unitario, carro[i].cantidad);

                                    }
                                    carro_temp_loc.push(art);
                                    localStorage.setItem("carrito", JSON.stringify(carro_temp_loc));
                                }
                                totalesHeader();
                            }
                        }
                        $("#loading_"+id_articulo).hide();
                        $("#tot_art"+id_articulo).show();
                    }
                }
            });
        }
    }










</script>
@endsection
