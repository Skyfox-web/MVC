@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- Pruebas
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')

<div class="container">
    <div class="row">
        <div class="col-md-4">
    <div class="CarrCOMP">
                  <h4>Resúmen de compra</h4>
                  <div class="ResCOM">
                      <table>
                          <tbody>
                              <tr class="Csub">
                                  <td>Subtotal:</td>
                                  <td class="text-right" id="pre_sub_fin_loc">$4,181.03</td>
                              </tr>
                              <tr class="CIVA">
                                  <td>IVA:</td>
                                  <td class="text-right " id="pre_iva_fin_loc">$668.97</td>
                              </tr>
                              <tr class="CTot">
                                  <td>Total de contado:</td>
                                  <td class="text-right " id="pre_tot_fin_loc">$4,850.00</td>
                              </tr>
                          </tbody>
                      </table>
                      <!--CUPON DE DESCUENTO-->
                      <div class="input-group mb-3 input-cupon-descuento">
                              <div class="form-group input-group">
                                  <input type="text" onchange="" class="form-control input-rfccss"  autocomplete="off"  required autocomplete="off" id="">
                                  <!-- <span id="loader-rfc" style="visibility: hidden;" class="fas fa-spinner loader-icon rotating-lader-Rfc"></span>
                                  <span id="load-AprobadoRFC" style="visibility: hidden;" class="fas fa-check loader-icon check-green"></span> -->
                                  <label class="label_rfcCSS" for="">Codigo de descuento* </label>
                                  <button class="btn btn-outline-secondary btn-rfccss" type="button" id="" style="right:0px;">Aplicar</button>
                              </div>
                              <!-- <button type="button" class="btn btn-info" onclick="busca_frc()" name="button">Buscar</button> -->
                      </div>
                  </div>
                  <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#staticBackdrop">Pagar</button>

                  <a class="text-center" href="https://www.muebleria-villarreal.com">Seguir comprando</a>
                  <p>*La fecha estimada de entrega puede variar debido a la disponibilidad de los productos, al domicilio de entrega y a la forma de pago.</p>
              </div>

        </div>
    </div>
</div>
<!--
<div class="container">
    <div class="row">
        <div class="col-md-12">


    <table width="100%" cellspacing="0" cellpadding="7" border="0" style="text-align:right">
       <tbody>
        <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:10px">
         <th width="9" align="left" valign="middle" style="width:9px;border-bottom:1px solid #c8c8c8;padding-top:12px;padding-bottom:12px;text-align:left;font-weight:bold;text-transform:uppercase">&nbsp;</th>
         <th align="left" valign="middle" style="border-bottom:1px solid #c8c8c8;padding-top:12px;padding-bottom:12px;text-align:left;font-weight:bold;text-transform:uppercase">COD:</th>
         <th align="left" valign="middle" style="border-bottom:1px solid #c8c8c8;padding-top:12px;padding-bottom:12px;text-align:left;font-weight:bold;text-transform:uppercase">DESC.</th>
         <th align="left" valign="middle" style="border-bottom:1px solid #c8c8c8;padding-top:12px;padding-bottom:12px;text-align:left;font-weight:bold;text-transform:uppercase">CANT.</th>
         <th width="65" align="left" valign="middle" style="border-bottom:1px solid #c8c8c8;padding-top:12px;padding-bottom:12px;text-align:left;font-weight:bold;text-transform:uppercase">PRECIO</th>
         <th width="9" align="left" valign="middle" style="width:9px;border-bottom:1px solid #c8c8c8;text-transform:uppercase;padding-top:12px;padding-bottom:12px;text-align:left;font-weight:bold">&nbsp;</th>
        </tr>
        <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:10px">
         <td width="9" align="left" valign="middle" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36;width:9px;border-bottom:1px solid #c8c8c8">&nbsp;</td>
         <td align="left" valign="middle" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36;border-bottom:1px solid #c8c8c8">00000</td>
         <td align="left" valign="middle" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36;border-bottom:1px solid #c8c8c8">NOmbre del articulo</td>
         <td align="left" valign="middle" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36;border-bottom:1px solid #c8c8c8">1</td>
         <td align="left" valign="middle" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36;border-bottom:1px solid #c8c8c8">$399.00</td>
         <td width="9" align="left" valign="middle" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36;width:9px;border-bottom:1px solid #c8c8c8">&nbsp;</td>
        </tr>
       </tbody>
      </table>

      <table align="right" width="700" cellspacing="0" cellpadding="0" border="0">
       <tbody>
        <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:11px">
         <td width="390" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36">&nbsp;</td>
         <td width="285" align="left" style="margin-top:0;margin-bottom:0;color:#000000;line-height:1.36"> <br>
          <table width="285" align="right" cellspacing="0" cellpadding="0" border="0" style="text-transform:uppercase">
           <tbody>
            <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:11px">
             <td style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px">TOTAL DE PRODUCTOS:</td>
             <td align="right" style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px">$598.00</td>
            </tr>
            <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:11px">
             <td style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px">DESCUENTOS:</td>
             <td align="right" style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px">0</td>
            </tr>
            <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:11px">
             <td style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px;vertical-align:top"> ENVÍO: </td>
             <td align="right" style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px;vertical-align:top"> $55.00 </td>
            </tr>
            <tr style="font-family:Arial,Helvetica,Verdana,sans-serif;font-size:11px">
             <td nowrap="" style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px;border-top:1px solid #c8c8c8;padding-top:11px;font-weight:bold"> TOTAL </td>
             <td nowrap="" align="right" style="margin-top:0;margin-bottom:0;color:#000000;line-height:16px;border-top:1px solid #c8c8c8;padding-top:11px;font-weight:bold"> $573.00 </td>
            </tr>
           </tbody>
          </table> </td>
         <td width="25">&nbsp;</td>
        </tr>
       </tbody>
      </table>

  </div>
</div>
</div> -->

@endsection


@section('scripts')


@endsection
