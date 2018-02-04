<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::id();
        $users = DB::table('users')->select('name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono')->where('users.id', '=', $id)->get();
        $publications=DB::table('publications')->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'coautori')->where('idUser','=', $id)->get();
        return view ('users.index', ['users' => $users, 'publications' => $publications]);
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
        $user = $request->validate([
          'name' => '',
          'cognome' => '',
          'dataNascita' => '',
          'visibilitaDN' => '',
          'email' => '',
          'visibilitaE' => '',
          'nazionalita' => '',
          'visibilitaN' => '',
          'affiliazione' => '',
          'dipartimento' => '',
          'linea_ricerca' => '',
          'telefono' => '',
          'visibilitaT' => ''
        ]);
        
        User::create([
            'name' => $request['name'],
            'cognome' => $request['cognome'],
            'dataNascita' => $request['dataNascita'],
            'visibilitaDN' => 1,
            'email' => $request['email'],
            'visibilitaE' => 1,
            'nazionalita' => $request['nazionalita'],
            'visibilitaN' => 1,
            'affiliazione' => $request['affiliazione'],
            'dipartimento' => $request['dipartimento'],
            'linea_ricerca' => $request['linea_ricerca'],
            'telefono' => $request['telefono'],
            'visibilitaT' => 1
        ]);

        return back()->with('success', 'User has been added');
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
        $users = DB::table('users')->select('name', 'cognome', 'dataNascita', 'visibilitaDN', 'email', 'visibilitaE', 'nazionalita', 'visibilitaN', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaT')->where('users.id', '=', $id)->get();
        return view('users.edit', ['users' => $users]);
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
        $user = $request->validate([
          'name' => '',
          'cognome' => '',
          'dataNascita' => '',
          'visibilitaDN' => '',
          'email' => '',
          'visibilitaE' => '',
          'nazionalita' => '',
          'visibilitaN' => '',
          'affiliazione' => '',
          'dipartimento' => '',
          'linea_ricerca' => '',
          'telefono' => '',
          'visibilitaT' => ''
        ]);

        DB::table('users')->
            where('id', $id)->
            update(['name' => $request->get('name')],
                    ['cognome' => $request->get('cognome')],
                    ['dataNascita' => $request->get('dataNascita')],
                    ['visibilitaDN' => $request->get('visibilitaDN')],
                    ['email' => $request->get('email')],
                    ['visibilitaE' => $request->get('visibilitaE')],
                    ['nazionalita' => $request->get('nazionalita')],
                    ['visibilitaN' => $request->get('visibilitaN')],
                    ['affiliazione' => $request->get('affiliazione')],
                    ['linea_ricerca' => $request->get('linea_ricerca')],
                    ['telefono' => $request->get('telefono')],
                    ['visibilitaT' => $request->get('visibilitaT')]
            );
        return redirect('/home/user');
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
}
