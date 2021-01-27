@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
 - Crear Cuenta
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')
<div class="regisSEC">
	<div class="container">
		<div class="row justify-content-around">
			<div class="col-lg-4 col-xl-4 col-md-4">
				<div class="RegInfo-BOX">
					<h4>Crea tu cuenta.</h4>
					<h3>Así, todo es mas fácil</h3>

					<h5>Beneficios</h5>
					<ul>
						<li>• Protege tus datos e información de pago.</li>
						<li>• Revisa el historial de tus compras.</li>
						<li>• Compra más rápido en tus siguientes visitas.</li>
						<li>• Guarda tus distintas direcciones de entrega.</li>
					</ul>
				</div>
			</div>

			<div class="col-lg-6 col-xl-5 col-md-8">
				<div class="FormBOX boxSH1">
                    <h5>Crea tu cuenta</h5>
                    <p>Ingresa estos datos basicos:</p>
					<form class="" action="{{ route('register') }}" method="POST">
						@csrf
						<div class="Regform-BOX">
							<div class="form-row">

								<div class="form-group col-md-12">
									<input id="nombre" type="text" autocomplete="off" class="form-control @error('name') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="name" autofocus>
                                    <label for="">Nombre *</label>
                                    @error('nombre')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="form-group col-md-6">
									<input id="paterno" type="text" autocomplete="off" class="form-control @error('paterno') is-invalid @enderror" name="paterno" value="{{ old('paterno') }}" required autocomplete="name" autofocus>
                                    <label for="">Apellido Paterno *</label>
									@error('paterno')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="form-group col-md-6">
									<input id="materno" type="text" autocomplete="off" class="form-control @error('materno') is-invalid @enderror" name="materno" value="{{ old('materno') }}"  required autocomplete="name" autofocus>
                                    <label for="">Apellido Materno *</label>
                                    @error('materno')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="form-group col-md-12">
									<input id="fecha_nacimiento" type="date" placeholder="01/12/1997" autocomplete="off" class="form-control @error('fecha_nacimiento') is-invalid @enderror" name="fecha_nacimiento"  value="{{ old('fecha_nacimiento') }}" required autocomplete="name" autofocus>
                                    <label for="">Fecha de nacimiento *</label>
									@error('fecha_nacimiento')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="form-group col-md-12">
									<input id="email" type="text" autocomplete="off" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  required autocomplete="email">
                                    <label for="">Correo *</label>
                                    @error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror

								</div>
								<div class="form-group col-md-12">
									<input id="password" type="password" autocomplete="off" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    <label for="">Contraseña *</label>
                                    @error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
								<div class="form-group col-md-12">
									<input id="password-confirm" type="password" autocomplete="off" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    <label for="">Confirmar Contraseña *</label>
                                </div>
                                <div class="col-md-12">
                                    <table class="tg client-genere-cont">
                                        <thead>
                                          <tr>
                                            <th  class="client-genere-title" colspan="3"> <h6>Elige tu género:</h6> </th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td class="tg-0lax"><label><input class="" type="radio"  name="genero" value="1"> Mujer </label></td>
                                            <td class="tg-0lax"><label><input class="" type="radio"  name="genero" value="0"> Hombre </label></td>
                                          </tr>
                                        </tbody>
                                    </table>
                                </div>
							</div>

						</div>
						<div  class="form-check">
							<input id="terminos_check" onclick="revisa_check()" class="form-check-input" type="checkbox" value="">
							<label class="form-check-label" for="defaultCheck1">
								He leído y acepto los <a href="{{ url('Empresa/TerminosyCondiciones') }}" target="_blank">Términos y condiciones</a>  y el <a href="{{ url('Empresa/AvisodePrivacidad') }}" target="_blank">Aviso de privacidad</a>.
							</label>
						</div>
						<div class="form-check">
							<input id="ofertas_check" onclick="ofertas_check()" class="form-check-input" type="checkbox" name='ofertas' value="">
							<label class="form-check-label" for="defaultCheck1">
								Quiero recibir ofertas y promociones en mi correo electrónico.
							</label>
						</div>

						<button  type="submit" class="btn btn-primary btn-block" id="agregar">Crea tu cuenta</button>


						<div class="cenTR">
							<span>
								¿Ya tienes cuenta?<a href="{{ url('login') }}"> Inicia sesión</a>
							</span>
						</div>

					</form>

				</div>
			</div>
		</div>
		<div class="overflow"></div>
	</div>
</div>




@endsection

@section('scripts')
<script>
	$("#agregar").prop("disabled", true);
	$('#ofertas_check').prop('checked',true);
	$('#terminos_check').prop('checked',true);

	if($('#terminos_check').is(':checked') ) {
		$("#agregar").prop("disabled", false);
	}else{
		$("#agregar").prop("disabled", true);
	}

	function revisa_check(){
		if($('#terminos_check').is(':checked') ) {
			$("#agregar").prop("disabled", false);
		}else{
			$("#agregar").prop("disabled", true);
		}
	}

	function ofertas_check(){
		if($('#ofertas_check').is(':checked')){
			$('#ofertas_check').val('1');
		}else{
			$('#ofertas_check').val('0');
		}

	}

	window.onload = function(){


	};




</script>
@endsection
