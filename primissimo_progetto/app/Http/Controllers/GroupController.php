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
        return redirect('groups/'.urldecode( strval($idGroup->idGroup) ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $publications=DB::table('groups')//prendi le publicazioni nel gruppo
            ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
            ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
            ->join('users', 'users.id', '=', 'groupspublications.idUser')
            ->select('publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione')
            ->where('groups.idGroup', '=', $id)
            ->get();

        $adminID=DB::table('admins')//prendiamo gli admin del gruppo
            ->select('idUser')
            ->where('admins.idGroup', '=', $id);

        $admins=DB::table('users')//prendi i dati degli admin e del gruppo
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->join('groups', 'usersgroups.idGroup', '=', 'groups.idGroup')
            ->select('users.id', 'users.name', 'users.cognome', 'groups.idGroup', 'groups.nomeGruppo', 'groups.descrizioneGruppo')
            ->where('groups.idGroup', '=', $id)
            ->whereIn('users.id', $adminID)
            ->get();

        $users=DB::table('users')//prendi i dati degli utenti nel gruppo
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->select('users.id', 'users.name', 'users.cognome')
            ->where('usersgroups.idGroup', '=', $id)
            ->whereNotIn('users.id', $adminID)
            ->get();

        return view('groups.show', ['groupUsers' => $users, 'publications' => $publications, 'admins' => $admins]);
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
        //cerca le pubblicazioni gia condivise
        $subQuery = DB::table('groupspublications')->select('idPublication AS id')->where('idGroup', '=', $idGroup);
        
        $suePubblicazioni=DB::table('publications')//dalla tabella publications
            ->select('id', 'titolo', 'dataPubblicazione', 'tipo', 'tags', 'coautori')//mi prendi le cose essenziali di una pubblicazione da condividere
            ->where('idUser', '=', $id)//a patto che sia mia...
            //->where('visibilita', '=', '1')//... e che sia pubblica
            ->whereNotIn('id', $subQuery)//rimuove le pubblicazioni gia condivise
            ->get();
        return view('groups.rintraccia', ['suePubblicazioni' => $suePubblicazioni, 'idGroup' => $idGroup]);
    }

    public function aggiungi($idGroup)
    {
        $id=$_GET["pubID"];
        $descr=$_GET["descr".$id];
        DB::table('groupspublications')
            ->insert(['idUser' => Auth::id(), 'idGroup' => $idGroup, 'idPublication' => $id, 'descrizione' => $descr]);
        return redirect('groups/'.$idGroup);
    }
}
