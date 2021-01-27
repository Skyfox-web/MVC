<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    protected $table = 'cat_bodegas';

    // public function departamento(){
    //     return $this->belongsTo('App\Departamento', 'departamento', 'departamento');
    // }
    // public function grupo(){
    //     return $this->belongsTo('App\Grupo', 'grupo', 'grupo');
    // }

}
