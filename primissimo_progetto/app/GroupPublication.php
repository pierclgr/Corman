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

    //Ogni condivisione ha più commenti sotto
    public function comments() {
        return $this->hasMany('App\Models\Comment');
    }
}
