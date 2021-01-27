function tipValor(tipo, valor) {
	this.tipo = tipo;
	this.valor = valor;
}


function fixNum(x) {
	return Number.parseFloat(x).toFixed(2);
}

function filtros(tipo, valor, valor2, num){
    lista_filt_act = [];
    list_activos = '';
	area_requerida = '';

    switch(tipo){
        case 0:
            if(!color.includes(valor)){
                color.push(valor);
            }else{
                temp_color = color;
                color = [];
                for (var i = 0; i < temp_color.length; i++) {
                    if(temp_color[i] != valor){
                        color.push(temp_color[i]);
                    }
                }
            }
        break;
        case 1:
            if(!marc.includes(valor)){
                marc.push(valor);
            }else{
                temp_marc = marc;
                marc = [];
                for (var i = 0; i < temp_marc.length; i++) {
                    if(temp_marc[i] != valor){
                        marc.push(temp_marc[i]);
                    }else{

                        $('.chk_marca').each(function(index, obj){
                            if($(this).prop('checked') && valor == $(this).val()){
                                $(this).prop('checked', false);
                            }
        				});
                    }
                }
            }
        break;
        case 2:
            if(num){
                $('.chk_precio').each(function(index, obj){
                    $(this).prop('checked', false);
                });
				$("#min_pre").val('');
				$("#max_pre").val('');
				validaPrec();
                precio_min = null;
                precio_max = null;
                for (i = 0; i < lista_filt_act.length; i++) {
                    if(Array.isArray(lista_filt_act[i]) && lista_filt_act.length>0){
                        for (var j = 0; j < lista_filt_act[i].length; j++) {
                            valor = "'" + lista_filt_act[i][j] + "'";
                            list_activos += '<span onclick="filtros('+i+', '+precio_min+', '+precio_max+')"><i class="fa fa-times-circle" aria-hidden="true"></i>'+lista_filt_act[i][j]+'</span>'
                        }
                    }
                }
            }else{
                precio_min = fixNum(valor);
                precio_max = fixNum(valor2);
            }

        break;
        case 4:
            if(!capacidad.includes(valor)){
                capacidad.push(valor);
            }else{
                temp_capacidad = capacidad;
                capacidad = [];
                for (var i = 0; i < temp_capacidad.length; i++) {
                    if(temp_capacidad[i] != valor){
                        capacidad.push(temp_capacidad[i]);
                    }else{
                        $('.chk_colchon').each(function(index, obj){
                            if($(this).prop('checked') && valor == $(this).val()){
                                $(this).prop('checked', false);
                            }
        				});
                    }
                }
            }
        break;
        case 5:
			if(num){
				$("#largo_area").val('');
				$("#ancho_area").val('');
				validaMedidas();
				largo = null;
				ancho = null;
				for (i = 0; i < lista_filt_act.length; i++) {
					if(Array.isArray(lista_filt_act[i]) && lista_filt_act.length>0){
						for (var j = 0; j < lista_filt_act[i].length; j++) {
							valor = "'" + lista_filt_act[i][j] + "'";
							list_activos += '<span onclick="filtros('+i+', '+largo+','+ancho+','+1+')"><i class="fa fa-times-circle" aria-hidden="true"></i>'+lista_filt_act[i][j]+'</span>'
						}
					}
				}
			}else{
				largo = valor;
				ancho = valor2;
				area_requerida = fixNum(largo) + ' X ' + fixNum(ancho);
			}

        break;
		case 6:
			tipo_orden = valor === 'asc' ? 1 : 0;
		break;
		case 8:
			text_bus = valor;
		break;
        case 7:

            if(!clasificacion.includes(valor)){
                clasificacion.push(valor);
            }else{
                temp_clasificacion = clasificacion;
                clasificacion = [];
                for (var i = 0; i < temp_clasificacion.length; i++) {
                    if(temp_clasificacion[i] != valor){
                        clasificacion.push(temp_clasificacion[i]);
                    }else{
                        $('.ch_clas').each(function(index, obj){
                            if($(this).prop('checked') && valor == $(this).val()){
                                $(this).prop('checked', false);
                            }
        				});
                    }
                }
            }
        break;
    }

    lista_filt_act.push(color);
    lista_filt_act.push(marc);
    lista_filt_act.push(precio_min);
    lista_filt_act.push(precio_max);
    lista_filt_act.push(capacidad);
	lista_filt_act.push(largo);
	lista_filt_act.push(ancho);
    lista_filt_act.push(clasificacion);

    if(tipo != 6){
        var i = 0;
        for (i = 0; i < lista_filt_act.length; i++) {
            if(Array.isArray(lista_filt_act[i]) && lista_filt_act.length>0){
                for (var j = 0; j < lista_filt_act[i].length; j++) {
					console.log(i);
                    valor = "'" + lista_filt_act[i][j] + "'";
                    list_activos += '<span onclick="filtros('+i+', '+valor+')"><i class="fa fa-times-circle" aria-hidden="true"></i>'+lista_filt_act[i][j]+'</span>'
                }
            }else if(lista_filt_act[i] != null && i === 2){
				    val_txt = '';
                    const formatPesos = new Intl.NumberFormat('en-US', {
                        style: 'currency',
                        currency: 'USD'
                    });
                    precio_1 = formatPesos.format(lista_filt_act[i]);
                    precio_2 = formatPesos.format(lista_filt_act[i+1]);

                    valor_pre = "'" + lista_filt_act[i] + "'";
                    valor2_pre = "'" + lista_filt_act[i+1] + "'";
                    if(lista_filt_act[i] == '-1'){
                        val_txt = 'Menos de ' + precio_2;
                    }else if(lista_filt_act[i+1] == '-1'){
                        val_txt = 'Mas de ' + precio_1;
                    }else{
                        val_txt = precio_1 +' - '+ precio_2 ;
                    }
                    if(i == 2){
                        list_activos += '<span onclick="filtros('+i+', '+valor_pre+', '+valor2_pre+', '+1+')"><i class="fa fa-times-circle" aria-hidden="true"></i>'+val_txt+'</span>';
                    }else{
                        list_activos += '<span onclick="filtros('+i+', '+valor_pre+', '+valor2_pre+')"><i class="fa fa-times-circle" aria-hidden="true"></i>'+val_txt+'</span>';
                    }
                    i++;
            }else if(lista_filt_act[i] != null && i == 5){
				list_activos += '<span onclick="filtros('+i+', '+valor+','+valor2+', '+1+')"><i class="fa fa-times-circle" aria-hidden="true"></i>'+valor+' x '+ valor2 +'</span>'
			}

            $("#filt_activ").html(list_activos);
        }
    }
	$('#page-loader').show();
	// console.log(tipo_orden);
    $.ajax('/Pruebas/filtros', {
    	type: 'GET',
    	data: {
    		'color':  color,
            'marca': marc,
            'id_grupo': id_g = id_g ? id_g : 0,
            'precio_min': precio_min,
            'precio_max': precio_max,
            'area_requerida': area_requerida,
            'text': txt_bus,
            'capacidad': capacidad,
            'orden': tipo_orden,
            'clasificacion': clasificacion
    	},
    	success: function (data) {
			// console.log(data);
            json = data.articulos;
			totales = json.length;
			nPag = Math.ceil(totales / xPag);
			// console.log(offset, hasta);
			mostrarLista(offset,hasta);
            $('#botones').html('');
			if(totales > 9){
				mostrarBotones(nPag);
				botones_click();
				$("#paginas_txt").show();
			}else{
				$("#paginas_txt").hide();
			}
			$('#page-loader').fadeOut(500);

    	},
    	error: function () {
    	}
    });
	// console.log(json);
}

function validaPrec(){
    if($("#min_pre").val() != '' && $("#max_pre").val() != '' && $("#max_pre").val() != 0 && $("#min_pre").val() != 0){
        $("#button-addon2").attr('disabled', false);
    }else{
        $("#button-addon2").attr('disabled', true);
    }
}

function enviaFiltro(ban){
	if(ban){
		filtros(5, $("#largo_area").val(), $("#ancho_area").val());
	}else{
		$('.chk_precio').each(function(index, obj){
			$(this).prop('checked', false);
		});
		filtros(2, $("#min_pre").val(), $("#max_pre").val());
	}
}

function validaMedidas(){
	if($("#largo_area").val() != '' && $("#ancho_area").val() != ''){
        $("#button-addon3").attr('disabled', false);
    }else{
        $("#button-addon3").attr('disabled', true);
    }
}

function limpiaFiltros(){
	marc = [];
	color = [];
	precio_min = null;
	precio_max = null;
	capacidad = [];
	lista_filt_act = [];
	$("#filt_activ").html('');
}
