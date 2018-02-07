<?php

namespace App\Http\Controllers;

use App\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $input=$_GET["input"];
        $users = Search::searchUser($input);
        $groups = Search::searchGroup($input);
        return view('searches.index', ["users"=>$users, "groups"=>$groups, "input" =>$input]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Searches only for people
     * 
     * @return \Illuminate\Http\Response
     */
    public function searchPeople(){
        $input=$_GET["input"];
        $users = Search::searchUser($input);
        return view('searches.index', ["users"=>$users, "groups"=>"", "input" =>$input]);
    }

    /**
     * Searches only for groups
     *
     * @return \Illuminate\Http\Response
     */
    public function searchGroups(){
        $input=$_GET["input"];
        $groups = Search::searchGroup($input);
        return view('searches.index', ["users"=>"", "groups"=>$groups, "input" =>$input]);
    }

    /**
     * helps the search
     *
     */
    public function helpSearch(){
        $input=$_GET['input'];
        $users=Search::searchUser($input);
        $groups=Search::searchGroup($input);
        foreach ($users as $user) {
            echo '<li><a href="/users/'.$users->id.'">'.$user->name.' '.$user->cognome.'</a></li>';
        }
        echo '<hr>';
        foreach ($groups as $group) {
            echo '<li><a href="/groups/'.$group->idGroup.'">'.$group->nomeGruppo.'</a></li>';
        }
    }
}
