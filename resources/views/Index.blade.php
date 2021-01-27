@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')

@endsection



<!--body--><!--body--><!--body-->
@section('seccion')


<!-- <input type="text" name="" value='{{ $total_prod_carr ?? ''}} '>
<input type="text" name="" value='{{ $tot_venta_carr ?? ''}}'> -->

@include('Shared/Slider')


<!--comerciales--><!--comerciales--><!--comerciales-->



<!--departamento--><!--departamento--><!--departamento-->

<div class="container">

	<div class="row Dep-Slider">

		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/2/55') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/2/86094.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>SALAS</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/2/52') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/2/87091.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>RECAMARAS</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/2/22') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/2/79946.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>COMEDORES</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/4/108') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/4/74213.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>REFRIGERADORES</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/3/86') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/3/86554.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>TELEVISIONES</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/10/144') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/10/87696.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>LAPTOPS</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/7/129') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/7/86309.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>CELULARES</h6>
					</div>
			</div>
			</a>
		</div>
		<div class="col-md-3 col-sm-4 col-3">
			<a href="{{ url('Departamento/8/132') }}">
			<div class="depto-cont">
					<div class="img-depto-cont">
						<img data-src="{{ asset('articulos_img/8/86350.jpg') }}" alt="Sub departamento cocinas integrales" class="lazyload">
					</div>
					<div class="btn-index">
						<h6>COLCHONES</h6>
					</div>
			</div>
			</a>
		</div>
	</div>
</div>

<div class="container">
	<h3 class="tit-prin">Promociones</h3>
	<div class="row justify-content-md-center">
		<div class="col-md-8">
			<div class="comer-cont2">
				<a href="//www.youtube.com/watch?v=czBhCNoTGss" data-lity>
					<i class="fab fa-youtube"></i>
					<img data-src="{{ asset('img/banners/videobg.png') }}" class="img-fluid lazyload" alt="Comercial colchones" >
				</a>
			</div>
		</div>
	</div>
</div>


<!--Articulos--><!--Articulos--><!--Articulos-->

<div class="parallax">
  <div class="container">
		<div class="row">
			<div class="col-md-6">
				<!-- <h3 class="title-parallax">TE RECOMENDAMOS</h3> -->
				<!-- <p>La mejor variedad de prodcutos para tu hogar</p> -->
				<div class="row justify-content-center prod-recomend">

					<!-- <div class="col-md-3 col-sm-6 col-11 prod ">
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
					    <div class="bt-shop">
					          <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al carrito</button>
					        </div>
					    </div>
					</div>
					  </a>
					</div>

						<div class="col-md-3 col-sm-6 col-11 prod ">
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
						    <div class="bt-shop">
						          <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al carrito</button>
						        </div>
						    </div>
						</div>
						  </a>
						</div>

						<div class="col-md-3 col-sm-6 col-11 prod ">
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
						    <div class="bt-shop">
						          <button type="button" class="btn btn-primary"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Agregar al carrito</button>
						        </div>
						    </div>
						</div>
						  </a>
						</div> -->
				</div>
			</div>
			<div class="col-md-6">
				<div class="parallax-info">

				<h2 class="text-right title-parallax">CREA ESPACIOS UNICOS</h2>
				<p class="text-right">"Los detalles no son detalles. Ellos son el diseño."<br> <small>-Charles Eames</small> </p>

				</div>
			</div>
		</div>
  </div>
</div>


<!--Blog--><!--Blog--><!--Blog--><!--Blog-->
<!--
<div class="container">
  <h3 class="tit-prin">Inspiracion</h3>
  <div class="row">

    <div class="col-md-4 artblog1">
      <a href="">
        <div class="art-blog">
          <img class="img-fluid" src="../img/blog/blog-1.jpg">
          <span> 26 / agosto</span>
          <h5>Lorem ipsum dolor</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p>
          <span>Leer mas <i class="far fa-plus-square"></i></span>

        </div>
      </a>
    </div>

    <div class="col-md-4 artblog1">
      <a href="">
        <div class="art-blog">
          <img class="img-fluid" src="../img/blog/blog-1.jpg">
          <span> 26 / agosto</span>
          <h5>Lorem ipsum dolor</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p>
          <span>Leer mas <i class="far fa-plus-square"></i></span>

        </div>
      </a>
    </div>

    <div class="col-md-4 artblog1">
      <a href="">
        <div class="art-blog">
          <img class="img-fluid" src="../img/blog/blog-1.jpg">
          <span> 26 / agosto</span>
          <h5>Lorem ipsum dolor</h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</p>
          <span>Leer mas <i class="far fa-plus-square"></i></span>

        </div>
      </a>
    </div>

  </div>
