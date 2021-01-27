<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoDescuento extends Model
{
    protected $table = 'web_codigos_descuentos';

    public function articulos(){
        return $this->hasMany('App\DescuentoArticulo', 'id', 'articulos');
    }
}
