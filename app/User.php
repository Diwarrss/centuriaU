<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'estado_user', 'roles_id', 'sedes_id'
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

    //para las relaciones Eloquent
    public function rol()
    {
        return $this->belongsTo('App\Role'); //un usuario pertenece a/tiene un Rol
    }

    //para las relaciones Eloquent
    public function sede()
    {
        return $this->belongsTo('App\Sede'); //un usuario pertenece a/tiene una Sede
    }
}
