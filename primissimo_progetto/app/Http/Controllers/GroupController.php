<?php

namespace App\Http\Controllers;

use App\Group;
use App\UserGroup;
use App\Admin;
use App\GroupPublication;
use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups=DB::table('groups')
            ->select('idGroup, titolo, descrizione')->get();
            return view('groups.index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valG=$request->validate([
            'nomeGruppo' => 'required|max:100',
            'descrizioneGruppo' => 'max:191',
            'tipoVisibilita' => 'required'
        ]);
        //qui salvo nella tabella 'gruppi' il gruppo
        Group::create([
            'nomeGruppo' => $request['nomeGruppo'],
            'descrizioneGruppo' => $request['descrizioneGruppo'],
            'tipoVisibilita' => $request['tipoVisibilita']
        ]);
        //ma poi ne recupero l'id per settare le chiavi esterne nelle due tabelle N:N 'admins' e 'usersgroups'
        $idGroup=DB::table('groups')->select('idGroup')
            ->where('nomeGruppo', '=', $request['nomeGruppo'])->first();
        $idUser=Auth::id();
        DB::table('admins')->insert([
            ['idGroup' => $idGroup->idGroup,  'idUser' => $idUser]
        ]);
        DB::table('usersgroups')->insert([
            ['idGroup' => $idGroup->idGroup,  'idUser' => $idUser]
        ]);
        return redirect('groups/'.urldecode($idGroup));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group=DB::table('users')
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')//dalla tabella Utenti andiamo a quella UtentiGruppi
            ->join('groups', 'usersgroups.idGroup', '=', 'groups.idGroup')//per poi andare a quella Gruppi
            ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
            ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
            ->select('groups.idGroup', 'users.id', 'groups.nomeGruppo', 'groups.descrizioneGruppo', 'publications.titolo')
            ->where('groups.idGroup', '=', $id)
            ->where('groups.tipoVisibilita', '=', '1')
            ->get();
        return view('groups.show', ['group' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }

    public function rintraccia($idGroup, $id)
    {
        $suePubblicazioni=DB::table('publications')//dalla tabella publications
            ->select('id', 'titolo', 'dataPubblicazione', 'tipo', 'tags', 'coautori')//mi prendi le cose essenziali di una pubblicazione da condividere
            ->where('idUser', '=', $id)//a patto che sia mia...
            ->where('visibilita', '=', '1')//... e che sia pubblica
            ->whereNotIn('id',function($query) {//tuttavia questa non deve...
                $query->select('idUser')->from('groupspublications');//...essere mai stata condivisa altrove
            })
            ->get();
        $idGruppo=['idGroup' => $idGroup];
        return view('groups.rintraccia', ['suePubblicazioni' => $suePubblicazioni, 'idGruppo' => $idGruppo]);
    }

    public function aggiungi($idGroup, $id)
    {
        DB::table('groupspublications')
            ->insert(['idUser' => Auth::id(), 'idGroup' => $idGroup, 'idPublication' => $id, 'descrizione' => ""]);
        return GroupController::show($idGroup);
    }
}
