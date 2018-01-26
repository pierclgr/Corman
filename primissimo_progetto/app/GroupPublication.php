<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupPublication extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idUser',
        'idGroup',
        'idPublication',
        'descrizione',
        'dataoraGP'
    ];
}
