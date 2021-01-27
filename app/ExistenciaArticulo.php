<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExistenciaArticulo extends Model
{
    protected $table = 'cat_articulos_existencias';

    // public function departamento(){
    //     return $this->belongsTo('App\Departamento', 'departamento', 'departamento');
    // }
    // public function grupo(){
    //     return $this->belongsTo('App\Grupo', 'grupo', 'grupo');
    // }

}
