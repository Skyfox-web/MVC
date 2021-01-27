@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')

@endsection



<!--body--><!--body--><!--body-->
@section('seccion')


@endsection


@section('scripts')
<script>

    $.ajax('/registrarUsuarios', {
        type: 'POST',  // http method
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    success: function (data) {



    }
    });

    function palabras2(nombre){

    }



    function palabras(nombre){

    }


</script>

@endsection
