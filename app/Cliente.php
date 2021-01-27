<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'cat_clientes';


    public function usuario(){
        return $this->hasOne('App\User', 'cliente', 'cliente');
    }
}
