<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Search extends Model
{
    //
    public static function searchUser($input){
    	$users = DB::table('users')->select('id', 'name', 'cognome')->where('name','LIKE','%'.$input.'%')
    		->orWhere('cognome','LIKE','%'.$input.'%')->get();
    	return $users;
    }

    public static function searchGroup($input){
    	$groups = DB::table('groups')->select('idGroup', 'titolo')->where('titolo','LIKE','%'.$input.'%')->get();
    	return $groups;
    }

}
