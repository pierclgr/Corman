<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paperSearcher extends Model
{
    /*INPUT: nome completo "nome cognome"
     *OUTPUT: array contente i paper con autore il nome di input
  	 *gli elementi dell'array sono id e info
  	 *info contiene:
  	 * -un array di autori identificato da 'authors' e chiamato 'author'
  	 * -'title', titolo del paper
  	 * -'venue', dove e' stato pubblicato
  	 * -'pages'
  	 * -'year'
  	 * -'type', tipo di articolo
  	 * -'key' 
  	 * -'doi', digital object identifier
  	 * -'ee',  non so bene, ma sembra un url che porta ad una pagina per acquisare l'articolo
  	 * -'url', url dell'articolo in dblp
    */
    public static function search($fullname){

        $url = "http://dblp.org/search/publ/api?q=" . urlencode($fullname) . "&format=json";        
        $result = file_get_contents($url);

    	$var = json_decode($result, true);

    	$res = $var['result']['hits']['hit'];
    	
    	$output=array();
    	foreach ($var['result']['hits']['hit'] as $hit) { 
    		# code...
    		$add=false;
    		//bisogna controllare che tutti i paper trovati siano dell'autore cercato
    		foreach ($hit['info']['authors']['author'] as $aut) {
    			# code...
    			if( strtolower($aut) === strtolower($name) ){
    				$add=true;
    			}
    		}
    		if($add){
    			$tmp=array();
    			$tmp[]=['id' => $hit['@id']];
    			$tmp[]=['info' => $hit['info']];
    			$output[]=$tmp;
    		}
    	}

    	return $output;
    }
}
