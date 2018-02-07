<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Overview  $overview
     * @return \Illuminate\Http\Response
     */
    public function show(Overview $overview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Overview  $overview
     * @return \Illuminate\Http\Response
     */
    public function edit(Overview $overview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Overview  $overview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overview $overview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Overview  $overview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overview $overview)
    {
        //
    }

    public function acceptInv($idGroup){
        //rimuovi la richiesta
        DB::table('participationrequests')
            ->where('idGroup', '=', $idGroup)
            ->where('idUser', '=', Auth::id())
            ->delete();

        //entra nel gruppo
        DB::table('usersgroups')
            ->insert(['idGroup' => $idGroup, 'idUser' => Auth::id()]);

        return redirect('/groups/'.$idGroup);
    }

    public function declineInv($idGroup){
        //rimuovi la richiesta
        DB::table('participationrequests')
            ->where('idGroup', '=', $idGroup)
            ->where('idUser', '=', Auth::id())
            ->delete();

        return redirect('/home');
    }

    public function acceptReq($idGroup, $idUser){
        //rimuovi la richiesta
        DB::table('participationrequests')
            ->where('idGroup', '=', $idGroup)
            ->where('idUser', '=', $idUser)
            ->delete();

        //entra nel gruppo
        DB::table('usersgroups')
            ->insert(['idGroup' => $idGroup, 'idUser' => $idUser]);

        return redirect('/groups/'.$idGroup);
    }

    public function declineReq($idGroup, $idUser){
        //rimuovi la richiesta
        DB::table('participationrequests')
            ->where('idGroup', '=', $idGroup)
            ->where('idUser', '=', $idUser)
            ->delete();

        return redirect('/home');
    }

    public function getNews(){
        $id=Auth::id();

        //richieste che puoi accettare
        $reqAdmin=DB::table('participationrequests')
            ->join('admins', 'admins.idGroup', '=', 'participationrequests.idGroup')
            ->join('groups', 'groups.idGroup', '=', 'participationrequests.idGroup')
            ->join('users', 'users.id', '=', 'participationrequests.idUser')
            ->select('users.id', 'users.name', 'users.cognome', 'groups.idGroup', 'groups.nomeGruppo')
            ->where('admins.idUser', '=', $id)
            ->where('participationrequests.fromAdmin', '=', false)
            ->get();

        if(count($reqAdmin)>0){
            foreach ($reqAdmin as $req) {
                echo '<li><a style="text-align: center" href="/users/'.$req->id.'">'.$req->name.' '.$req->cognome.' wants to join '.$req->nomeGruppo.'</a></li>
                    <center style="margin-top: 10px;">
                        <a href="acceptreq/'.$req->idGroup.'/'.$req->id.'"><button class="btn btn-primary">Accept</button></a>
                        <a href="declinereq/'.$req->idGroup.'/'.$req->id.'"><button class="btn btn-primary">Decline</button></a>
                    </center>
                    <li><hr></li>';
            }
        }
        else{
            echo '<li><h5 style="text-align: center"><i>You have no requests</i></h5></li>
                <li><hr></li>';
        }

        //inviti ricevuti
        $invite=DB::table('participationrequests')
            ->join('groups', 'groups.idGroup', '=', 'participationrequests.idGroup')
            ->select('groups.idGroup', 'groups.nomeGruppo')
            ->where('participationrequests.idUser', '=', $id)
            ->where('participationrequests.fromAdmin', '=', true)
            ->get();
            
        if(count($invite)>0){
            foreach ($invite as $in) {
            echo '<li><a style="text-align: center" href="/groups/'.$in->idGroup.'">You have been invited to join '.$in->nomeGruppo.'</a></li>
                <center style="margin-top: 10px;">
                    <a href="acceptinvite/'.$in->idGroup.'"><button class="btn btn-primary">Accept</button></a>
                    <a href="declineinvite/'.$in->idGroup.'"><button class="btn btn-primary">Decline</button></a>
                </center>
                <li><hr></li>';
            }
        }
        else{
            echo '<li><h5 style="text-align: center"><i>You have no invites</i></h5></li>
                <li><hr></li>';
        }

        //richieste fatte pendenti
        $hang=DB::table('participationrequests')
            ->join('groups', 'groups.idGroup', '=', 'participationrequests.idGroup')
            ->select('groups.idGroup', 'groups.nomeGruppo')
            ->where('participationrequests.idUser', '=', $id)
            ->where('participationrequests.fromAdmin', '=', false)
            ->get();

        if(count($hang)>0){
            $i=0;
            foreach ($hang as $h) {
                echo '<li style="text-align: center">
                <a href="/groups/' . $h->idGroup . '">Your request to join ' . $h->nomeGruppo . ' is still hanging</li></a>
                <br>';
                $i++;
                if($i!=count($hang)){
                    echo '<li><hr></li>';
                }
            }
        }
        else{
            echo '<li><h5 style="text-align: center"><i>You have no hanging requests</i></h5></li>
                ';
        }
        //inviti inviati pendenti

    }
}
