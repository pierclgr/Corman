<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idComment',
        'idGroup',
        'idPublication',
        'idUser',
        'descrizione',
        'dataoraC'
    ];
}
