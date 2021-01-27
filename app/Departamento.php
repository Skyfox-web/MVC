<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'cat_departamentos';


    public function articulos(){
        return $this->hasMany('App\Articulo', 'departamento', 'departamento');
    }
    public function grupos(){
        return $this->hasMany('App\Grupo', 'departamento', 'departamento');
    }

}
