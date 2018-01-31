<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipationRequest extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idGroup',
        'idUser'
    ];
}
