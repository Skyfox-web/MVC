@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- Dinamica
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')

<div class="DinamicaBG">
  <div class="container">
    <div class="row justify-content-around">
      <div class="col-lg-4 col-xl-4 col-md-5">
				<div class="RegInfo-BOX-dinamica">
					<h1>REGISTRA TU COMPRA</h1>
					<h2><span>GANA</span> UNA RECAMARA</h2>
                    <h1>ODESSA KS</h1>
					<!-- <h5>Beneficios</h5> -->
				</div>
			</div>

      <div class="col-lg-6 col-xl-4 col-md-7">
        <div class="FormBOX boxSH1">
          <div class="Regform-BOX">
            <div class="cenTR">
              <h5>¡Registra tu compra!</h5>
              <p>Solo necesitamos información básica</p>
            </div>

              <form id="frm_dinamica">
                  <div class="input-group custom-select-dina">

                          <select class="" name="serie" onchange="setSerie()" id="serie" style="width:30%;" required>
                              <option value="serie-w" style="display:none;">Serie &nbsp</option>
                              <option value="FA">FA</option>
                              <option value="FC">FC</option>
                              <option value="FD">FD</option>
                              <option value="FB">FB</option>
                              <option value="FF">FF</option>
                              <option value="FG">FG</option>
                          </select>



                        <div class="form-group" style="width:70%;">
                            <input id="folio" type="number" class="form-control" name="folio" placeholder="Folio" required>
                        </div>
                        <input type="hidden" id="serie_hidden" name="serie_hidden" value="" required>
                      <span class="inptValid serie_hidden" style="display:none;">Selecciona la serie &nbsp</span>
                      <span class="inptValid folio" style="display:none;">Este campo es obligatorio</span>
                  </div>
                  <div class="">
                      <div class="form-group">
                          <input class="form-control" id="nombre" type="text" required name="nombre" >
                          <label for="">Nombre *</label>
                      </div>
                      <span class="inptValid nombre" style="display:none;">Este campo es obligatorio</span>
                  </div>
                  <div class="">
                      <div class="form-group">
                          <input class="form-control" id="correo" type="email" required name="correo" >
                          <label for="">Correo *</label>
                      </div>
                      <span class="inptValid correo" style="display:none;">Este campo es obligatorio<br></span>
                      <span class="inptValid correo_invalid" style="display:none;">Ingresa un correo válido</span>
                  </div>
                  <div class="">
                      <div class="form-group">
                          <input class="form-control" type="number" maxlength="11" id="telefono" name="telefono" required>
                          <label for="">Número de teléfono*</label>
                      </div>
                      <span class="inptValid telefono" style="display:none;">Este campo es obligatorio</span>
                  </div>
              </form>
              <button onclick="validaDireccion()" class="btn btn-primary btn-block">Registrarse</button>
                <div class="cenTR" style="padding-top:20px;">
                <p style="color:red !important;">Compras validas del 9 al 31 de Enero del 2021<br>
                    Aplican restricciones
                </p>

                </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>



@endsection




@section('scripts')

<script type="text/javascript" src="{{ asset('js/dinamicas/en2021.js') }}"></script>

<!-- <script type="text/javascript">
$(document).ready(function(){
$(".dropdown-item").click(function(){
var valor = $(this).text();

$(".dropdown-toggle").html(valor + '&nbsp;<span class="caret"></span>')
})
})
</script> -->

@endsection
