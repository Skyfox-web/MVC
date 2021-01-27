<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="{{ asset('mvc.ico') }}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href=" {{ asset('css/bootstrap.min.css') }} " integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Se agrega el css a en la carpeta public/igual que el js-->
    <link href="{{ asset('css/style.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/all.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/fonts.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/bs-stepper.min.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=e42e20ff-862b-4cce-9617-af52a651ae81"> </script> -->
    <link href="{{ asset('css/menu.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('slick/slick.css') }}" media="all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('slick/slick-theme.css') }}" media="all" rel="stylesheet" type="text/css" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-55871020-1"></script>
    <script type="text/javascript" src="{{ asset('js/gtag.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Muebleria Villarreal @yield('titulo')</title>
  </head>
  <body>
    <!-- PRELOADER DE LA PAGINA -->
    <div id="page-loader">
    	<span class="preloader-interior"></span>
    </div>

<!--header MENU-->
@if(auth()->user())
    <input type="hidden" id="isAuth" value="{{ auth()->user()->id }}">
    <input type="hidden" id="isEmail" value="{{ auth()->user()->email }}">
@else
    <input type="hidden" id="isAuth" value="false">
@endif

@include('Shared/Header')




<!--Cuerpo de la pagina--><!--Cuerpo de la pagina--><!--Cuerpo de la pagina-->
@yield('seccion')




<!--footer--><!--footer--><!--footer-->
@include('Shared/Footer')

<div class="modal fade" id="ModalShopping" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-5">
              <div class="prod-img-modal view view-second">
       			      <img class="img-fluid modal_conf" id="img_modal" src="">
       		    </div>
            </div>

            <div class="col-md-7">
              <div class="info-art-modal">
                <h5 id="nombre_art" class="text-capitalize"></h5>
                <h6 id="modelo_art">  </h6>
                <h6 id="codigo_art">Cod:  </h6>
                <span id="precio_contado"></span>
                <input type="hidden" name="" id="existencias_art" >
                <div >
                  <label clas="cant-label" for="">Cantidad:</label>
                  <div class="def-number-input number-input count-pr">
                    <button id="boton_menos" onclick="cant(false)" class="minus"><i class="fa fa-minus" aria-hidden="true"></i></button>
                    <input  id="cant_sel" class="quantity" min="1" name="quantity" value="1">
                    <button id="boton_mas" onclick="cant(true)" class="plus"><i class="fa fa-plus" aria-hidden="true"></i></button>
                  </div>
                </div>
                <button onclick="comprar()" class="btn btn-primary btn-block" name="button">Comprar</button>
                <a id="hart" href="">Ver los detalles del articulo</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalCarrito" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		</button>
      <div class="modal-body">
		   <div class="prod-img view view-second">
			  <img class="img-fluid modal_conf" id="img_modal_confirmacion" src="">
		   </div>
		   <div id="estado1" class="">
			   <h5 id="nombre_art_confirmacion" class="text-capitalize"></h5>
               <h6 id="modelo_art">  </h6>
               <h6 id="codigo_art_confirmacion">Cod:  </h6>
			   <span id="precio_contado_confirmacion"></span>
			   <br>
			   <span id="cantidad_confirmacion"></span>
			   <input type="hidden" name="" id="existencias_art" >
		   </div>

		   <div>
			   <a id="boton_comprar_confirmacion" href="{{ url('carrito')}}" class="btn btn-primary btn-block" name="button">Comprar</a>
			   <!-- <a href="">Ver los detalles del articulo</a> -->
		   </div>
      </div>

    </div>
  </div>
</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/sendingblue.js') }}"></script>
<script type="text/javascript"> var sib_prefix = 'sib'; var sib_dateformat = 'dd-mm-yyyy'; </script>
<script type='text/javascript' src='https://my.sendinblue.com/public/theme/version4/assets/js/src/subscribe-validate.js?v=1607580368'></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/youtube.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/layout.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/image-zoom.js') }}"></script>
<script type="text/javascript" src="{{ asset('slick/slick.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/carrito/carrito_val.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="{{ asset('js/lazysizes.min.js') }}"></script>


@yield('scripts')

<script>
$(function () {
$('[data-toggle="tooltip"]').tooltip()
})

    $(window).on('load', function() {
        $('#page-loader').fadeOut(500);
    });
</script>



<script type="text/javascript">
$('.dropdown-menu ul.list-unstyled li a').on('touchstart', function(e) {
    e.preventDefault();
    window.location.href = $(this).attr('href');
})
</script>

<script>

$( "#inp_bus" ).keypress(function( event ) {
     // Enter has keycode 13
     if ( event.which == 13 ) {
         buscar();
    }
});

  $(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
  });
  if ($(window).width() < 992) {
      $('.has-submenu a').click(function(e){
        e.preventDefault();
          $(this).next('.megasubmenu').toggle();

          $('.dropdown').on('hide.bs.dropdown', function () {
             $(this).find('.megasubmenu').hide();
          })
      });
  }
</script>


<script>
    var carrito = [];
    var isAuth = $("#isAuth").val();
    var precio_articulo_c = 0;
    var id_carrito = false;
    var total = 0;
    var total_art = 0;
    var total_header = 0;
    var email = '';
    email = 'contacto@muebleria-villarreal.com';


    function agregarCarrito(articulo, precio, cantidad){
        $.ajax('/agregarCarrito/'+ articulo + '/' + precio + '/' + cantidad, {
            type: 'POST',
            data:{
                "_token": $('meta[name="csrf_token"]').attr('content')
            },
            success: function (data) {
                console.log(data);
            },
            error: function () {
            }
        });

    }

    validaAuthCarrito();



    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });

    var nom_acc_princ = $("#nombre_persona").text().trim().toLowerCase();
    var genero = $("#genero").text();

    if(parseInt(genero) == 1){
        $("#saludo").text('Bienvenida');
    }else{
        $("#saludo").text('Bienvenido');
    }
    $(document).ready(function(){
        nom_acc_princ = ucFirstAllWords(nom_acc_princ);
        $("#bienvenido").text(nom_acc_princ);
    });

    totalesHeader();


</script>


  </body>
</html>
