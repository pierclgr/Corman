<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Publication;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check=DB::table('publications')
            ->select('id')
            ->where('idUser', '=', Auth::id())
            ->get();
        if(count($check)==0){
            PublicationController::import();
        }

        $news=DB::table('groupspublications')//pubblicazioni nei gruppi
            ->join('groups', 'groups.idGroup', '=', 'groupspublications.idGroup')//trova i gruppi
            ->join('publications', 'publications.id', '=', 'groupspublications.idPublication')//trova le pubblicazioni
            ->join('users', 'users.id', '=', 'groupspublications.idUser')//trova gli autori
            ->join('usersgroups', 'usersgroups.idGroup', '=', 'groupspublications.idGroup')//trova i miei gruppi
            ->select('users.id', 'users.name', 'users.cognome', 'groups.idGroup', 'groups.nomeGruppo', 'publications.titolo', 'publications.tags', 'groupspublications.descrizione')
            ->where('usersgroups.idUser', '=', Auth::id())
            ->get();

        return view ('overviews.index', ['news' => $news]);
    }
}
