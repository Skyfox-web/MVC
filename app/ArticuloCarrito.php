<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticuloCarrito extends Model
{
    protected $table = 'web_articulos_carrito';

    public function carrito(){
        return $this->belongsTo('App\Carrito', 'id');
    }
    // public function grupo(){
    //     return $this->belongsTo('App\Grupo', 'grupo', 'grupo');
    // }

}
