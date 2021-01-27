@extends('Shared/Layout')

@section('titulo')
- Contraseña olvidada
@endsection

@section('seccion')
<div class="ressBG">
<div class="container">
    <div class="row justify-content-end">
        <div class="col-lg-6 col-xl-4 col-md-8">
            <div class="FormBOX boxSH1">
                <h4>{{ __('Cambia tu contraseña') }}</h4>
                <p>Solo ingresa tu correo electrónico. Es normal que la olvidemos, por suerte puedes cambiarla.</p>

                <div class="">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="">
                            <!--<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Correo') }}</label>-->

                            <div class="form-group">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <label for="">Correo *</label>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Continuar') }}
                                </button>
                            </div>
                        </div>

                        <div class="cenTR">
							<span>
								¿Ya tienes cuenta?<a href="{{ url('login') }}"> Inicia sesión</a>
							</span>
						</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
