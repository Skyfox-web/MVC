@extends('Shared/Layout')

<!--titulo de la pagina-->
@section('titulo')

@endsection
<!--body--><!--body--><!--body-->
@section('seccion')

<div class="logBG">
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-1">
				<div class="RegInfo-BOX">
					<h3>INICIA SESION </h3>
					<h4>Así, todo es mas fácil</h4>

					<h5>Beneficios</h5>
					<ul>
						<li>• Protege tus datos e información de pago.</li>
						<li>• Revisa el historial de tus compras.</li>
						<li>• Compra más rápido en tus siguientes visitas.</li>
						<li>• Guarda distintas direcciones de entrega.</li>
					</ul>
				</div>
			</div>

      <div class="col-md-5 offset-md-1 ">
        <div class="FormBOX boxSH1">
          <div class="Regform-BOX">
              <form class="" method="POST" action="{{ route('login') }}" >
              {{ csrf_field() }}

              @if($errors->has('email') or $errors->has('password'))
              <div class="alert alert-warning">
                  @if( $errors->has('email'))
                      {!! $errors->first('email', '* <span id="error-correo" class="help-block">:message <br></span>') !!}
                  @endif
                  @if($errors->has('password'))
                      {!! $errors->first('password', '* <span id="error-contraseña" class="help-block">:message</span>') !!}
                  @endif
              </div>
              @endif

              <div id="email-form" class="form-group">
                  <input class="form-control" id="correo" type="email"  name="email" placeholder="Correo" value={{ old('email')}}>
              </div>
              <div id="pass-form" class="form-group">
                  <input class="form-control" type="password" id="passw" name="password" placeholder="Contraseña">
              </div>

              <button class="btn btn-primary btn-block">Acceder</button>
              <a class="btn btn-link" href="">¿Olvidate tu contraseña?</a>
          </form>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    $( document ).ready(function() {
        var replaced = $("#error-correo").html().replace('email', 'correo');
        $("#error-correo").html(replaced);
        var replaced = $("#error-contraseña").html().replace('password', 'contraseña');
        $("#error-contraseña").html(replaced);
    });
</script>
@endsection
