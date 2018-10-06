<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Overview extends Model
{
    protected $fillable= [
    	'idPublication',
    	'titolo',
    	'dataPubblicazione',
    	'pdf',
    	'immagine',
    	'multimedia',
        'tipo',
        'visibilita',
        'tags',
        'idUser'
    ];
}
