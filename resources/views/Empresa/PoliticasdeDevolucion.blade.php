@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')
- Devoluciones
@endsection



<!--body--><!--body--><!--body-->
@section('seccion')

<div class="container" style="padding-top:20px;padding-bottom:20px;">
	<div class="row">
	<div class="col-md-12">
	<div class="cliente-box">

	<h4>Política de Garantía, Devoluciones y Cambios</h4>

	<p>Mueblería Villarreal Caballero le agradece su compra y para brindarle un mejor servicio en las
	garantías de nuestros productos le informamos las siguientes políticas aplicables exclusivamente
	para compras en el sitio <a href="{{ url('') }}">www.muebleria-villarreal.com</a></p>

	<h6>Política de Garantía:</h6>
	<p>1.- La Garantía de los productos vendidos por el sitio WEB de Mueblería Villarreal Caballero, S.A.
	de C.V. estará escrita en su comprobante de compra o bien mediante póliza del fabricante en
	donde establecerá el tiempo de garantía de acuerdo al producto y al proveedor.</p>

	<p>2.-En productos donde no exista un centro de servicio del fabricante en la localidad del cliente,
	Mueblería Villarreal podrá tramitar la garantía actuando como intermediario entre el cliente y el
	proveedor o fabricante como un servicio adicional, debiendo pagar el cliente el costo que se
	genere del proceso de traslados en caso de estar fuera de Cd. Victoria o Matamoros, Tamaulipas.
	Dicho costo será definido en el momento del trámite. En los casos en el que el producto dañado
	no pueda ser reemplazado, reparado por el fabricante o proveedor, se encuentre agotado o haya
	sido descontinuado por el fabricante, se ofrecerá una alternativa de producto o bien se realizará
	un reembolso por el producto en garantía, de conformidad con las condiciones establecidas en las
	políticas de reembolso. El cliente deberá llamar a nuestro departamento de Atención al Cliente al
	<a href="tel:834-305-0907">8343050907</a>, quienes le orientarán al respecto.</p>

	<p>3.-Los defectos o desperfectos debidos al uso incorrecto o manipulación del material o los
	desgastes producidos por un uso anormal del mismo, anularán la garantía.</p>

	<p>4.-Los daños en los productos causados por un desconocimiento del manejo o funciones del
	producto anularán la garantía.</p>

	<p>5.-El cliente cuenta con una garantía total de 2 (dos) días hábiles a partir de haber recibido el
	producto por primera vez y/o el envió de una reparación del producto y/o el envió de un
	remplazo, para hacer alguna reclamación en caso de que el producto presente alguna anomalía de
	funcionamiento. Todos los gastos de manejo y envió correrán por cuenta del cliente.</p>

	<p>6.-Para cualquier defecto de fabricación y funcionamiento que tengan los productos comprados en
	sitio WEB de Mueblería Villarreal Caballero, S.A. de C.V. se establece como único responsable al
	fabricante de los mismos. Mueblería Villarreal Caballero, S.A. de C.V. actuará como un facilitador
	en el trámite de la garantía.</p>

	<p>7.-La vigencia de la garantía dará inicio a partir del día de entrega y recepción de los productos.</p>

	<p>8.-No podrá presentarse una reclamación por garantía, si el producto ha sido manipulado ó
	reparado incorrectamente por personas no autorizadas por el fabricante.</p>

	<p>9.-La garantía no será válida por causas ajenas a la operación de propio producto, tales como
	cambios bruscos de voltaje, utilización de accesorios inadecuados o no recomendado por los
	fabricantes, derrames de líquidos, fuego, abuso en el manejo del producto, o por desgaste natural
	de algunos materiales en la composición del producto.</p>

	<p>10.-No se responde por software en los equipos, desconfiguraciones de ningún tipo, daños
	causados por virus, incompatibilidad o incumplimiento de las condiciones mínimas de uso de algún
	software especifico.</p>

	<p>11.-No aceptamos cambios de ningún tipo por incompatibilidad con algún software y/o hardware.</p>

	<p>12.-El tiempo de respuesta a su garantía será de 30 días hábiles una vez recibido el producto por el
	proveedor.</p>

	<p>13.-Estas políticas no son excluyentes ni deben ser entendidas o utilizadas en contraposición a las
	condiciones de garantía que maneje cada proveedor.</p>

	<h6>Política de Devolución y Cambio de Mercancía</h6>

	<p>Nuestro compromiso es ofrecerte una experiencia de compra satisfactoria, por lo que en caso de
	que el artículo no sea de tu satisfacción deberás hacer lo siguiente:</p>

	<ul>
		<li><i class="fas fa-circle"></i> Producto con Defecto de Fabricación: Te sugerimos que consultes nuestra Política de
		Garantías.</li>
		<li><i class="fas fa-circle"></i> Producto Incompleto: Deberás notificar telefónicamente. Al teléfono de contacto con un
		ejecutivo o vía correo electrónico a <a href="mailto:servicios.bodega@mvc.com.mx">servicios.bodega@mvc.com.mx</a> dentro de un lapso
		no mayor a 2 días hábiles contados a partir de la fecha en que recibas el producto bajo las
		siguientes condiciones:</li>
		<ul>
			<li><i class="far fa-circle"></i> Si no recibiste el producto en las condiciones esperadas.</li>
			<li><i class="far fa-circle"></i> Si llegó incompleto en alguna de sus piezas.</li>
			<li><i class="far fa-circle"></i> Si no es acompañado del manual o accesorios que este deba contener.</li>
			<li><i class="far fa-circle"></i> Si el producto te llegó dañado, quebrado, rayado, roto, arrugado o astillado.</li>
			<li><i class="far fa-circle"></i> Producto equivocado o abierto.</li>
			<li><i class="far fa-circle"></i> Empaque adulterado.</li>
		</ul>
	</ul>
	<br>
		<p>Una vez reportado, la empresa de mensajería pasará a recoger el producto en un lapso no mayor a
		15 días hábiles a partir de que se reciba tu notificación.</p>
	<ul>
		<li><i class="fas fa-circle"></i> El producto deberás devolverlo en perfecto estado, sin uso, cerrado, en su empaque
		original, acompañado de sus manuales y</li>
		<li><i class="fas fa-circle"></i> No se harán devoluciones de pedidos especiales (productos que no se encuentran en el
		catálogo habitual de Mueblería Villarreal Caballero pero que se han surtido a solicitud del
		cliente).</li>
		<li><i class="fas fa-circle"></i> Los gastos de traslado para regresar el producto correrán por cuenta del cliente. Si lo
		deseas podemos enviarte una guía para que se programe la recolección del producto y el
		costo del envío se descontará de tu rembolso de conformidad con las políticas de
		reembolso</li>
		<li><i class="fas fa-circle"></i> Una vez que se reciba el producto en las instalaciones de Mueblería Villarreal Caballero
		SA de CV , se validará la integridad de todos sus componentes se te notificará y
		procederemos a reembolsarte el importe del producto descontando los gastos de envío
		de conformidad con las políticas de reembolso</li>
	</ul>
	<br>
	<p>Para realizar una devolución de producto deberás tener la siguiente información a la mano:</p>
	<p>1.-Folio del comprobante con el que realizaste la compra del producto. Puedes entrar a tu Usuario
	en el sitio Web y obtenerlo.</p>
	<p>2-Fecha en la que recibiste el producto.</p>
	<p class="lastxt">*Si tienes alguna duda no te preocupes, podemos ayudarte a localizar tu pedido en atención al
	cliente. Al teléfono 8343050907.</p>

	</div>
</div>
</div>
</div>

@endsection
