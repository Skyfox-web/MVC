<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usuarios_mig extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'web_usuarios_mig';
    public $timestamps = false;
    protected $fillable = [
        'id', 'cliente_web', 'cliente', 'nombre', 'paterno', 'materno', 'nombre', 'fecha_nacimiento', 'ofertas', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];





}
