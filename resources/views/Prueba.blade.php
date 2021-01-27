hola
<script type="text/javascript" src="{{ asset('js/jquery-3.5.1.js') }}"></script>
<script type="text/javascript">
console.log('hola');
$.ajax({
    url: '/Departamento/articulosDepto/'+ 2 +'/' + 55,
    dataType: 'json',
    success: function (respuesta) {
        console.log(respuesta);
    }
});

</script>
