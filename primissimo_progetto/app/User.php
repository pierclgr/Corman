<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'cognome',
        'dataNascita',
        'visibilitaDN',
        'email',
        'visibilitaE',
        'nazionalita',
        'visibilitaN',
        'affiliazione',
        'dipartimento',
        'linea_ricerca',
        'telefono',
        'visibilitaT',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
