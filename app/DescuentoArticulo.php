<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescuentoArticulo extends Model
{
    protected $table = 'web_articulos_restriccion';

    public function descuento(){
        return $this->belongsTo('App\CodigoDescuento', 'articulos', 'id');
    }


}
