<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'web_usuarios';


    public function cliente(){
        return $this->belongsTo('App\Cliente', 'cliente', 'cliente');
    }
}
