@extends('Shared/Layout')

<!--titulo de la pagina-->
@section('titulo')
- Inicio de sesion
@endsection
<!--body--><!--body--><!--body-->
@section('seccion')

<div class="logBG">
  <div class="container">
    <div class="row justify-content-around">
      <div class="col-lg-4 col-xl-4 col-md-4">
				<div class="RegInfo-BOX">
					<h3>Inicia Sesion</h3>
					<h4>Así, todo es mas fácil</h4>

					<h5>Beneficios</h5>
					<ul>
						<li>• Protege tus datos e información de pago.</li>
						<!-- <li>• Revisa el historial de tus compras.</li> -->
						<li>• Compra más rápido en tus siguientes visitas.</li>
						<li>• Guarda distintas direcciones de entrega.</li>
					</ul>
				</div>
			</div>

      <div class="col-lg-6 col-xl-4 col-md-8">
        <div class="FormBOX boxSH1">
          <div class="Regform-BOX">
            <div class="cenTR">
              <h5>¡Hola de nuevo!</h5>
              <p>Inicia sesión con tu correo electrónico</p>
            </div>
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
                  <input class="form-control" id="correo" type="text" required name="email" value={{ old("email") }} >
                  <label for="">Correo *</label>
              </div>

              <div id="pass-form" class="form-group">
                  <input class="form-control input-hov password1" type="password" id="passw" name="password" required>
                  <span class="fa fa-fw fa-eye password-icon show-password"></span>
                  <label for="">Contraseña *</label>
              </div>

              <a href="{{ url('password/reset')}}">¿Olvidaste tu contraseña?</a>

              <button class="btn btn-primary btn-block">Acceder</button>

              <div class="cenTR">
  							<h5>¿Eres nuevo?</h5>
                <a type="button" class="btn btn-outline-primary" href="{{ url('UserRegistrationForm') }}"> Crea una cuenta</a>
  						</div>
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


<script type="text/javascript">
    window.addEventListener("load", function() {
        // icono para mostrar contraseña
        showPassword = document.querySelector('.show-password');
        showPassword.addEventListener('click', () => {
            // elementos input de tipo clave
            password1 = document.querySelector('.password1');
            if ( password1.type === "text" ) {
                password1.type = "password"
                showPassword.classList.remove('fa-eye-slash');
            } else {
                password1.type = "text"
                showPassword.classList.toggle("fa-eye-slash");
            }

        })

    });
</script>

@endsection
