<footer>

	<!--footerup-->

	<div class="footerUP">
	    <div class="container">
	        <div class="row">
	            <div class="col-xl-3 col-lg-3 col-md-6">
	                <div class="footer-info">
	                    <h5>Recibe ofertas y beneficios por correo</h5>
	                </div>
	            </div>
	            <div class="col-xl-3 col-lg-3 col-md-6">

	                <!-- <link rel="stylesheet" href="https://my.sendinblue.com/public/theme/version4/assets/styles/style.css" /> -->
	                <div id="sib_embed_signup" style="padding: 10px;">
	                    <div class="forms-builder-wrapper" style="position:relative;margin-left: auto;margin-right: auto;">
	                        <input type="hidden" id="sib_embed_signup_lang" value="es">
	                        <input type="hidden" id="sib_embed_invalid_email_message" value="Esta dirección de e-mail no es válida.">
	                        <input type="hidden" name="primary_type" id="primary_type" value="email">
	                        <div id="sib_loading_gif_area" style="position: absolute;z-index: 9999;display: none;">
	                            <img src="https://my.sendinblue.com/public/theme/version4/assets/images/loader_sblue.gif" style="display: block;margin-left: auto;margin-right: auto;position: relative;top: 40%;">
	                        </div>
	                        <form class="description" id="theform" name="theform" action="https://my.sendinblue.com/users/subscribeembed/js_id/1ss5i/id/1" onsubmit="return false;">
	                            <input type="hidden" name="js_id" id="js_id" value="1ss5i">
	                            <input type="hidden" name="from_url" id="from_url" value="yes">
	                            <input type="hidden" name="hdn_email_txt" id="hdn_email_txt" value="">
	                            <div class="sib-container rounded ui-sortable">
	                                <input type="hidden" name="req_hid" id="req_hid" value="" style="font-size: 13px;">
	                                <div class="header" style="padding: 0px 10px;">
	                                    <h1 class="title editable" data-editfield="newsletter_name" style="font-weight: normal; text-align: left; font-size: 40px; margin-bottom: 2px; padding: 0px; margin-top: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(35, 35, 35); display: none;">Mi Nesletter</h1>
	                                    <h3 id="company-name" style="font-weight: normal; text-align: left; font-size: 20px; margin-bottom: 12px; padding: 0px; margin-top: 0px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(52, 52, 52); display: none;">Por</h3>
	                                </div>
	                                <div class="description editable" data-editfield="newsletter_description" style="padding: 10px 15px; border-bottom: 1px solid rgb(204, 204, 204); font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(52, 52, 52); font-size: 15px; display: none;">
	                                </div>
	                                <div class="view-messages" style=" margin:5px 0;">
	                                </div>
	                                <div class="primary-group email-group forms-builder-group ui-sortable" style="">
	                                    <div class="row mandatory-email" style="padding: 10px; position: relative; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(52, 52, 52); font-size: 15px; left: 0px; top: 0px;">
	                                        <div class="lbl-tinyltr" style="clear: both; float: none; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;"><br>
	                                        </div>
	                                        <input class="input-correo-sendinblue" type="text" name="email" id="email" placeholder="Correo" value="">
	                                        <div style="clear:both;"></div>
	                                        <!-- <div class="hidden-btns">
	                                            <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br>
	                                        </div> -->
	                                    </div>
	                                </div>
	                                <div class="captcha forms-builder-group" style="display: none;">
	                                    <div class="row" style="padding: 10px; font-family: &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif; color: rgb(52, 52, 52); font-size: 15px;">
	                                        <div id="gcaptcha" style="transform: scale(0.85); margin-left: -23px;">
	                                        </div>
	                                    </div>
	                                </div>
	                                <div class="byline">
	                                    <button class="button-correo-sendinblue" type="submit" data-editfield="subscribe">Suscribirse</button>
	                                </div>

	                            </div>
	                        </form>
	                    </div>
	                </div>

	            </div>
	            <div class="col-xl-3 col-lg-3 col-md-6 d-flex justify-content-between">
	                <div class="venta-por-telefono">
	                    <h5>¿Tienes dudas?</h5>
	                    <a href="tel:834-318-2700"> 8343182700</a>
	                    <p>Horario de atención telefónica</br>
	                        9:00 a 20:00 horas</p>
	                </div>
	            </div>
	            <div class="col-xl-3 col-lg-3 col-md-6">
	            <div class="WhatsBTN">
	            <h5>Contactanos</h5>
	                <div class="venta-por-whatsapp">
	                    <a href="https://api.whatsapp.com/send?phone=528343110729" target="_blank">
	                        <picture>
	                            <img data-src="{{ asset('img/icons/Waap-icon.png') }}" class="img-fluid lazyload" alt="Responsive image">
	                        </picture>
	                    </a>
	                    <p>Horario de atención via whatsapp</br> 9:00 a 20:00 horas</p>
	                </div>
	            </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!--footermiddle-->
	<div class="footerMiddle">
		<div class="container">
			<div class="row">

				<div class="col-xl-3 col-lg-3 col-md-6">
					<div class="middle-Title">
						<h5>AYUDA</h5>
					</div>
					<div class="list-unstyled">
						<li><a href="{{ url('Empresa/AvisodePrivacidad') }}">Aviso de privacidad</a></li>
						<li><a href="{{ url('Empresa/PoliticasdeDevolucion') }}">Politicas de devolución</a></li>
						<li><a href="{{ url('Empresa/TerminosyCondiciones') }}">Términos y condiciones</a></li>
						<!-- <li><a href="">Preguntas frecuentes</a></li> -->

					</div>
				</div>

				<div class="col-xl-3 col-lg-3 col-md-6">
					<div class="middle-Title">
						<h5>SOBRE NOSOTROS</h5>
					</div>
					<div class="list-unstyled">
						<li><a href="{{ url('Empresa/Sucursales') }}">Nuestras sucursales</a></li>
						<li><a href="{{ url('Empresa/QuienesSomos') }}">¿Quienes somos?</a></li>
						<!-- <li><a href="{{ url('Empresa/Contacto') }}">Contacto</a></li> -->
						<!-- <li><a href="#">Facturacion</a></li> -->
						<!-- <li><a href="#">Mesa de regalos</a></li> -->
					</div>
				</div>

				<div class="col-xl-3 col-lg-3 col-md-6">
					<div class="social-media-icon">
						<div class="middle-Title">
							<h5>REDES SOCIALES</h5>
						</div>
						<a href="https://www.facebook.com/VillarrealMx"><i class="fab fa-facebook"></i></a>
						<a href="https://www.instagram.com/muebleria_villarreal/"><i class="fab fa-instagram"></i></a>
						<a href="https://www.pinterest.com.mx/muelberiavillarrealcaballero/"><i class="fab fa-pinterest-square"></i></a>
						<a href="https://twitter.com/mueb_Villarreal"><i class="fab fa-twitter-square"></i></a>
						<a href="https://www.youtube.com/channel/UCGCntgo2owenNSPfDH-zejw/featured?disable_polymer=1"><i class="fab fa-youtube-square"></i></a>
					</div>
				</div>

				<div class="col-xl-3 col-lg-3 col-md-6">
						<div class="middle-Title">
							<h5>METODOS DE PAGO</h5>
						</div>
						<div class="icons-payment">
							<div class="icon1"></div>
							<div class="icon2"></div>
							<!-- <div class="icon3"></div> -->
							<!-- <div class="icon4"></div> -->
							<div class="clearfix"></div>
						</div>
						<div class="secure-logo">
							<span  id="siteseal"><script async type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=0pYHGGPlVFc3BdGAqnwV979EGQJqqa7gmLFTDDgF5odfwXO7pwdFD3bEiOKp"></script></span>
						</div>
				</div>

			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
					<div class="icon-Payment">
						<p>Derechos de autor © 2020 <br>Muebleria Villarreal Caballero</p>

					</div>
			</div>
		</div>
	</div>
</footer>
