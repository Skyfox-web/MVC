<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $table = 'web_carrito';

    public function articulos(){
        return $this->hasMany('App\ArticuloCarrito', 'id_carrito');
    }



}
