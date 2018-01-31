<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idGroup',
        'titolo',
        'descrizione'
    ];
}
