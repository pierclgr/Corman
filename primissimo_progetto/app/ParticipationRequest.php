<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipationRequest extends Model
{

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
