<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'cat_grupos_articulos';


    public function articulos(){
        return $this->hasMany('App\Articulo', 'grupo', 'grupo');
    }
}
