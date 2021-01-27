@extends('Shared/Layout')

@section('titulo')
- Contraseña olvidada
@endsection

@section('seccion')
<div class="ressBG">
<div class="container">
    <div class="row justify-content-end">
        <div class="col-xl-4 col-lg-6 col-md-7">
                <!-- <div class="card-header">{{ __('Reset Password') }}</div> -->

                <div class="FormBOX boxSH1">

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                        <h4 style="padding-bottom:20px;">Actualiza tu contraseña</h4>
                        <div class="form-group">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label> -->
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            <label for="">Correo *</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            <label for="">Contraseña *</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <!-- <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label> -->
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <label for="">Confirmar contraseña *</label>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Confirmar</button>
                            </div>
                        </div>
                        <p>Recuerda apuntarla en un lugar donde puedas recordarla, y si la pierdes, siempre puedes renovar tu contraseña</p>
                    </form>
                </div>


        </div>
    </div>
</div>
</div>

@endsection
