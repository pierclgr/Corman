<?php

namespace App\Http\Controllers;

use App\Group;
use App\UserGroup;
use App\Admin;
use App\GroupPublication;
use App\Publication;
use Storage;
use Illuminate\Support\Facades\Redirect;
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
            ->select('idGroup', 'titolo', 'descrizione', 'immagineGruppo')->get();
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
            'tipoVisibilita' => 'required',
            'immagineGruppo' => '',
        ]);

        $esiste=DB::table('groups')
            ->select('nomeGruppo')
            ->where('nomeGruppo', '=', $request['nomeGruppo'])
            ->first();

        if(isset($esiste)){
            return Redirect::back()->withErrors(['Group name already taken!']);
        }else{
            if($request->hasFile('immagineGruppo')) {
                $fileName=$request['nomeGruppo'];
                $path=Storage::disk('groups_images_upload')->put('',$request->file('immagineGruppo'));
                Group::create([
                    'nomeGruppo' => $request['nomeGruppo'],
                    'descrizioneGruppo' => $request['descrizioneGruppo'],
                    'tipoVisibilita' => $request['tipoVisibilita'],
                    'immagineGruppo' => $path
                ]);
            } else {
                Group::create([
                    'nomeGruppo' => $request['nomeGruppo'],
                    'descrizioneGruppo' => $request['descrizioneGruppo'],
                    'tipoVisibilita' => $request['tipoVisibilita']
                ]);
            }
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

        //qui salvo nella tabella 'gruppi' il gruppo
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
            ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione' , 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
            ->where('groups.idGroup', '=', $id)
            ->orderby('groupspublications.dataoraGP', 'desc')
            ->get();

        $adminID=DB::table('admins')//prendiamo gli admin del gruppo
            ->select('idUser')
            ->where('admins.idGroup', '=', $id);

        $admins=DB::table('users')//prendi i dati degli admin e del gruppo
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->join('groups', 'usersgroups.idGroup', '=', 'groups.idGroup')
            ->select('users.id', 'users.name', 'users.cognome', 'groups.idGroup', 'groups.nomeGruppo', 'groups.descrizioneGruppo', 'groups.immagineGruppo', 'groups.tipoVisibilita')
            ->where('groups.idGroup', '=', $id)
            ->whereIn('users.id', $adminID)
            ->orderby('name', 'asc')
            ->get();

        $users=DB::table('users')//prendi i dati degli utenti nel gruppo
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->select('users.id', 'users.name', 'users.cognome')
            ->where('usersgroups.idGroup', '=', $id)
            ->whereNotIn('users.id', $adminID)
            ->orderby('name', 'asc')
            ->get();

        $code=0;
        //controlla se e nel gruppo
        $isPart=DB::table('usersgroups')
            ->select('idUser')
            ->where('usersgroups.idGroup', '=', $id)
            ->where('idUser', Auth::id())
            ->get();
        if(count($isPart)>0){
            //controlla se e un admin
            $isAdmin=DB::table('admins')
                ->select('idUser')
                ->where('idGroup', '=', $id)
                ->where('idUser', '=', Auth::id())
                ->get();
            if(count($isAdmin)>0){
                $code=2;
            }
            else{
                $code=1;
            }
        }
        else{
            //controlla richesta in pendenza
            $hasReq=DB::table('participationrequests')
                ->select('idUser')
                ->where('idUser', '=', Auth::id())
                ->where('idGroup', '=', $id)
                ->get();
            if(count($hasReq)>0)
                $code=3;
            else
                $code=0;
        }

        return view('groups.show', ['groupUsers' => $users, 'publications' => $publications, 'admins' => $admins, 'code' => $code, 'filter' => 0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($idGroup)
    {
        $groups = DB::table('groups')
            ->select('idGroup','nomeGruppo', 'descrizioneGruppo', 'immagineGruppo', 'tipoVisibilita')
            ->where('idGroup','=',$idGroup)->get();

        $code=0;
        //controlla se e nel gruppo
        $isPart=DB::table('usersgroups')
            ->select('idUser')
            ->where('usersgroups.idGroup', '=', $idGroup)
            ->where('idUser','=' ,Auth::id())
            ->get();
        if(count($isPart)>0){
            //controlla se e un admin
            $isAdmin=DB::table('admins')
                ->select('idUser')
                ->where('idGroup', '=', $idGroup)
                ->where('idUser', '=', Auth::id())
                ->get();
            if(count($isAdmin)>0){
                $code=2;
            }
            else{
                $code=1;
            }
        }
        else{
            //controlla richesta in pendenza
            $hasReq=DB::table('participationrequests')
                ->select('idUser')
                ->where('idUser', '=', Auth::id())
                ->where('idGroup', '=', $idGroup)
                ->get();
            if(count($hasReq)>0)
                $code=3;
            else
                $code=0;
        }

        return view('groups.edit', ['groups' => $groups, 'code' => $code]);
    }


    public function uploadGroupImage(Request $request, $idGroup){
        $group=DB::table('groups')
            ->select('idGroup','nomeGruppo','descrizioneGruppo', 'tipoVisibilita', 'immagineGruppo')
            ->where('idGroup','=',$idGroup)
            ->get();
        $valG=$request->validate([
            'immagineGruppo' => '',
        ]);

        if($request->hasFile('immagineGruppo')) {
            $path=Storage::disk('groups_images_upload')->put('',$request->file('immagineGruppo'));

            $group->immagineGruppo = $path;
            DB::table('groups')
                ->where('idGroup','=',$idGroup)
                ->update(['immagineGruppo' => $group->immagineGruppo]);
        }
        //ma poi ne recupero l'id per settare le chiavi esterne nelle due tabelle N:N 'admins' e 'usersgroups'

        return redirect('/groups/'.$idGroup);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idGroup)
    {
        $group=DB::table('groups')
            ->select('idGroup','nomeGruppo','descrizioneGruppo', 'tipoVisibilita', 'immagineGruppo')
            ->where('idGroup','=',$idGroup)
            ->get();
        $valG=$request->validate([
            'descrizioneGruppo' => 'max:191',
            'tipoVisibilita' => 'required',
            'immagineGruppo' => '',
        ]);

        if($request->hasFile('immagineGruppo')) {
            $path=Storage::disk('groups_images_upload')->put('',$request->file('immagineGruppo'));
            $group->descrizioneGruppo = $request['descrizioneGruppo'];
            $group->tipoVisibilita = $request['tipoVisibilita'];
            $group->immagineGruppo = $path;
            DB::table('groups')
                ->where('idGroup','=',$idGroup)
                ->update(['descrizioneGruppo' => $group->descrizioneGruppo, 'tipoVisibilita' => $group->tipoVisibilita, 'immagineGruppo' => $group->immagineGruppo]);
        } else {
            $group->descrizioneGruppo = $request['descrizioneGruppo'];
            $group->tipoVisibilita = $request['tipoVisibilita'];
            DB::table('groups')
                ->where('idGroup','=',$idGroup)
                ->update(['descrizioneGruppo' => $group->descrizioneGruppo, 'tipoVisibilita' => $group->tipoVisibilita]);
        }
        //ma poi ne recupero l'id per settare le chiavi esterne nelle due tabelle N:N 'admins' e 'usersgroups'

        return redirect('/groups/'.$idGroup);
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

    /**
     * Removes the user from the group
     *
     */
    public function quit($idGroup){
        //removes if admin
        DB::table('admins')
            ->where('idGroup', '=', $idGroup)
            ->where('idUser', '=', Auth::id())
            ->delete();

        //removes
        DB::table('usersgroups')
            ->where('idGroup', '=', $idGroup)
            ->where('idUser', '=', Auth::id())
            ->delete();

        //deletes group and requests if empty
        if(!(count(DB::table('admins')->where('idGroup', '=', $idGroup)->get()) > 0)){
            DB::table('participationrequests')->where('idGroup', '=', $idGroup)->delete();
            DB::table('groups')->where('idGroup', '=', $idGroup)->delete();
        }

        return redirect('home');
    }

    public function rintraccia($idGroup, $id)
    {
        //cerca le pubblicazioni gia condivise
        $subQuery = DB::table('groupspublications')->select('idPublication AS id')->where('idGroup', '=', $idGroup);
        
        $suePubblicazioni=DB::table('publications')//dalla tabella publications
            ->select('id', 'titolo', 'dataPubblicazione', 'tipo', 'tags', 'coautori')//mi prendi le cose essenziali di una pubblicazione da condividere
            ->where('idUser', '=', $id)//a patto che sia mia...
            ->where('visibilita', '=', '1')//... e che sia pubblica
            ->whereNotIn('id', $subQuery)//rimuove le pubblicazioni gia condivise
            ->get();
        return view('groups.rintraccia', ['suePubblicazioni' => $suePubblicazioni, 'idGroup' => $idGroup, 'filter' => 0]);
    }

    public function aggiungi($idGroup)
    {
        $id=$_GET["pubID"];
        $descr=$_GET["descr".$id];
        DB::table('groupspublications')
            ->insert(['idUser' => Auth::id(), 'idGroup' => $idGroup, 'idPublication' => $id, 'descrizione' => $descr]);
        return redirect('groups/rintraccia/'.$idGroup."/".Auth::id());
    }

    /**
     * searches for partecipants for groups
     *
     */
    function searchPartecipants($idGroup){
        //cerca gli utenti gia nel gruppo per scremare il risultato
        $part=DB::table('users')
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->select('users.id')
            ->where('usersgroups.idGroup', '=', $idGroup);

        $hasReq=DB::table('participationrequests')
            ->select('idUser')
            ->where('idGroup', '=', $idGroup);

        $users = DB::table('users')->select('id', 'name', 'cognome', 'affiliazione', 'linea_ricerca')
            ->whereNotIn('users.id', $part)
            ->whereNotIn('users.id', $hasReq)
            ->get();

        return view('groups/adduser',["users" => $users, "idGroup" => $idGroup, 'filter' => 0]);
    }

    function addPartecipants($idGroup){
        $id=$_GET["userID"];
        DB::table('participationrequests')
            ->insert(['idUser' => $id, 'idGroup' => $idGroup, 'fromAdmin' => true]);
        return redirect('searchPartecipants/'.$idGroup);
    }

    function sendReq($idGroup){
        $id=Auth::id();
        DB::table('participationrequests')
            ->insert(['idUser' => $id, 'idGroup' => $idGroup, 'fromAdmin' => false]);
        return redirect('groups/'.$idGroup);
    }

    function promote($idGroup, $idUser){
        DB::table('admins')
            ->insert(['idGroup' => $idGroup, 'idUser' => $idUser]);
        return redirect('groups/'.$idGroup);
    }

    function getGroups(){
        $id=Auth::id();
        
        $admined=DB::table('groups')
            ->join('admins', 'admins.idGroup', '=', 'groups.idGroup')
            ->select('groups.idGroup', 'groups.nomeGruppo')
            ->where('admins.idUser', '=', $id)
            ->get();

        $other=DB::table('groups')
            ->join('usersgroups', 'usersgroups.idGroup', '=', 'groups.idGroup')
            ->select('groups.idGroup', 'groups.nomeGruppo')
            ->where('usersgroups.idUser', '=', $id)
            ->whereNotIn('groups.idGroup', $admined->pluck('idGroup'))
            ->get();    

        if( (count($admined) + count($other)) >0){
            echo '<h5 style="margin-left: 10px">Administrated groups</h5>';
            if(count($admined)>0){
                foreach ($admined as $g) {
                    echo '<li><a style="padding-left: 30px;"  href="/groups/'.$g->idGroup.'">'.$g->nomeGruppo.'</a></li>';
                }
            }
            else
                echo '<h6 style="margin-top: 20px; text-align: center"><i>You administrate no groups</i></h6>';
            echo '<li><hr></li>';
            echo '<h5 style="margin-left: 10px">Your other groups</h5>';
            if(count($other)>0){
                foreach ($other as $g) {
                    echo '<li><a style="padding-left: 30px;" href="/groups/'.$g->idGroup.'">'.$g->nomeGruppo.'</a></li>';
                }
            }
            else{
                echo '<h6 style="text-align: center"><i>You participate in no other groups</i></h6>';
            }
        }
        else{
            echo '<h5 style="margin-top: 20px; text-align: center">You participate in no groups, yet</h5>';
            echo '<li><a href="/groups/create" style="text-align: center; margin-top: 20px;">Create a new group</a></li>';
            echo '<li>
                <a href="/home/search/groups?input=" style="text-align: center;margin-top: 20px; margin-bottom: 20px;">Search for public groups</a>
                </li>';
        }

    }

    function filter($id){
        $title=$_GET['title'];
        $tags=$_GET['tags'];
        $from_date=$_GET['from_date'];
        $to_date=$_GET['to_date'];

        if($tags!=""){
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                if($from_date==$to_date){
                    $publications = DB::table('groups')//prendi le publicazioni nel gruppo
                    ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
                    ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
                    ->join('users', 'users.id', '=', 'groupspublications.idUser')
                        ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione', 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
                        ->where('groups.idGroup', '=', $id)
                        ->where('groupspublications.dataoraGP','LIKE',$from_date.'%')
                        ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                        ->orderby('groupspublications.dataoraGP', 'desc')
                        ->get();
                }else{
                    $publications = DB::table('groups')//prendi le publicazioni nel gruppo
                    ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
                    ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
                    ->join('users', 'users.id', '=', 'groupspublications.idUser')
                        ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione', 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
                        ->where('groups.idGroup', '=', $id)
                        ->whereBetween('groupspublications.dataoraGP',[$from_date,$to_date])
                        ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                        ->orderby('groupspublications.dataoraGP', 'desc')
                        ->get();
                }
            }
            else{
                $publications = DB::table('groups')//prendi le publicazioni nel gruppo
                ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
                ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
                ->join('users', 'users.id', '=', 'groupspublications.idUser')
                    ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione', 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
                    ->where('groups.idGroup', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                    ->orderby('groupspublications.dataoraGP', 'desc')
                    ->get();
            }
        }else{
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                if($from_date==$to_date){
                    $publications = DB::table('groups')//prendi le publicazioni nel gruppo
                    ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
                    ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
                    ->join('users', 'users.id', '=', 'groupspublications.idUser')
                        ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione', 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
                        ->where('groups.idGroup', '=', $id)
                        ->where('groupspublications.dataoraGP','LIKE',$from_date.'%')
                        ->where('titolo','LIKE','%'.$title.'%')
                        ->orderby('groupspublications.dataoraGP', 'desc')
                        ->get();
                }else{
                    $publications = DB::table('groups')//prendi le publicazioni nel gruppo
                    ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
                    ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
                    ->join('users', 'users.id', '=', 'groupspublications.idUser')
                        ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione', 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
                        ->where('groups.idGroup', '=', $id)
                        ->whereBetween('groupspublications.dataoraGP',[$from_date,$to_date])
                        ->where('titolo','LIKE','%'.$title.'%')
                        ->orderby('groupspublications.dataoraGP', 'desc')
                        ->get();
                }
            }
            else{
                $publications = DB::table('groups')//prendi le publicazioni nel gruppo
                ->join('groupspublications', 'groups.idGroup', '=', 'groupspublications.idGroup')//da qui andiamo alla tabella dei post nei gruppi
                ->join('publications', 'groupspublications.idPublication', '=', 'publications.id')//per risalire alla/e pubblicazione/i
                ->join('users', 'users.id', '=', 'groupspublications.idUser')
                    ->select('users.id', 'publications.tipo', 'publications.descrizione AS descr', 'publications.pdf', 'publications.tags', 'publications.coautori', 'publications.dataPubblicazione', 'publications.titolo', 'users.name', 'users.cognome', 'groupspublications.descrizione', 'groupspublications.dataoraGP', 'publications.id AS idPub')
                    ->where('groups.idGroup', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')
                    ->orderby('groupspublications.dataoraGP', 'desc')
                    ->get();
            }
        }

        $adminID=DB::table('admins')//prendiamo gli admin del gruppo
        ->select('idUser')
            ->where('admins.idGroup', '=', $id);

        $admins=DB::table('users')//prendi i dati degli admin e del gruppo
        ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->join('groups', 'usersgroups.idGroup', '=', 'groups.idGroup')
            ->select('users.id', 'users.name', 'users.cognome', 'groups.idGroup', 'groups.immagineGruppo' , 'groups.nomeGruppo', 'groups.descrizioneGruppo')
            ->where('groups.idGroup', '=', $id)
            ->whereIn('users.id', $adminID)
            ->get();

        $users=DB::table('users')//prendi i dati degli utenti nel gruppo
        ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->select('users.id', 'users.name', 'users.cognome')
            ->where('usersgroups.idGroup', '=', $id)
            ->whereNotIn('users.id', $adminID)
            ->get();

        $code=0;
        //controlla se e nel gruppo
        $isPart=DB::table('usersgroups')
            ->select('idUser')
            ->where('usersgroups.idGroup', '=', $id)
            ->where('idUser', Auth::id())
            ->get();
        if(count($isPart)>0){
            //controlla se e un admin
            $isAdmin=DB::table('admins')
                ->select('idUser')
                ->where('idGroup', '=', $id)
                ->where('idUser', '=', Auth::id())
                ->get();
            if(count($isAdmin)>0){
                $code=2;
            }
            else{
                $code=1;
            }
        }
        else{
            //controlla richesta in pendenza
            $hasReq=DB::table('participationrequests')
                ->select('idUser')
                ->where('idUser', '=', Auth::id())
                ->where('idGroup', '=', $id)
                ->get();
            if(count($hasReq)>0)
                $code=3;
            else
                $code=0;
        }

        return view('groups.show', ['groupUsers' => $users, 'publications' => $publications, 'admins' => $admins, 'code' => $code, 'filter' => 1]);
    }

    function userfilter($idGroup){
        $firstName=$_GET['firstName'];
        $lastName=$_GET['lastName'];
        $part=DB::table('users')
            ->join('usersgroups', 'users.id', '=', 'usersgroups.idUser')
            ->select('users.id')
            ->where('usersgroups.idGroup', '=', $idGroup);

        $hasReq=DB::table('participationrequests')
            ->select('idUser')
            ->where('idGroup', '=', $idGroup);

        $users = DB::table('users')->select('id', 'name', 'cognome', 'affiliazione', 'linea_ricerca')
            ->whereNotIn('users.id', $part)
            ->whereNotIn('users.id', $hasReq)
            ->where('users.name', 'LIKE', '%'.$firstName.'%')
            ->where('users.cognome', 'LIKE', '%'.$lastName.'%')
            ->get();

        return view('groups/adduser',["users" => $users, "idGroup" => $idGroup, 'filter' => 1]);
    }

    function publicationfilter($idGroup, $id){
        $title=$_GET['title'];
        $tags=$_GET['tags'];

        $subQuery = DB::table('groupspublications')->select('idPublication AS id')->where('idGroup', '=', $idGroup);

        if($tags!=""){
            $suePubblicazioni=DB::table('publications')//dalla tabella publications
            ->select('id', 'titolo', 'dataPubblicazione', 'tipo', 'tags', 'coautori')//mi prendi le cose essenziali di una pubblicazione da condividere
            ->where('idUser', '=', $id)//a patto che sia mia...
            ->where('visibilita', '=', '1')//... e che sia pubblica
            ->whereNotIn('id', $subQuery)//rimuove le pubblicazioni gia condivise
            ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
            ->orderby('dataPubblicazione', 'desc')
            ->get();
        }else{
            $suePubblicazioni=DB::table('publications')//dalla tabella publications
            ->select('id', 'titolo', 'dataPubblicazione', 'tipo', 'tags', 'coautori')//mi prendi le cose essenziali di una pubblicazione da condividere
            ->where('idUser', '=', $id)//a patto che sia mia...
            ->where('visibilita', '=', '1')//... e che sia pubblica
            ->whereNotIn('id', $subQuery)//rimuove le pubblicazioni gia condivise
            ->where('titolo','LIKE','%'.$title.'%')
                ->orderby('dataPubblicazione', 'desc')
                ->get();
        }
        return view('groups.rintraccia', ['suePubblicazioni' => $suePubblicazioni, 'idGroup' => $idGroup, 'filter' => 1]);
    }
}
