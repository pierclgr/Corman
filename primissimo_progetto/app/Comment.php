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

    //Ogni commento dipende da un solo gruppo
    public function groups() {
        return $this->hasOne('App\Models\Group');
    }

    //Ogni commento dipende da una sola pubblicazione
    public function publications() {
        return $this->hasOne('App\Models\Publication');
    }

    //Ogni commento è generato da un singolo utente
    public function users() {
        return $this->hasOne('App\Models\User');
    }
}