</div>

-->

<!--comprar--><!--comprar--><!--comprar--><!--comprar-->


<div class="container cont-vent-store">
  <h3 class="tit-prin">Ventajas</h3>
	<div class="row">
		<div class="col-xl-3 col-lg-3 col-md-6">
			<table class="vent-index">
				<thead>
  				<tr>
    				<th>
						<img src="{{ asset('img/icons/icon-1.png') }}" alt="">
					</th>
    				<th>
						<h5>Envio gratis</h5>
						<span>Cd.Victoria y Matamoros</span>
					</th>
  				</tr>
				</thead>
			</table>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6">
			<table class="vent-index">
				<thead>
					<tr>
						<th>
							<img src="{{ asset('img/icons/icon-2.png') }}" alt="">
						</th>
						<th>
							<h5>Envio a todo tamaulipas</h5>
							<span>Hasta la puerta de tu casa</span>
						</th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6">
			<table class="vent-index">
				<thead>
					<tr>
						<th>
							<img src="{{ asset('img/icons/icon-3.png') }}" alt="">
						</th>
						<th>
							<h5>Compra facil y segura</h5>
							<span>Toda tu informacion protegida</span>
						</th>
					</tr>
				</thead>
			</table>
		</div>
		<div class="col-xl-3 col-lg-3 col-md-6">
			<table class="vent-index">
				<thead>
					<tr>
						<th>
							<img src="{{ asset('img/icons/icon-4.png') }}" alt="">
						</th>
						<th>
							<h5>Hasta 1 año de garantia</h5>
							<span>En productos seleccionados</span>
						</th>
					</tr>
				</thead>
			</table>
		</div>

	</div>
</div>



<!--Marcas--><!--Marcas--><!--Marcas--><!--Marcas-->
<!--Marcas--><!--Marcas--><!--Marcas--><!--Marcas-->
<!--
<div class="container">
  <h3 class="tit-prin">Marcas</h3>
  <div class="row">
    <div class="col-md-2 img-logos">
      <img data-src="../img/marcas/boal.png">
    </div>
    <div class="col-md-2 img-logos">
      <img data-src="../img/marcas/mabe.png">
    </div>
    <div class="col-md-2 img-logos">
      <img data-src="../img/marcas/samsung.png">
    </div>
    <div class="col-md-2 img-logos">
      <img data-src="../img/marcas/serta.png">
    </div>
    <div class="col-md-2 img-logos">
      <img data-src="../img/marcas/spring-air.png">
    </div>
    <div class="clearfix"></div>
    </div>
</div>
-->


@endsection


@section('scripts')
<script type="text/javascript">

$('.prod-recomend').slick({
	dots:false,
	arrows: false,
	autoplay: true,
	autoplaySpeed: 2000,
	slidesToShow: 2,
	responsive: [
		{
			breakpoint: 370,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				infinite: true,
			}
		},
	]
});

$('.main-slider').slick({
	dots: false,
	arrows: false,
	autoplay: true,
  autoplaySpeed: 5000
});

$(document).ready(function(){
  $('.Dep-Slider').slick({
		  infinite: true,
		  speed: 300,
		  slidesToShow: 4,
		  slidesToScroll: 4,
		  autoplay: true,
		  autoplaySpeed: 4000,
		  prevArrow:"<button type='button' class='slick-prev pull-left'><i class='fas fa-angle-left'></i></button>",
	  	  nextArrow:"<button type='button' class='slick-next pull-right'><i class='fas fa-angle-right'></i></button>",
		  responsive: [
		    {
		      breakpoint: 1024,
		      settings: {
		        slidesToShow: 3,
		        slidesToScroll: 3,
		        infinite: true,
		      }
		    },
		    {
		      breakpoint: 600,
		      settings: {
						arrows: false,
		        slidesToShow: 2,
		        slidesToScroll: 2
		      }
		    },
		    {
		      breakpoint: 480,
		      settings: {
						arrows: false,
		        slidesToShow: 1,
		        slidesToScroll: 1,
						autoplay: true,
						autoplaySpeed: 2000
		      }
		    }
		    // You can unslick at a given breakpoint now by adding:
		    // settings: "unslick"
		    // instead of a settings object
		  ]
  });
});
</script>
@endsection
