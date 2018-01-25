<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable= [
    	'idPublication',
    	'titolo',
    	'dataPubblicazione',
    	'pdf',
    	'immagine',
    	'multimedia',
        'tipo',
        'idUser'
    ];
}
