<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
    //
    public static function searchUser($input){
    	$users = DB::table('users')->select('id', 'name', 'cognome', 'immagineProfilo', 'affiliazione', 'linea_ricerca')->where('name','LIKE','%'.$input.'%')
    		->orWhere('cognome','LIKE','%'.$input.'%')->get();
    	return $users;
    }

    public static function searchGroup($input){
    	$groups = DB::table('groups')->select('idGroup', 'immagineGruppo', 'nomeGruppo', 'descrizioneGruppo')->where('nomeGruppo','LIKE','%'.$input.'%')->where('tipoVisibilita','=','1')->get();
    	return $groups;
    }

}
