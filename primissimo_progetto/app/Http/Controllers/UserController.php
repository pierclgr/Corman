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
        $users = DB::table('users')->select('name', 'cognome', 'dataNascita','visibilitaDN' , 'email', 'visibilitaE' , 'nazionalita', 'visibilitaN' , 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaT')->where('users.id', '=', $id)->get();
        $publications=DB::table('publications')->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'descrizione', 'coautori')->where('idUser','=', $id)->orderby('dataPubblicazione', 'desc')->get();
        return view ('users.index', ['users' => $users, 'publications' => $publications, 'filter'=>0]);
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
        
        Publication::create([
            'name' => $request['name'],
            'cognome' => $request['cognome'],
            'dataNascita' => $request['dataNascita'],
            'visibilitaDN' => $request['visibilitaDN'],
            'email' => $request['email'],
            'visibilitaE' => $request['visibilitaE'],
            'nazionalita' => $request['nazionalita'],
            'visibilitaN' => $request['visibilitaN'],
            'affiliazione' => $request['affiliazione'],
            'dipartimento' => $request['dipartimento'],
            'linea_ricerca' => $request['linea_ricerca'],
            'telefono' => $request['telefono'],
            'visibilitaT' => $request['visibilitaT']
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
        $users = DB::table('users')->select('id','name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaDN', 'visibilitaE', 'visibilitaN', 'visibilitaT')->where('users.id', '=', $id)->get();
        $publications=DB::table('publications')->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'descrizione', 'coautori')->where('idUser','=', $id)->where('visibilita','=','1')->orderby('dataPubblicazione', 'desc')->get();
        return view ('users.show', ['users' => $users, 'publications' => $publications, 'filter'=>0]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id=Auth::id();
        $users = DB::table('users')->select('name', 'cognome', 'dataNascita','visibilitaDN' , 'email', 'visibilitaE' , 'nazionalita', 'visibilitaN' , 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaT')->where('users.id', '=', $id)->get();
        return view('users.edit',compact('users','id'));
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
        $user=User::find($id);
        $this->validate(request(), [
            'name' => 'required',
            'cognome' => 'required',
            'dataNascita' => '',
            'visibilitaDN' => '',
            'email' => 'email',
            'visibilitaE' => '',
            'nazionalita' => 'required',
            'visibilitaN' => '',
            'affiliazione' => 'required',
            'dipartimento' => 'required',
            'linea_ricerca' => 'required',
            'telefono' => 'required',
            'visibilitaT' => ''
        ]);

        $user->name = $request->get('name');
        $user->cognome = $request->get('cognome');
        $user->dataNascita = $request->get('dataNascita');
        $user->visibilitaDN = $request->get('visibilitaDN');
        $user->email = $request->get('email');
        $user->visibilitaE = $request->get('visibilitaE');
        $user->nazionalita = $request->get('nazionalita');
        $user->visibilitaN = $request->get('visibilitaN');
        $user->affiliazione = $request->get('affiliazione');
        $user->linea_ricerca = $request->get('linea_ricerca');
        $user->telefono = $request->get('telefono');
        $user->visibilitaT = $request->get('visibilitaT');
        $user->save();
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

    public function filter(){
        $id=Auth::id();
        $title=$_GET['title'];
        $tags=$_GET['tags'];
        $from_date=$_GET['from_date'];
        $to_date=$_GET['to_date'];
        if($tags!=""){
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
        }else{
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
        }
        return view ('users.index', ['publications' => $publications, 'filter'=>1]);
    }

    public function userfilter($id){
        $title=$_GET['title'];
        $tags=$_GET['tags'];
        $from_date=$_GET['from_date'];
        $to_date=$_GET['to_date'];
        if($tags!=""){
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                    ->where('visibilita','=','1')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')->where('tags','LIKE','%'.$tags.'%')
                    ->where('visibilita','=','1')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
        }else{
            if($from_date!=""&&$to_date!="") {//inserite solo le date
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])
                    ->where('titolo','LIKE','%'.$title.'%')
                    ->where('visibilita','=','1')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
            else{
                $publications = DB::table('publications')
                    ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'descrizione', 'coautori')->where('idUser', '=', $id)
                    ->where('titolo','LIKE','%'.$title.'%')
                    ->where('visibilita','=','1')
                    ->orderby('dataPubblicazione', 'desc')->get();
            }
        }
        $users = DB::table('users')->select('id','name', 'cognome', 'dataNascita', 'email', 'nazionalita', 'affiliazione', 'dipartimento', 'linea_ricerca', 'telefono', 'visibilitaDN', 'visibilitaE', 'visibilitaN', 'visibilitaT')->where('users.id', '=', $id)->get();
        return view ('users.show', ['users'=> $users, 'publications' => $publications, 'filter'=>1]);
    }
}
