<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable= [
    	'id',
    	'titolo',
    	'dataPubblicazione',
    	'dataCaricamento',
    	'pdf',
    	'immagine',
    	'multimedia'
    ];

    //Ogni pubblicazione ha più coautori (alias utenti)
    public function users() {
        return $this->hasMany('App\Models\User');
    }

    //Ogni pubblicazione può essere condivisa su più gruppi [...]
    public function groups() {
        return $this->hasMany('App\Models\Group');
    }
}
