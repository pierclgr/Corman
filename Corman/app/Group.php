<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Notifiable;

class Group extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idGroup',
        'nomeGruppo',
        'descrizioneGruppo',
        'immagineGruppo',
        'tipoVisibilita'
    ];
}
