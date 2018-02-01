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
        $publications=DB::table('publications')->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'coautori')->where('idUser','=', $id)->get();
        return view ('users.index', ['publications' => $publications]);
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
        $user = $this->validate(request(), [
          'name' => '',
          'cognome' => '',
          'email' => '',
          'nazionalita' => '',
          'affiliazione' => '',
          'linea_ricerca' => '',
          'telefono' => ''
        ]);
        
        User::create($user);

        return back()->with('success', 'User has been added');;
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
        $id=Auth::id();
        $users = DB::table('users')->select('name', 'cognome', 'email', 'nazionalita', 'affiliazione', 'linea_ricerca', 'telefono')->where('users.id', '=', $id)->get();
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
            'email' => 'email',
            'nazionalita' => 'required',
            'affiliazione' => 'required',
            'linea_ricerca' => 'required',
            'telefono' => 'required'
        ]);

        $user->name = $request->get('name');
        $user->cognome = $request->get('cognome');
        $user->email = $request->get('email');
        $user->nazionalita = $request->get('nazionalita');
        $user->affiliazione = $request->get('affiliazione');
        $user->linea_ricerca = $request->get('linea_ricerca');
        $user->telefono = $request->get('telefono');
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
        $from_date=$_GET['from_date'];
        $to_date=$_GET['to_date'];
        if($title!=""&&$from_date!=""&&$to_date!="") {//inseriti titolo e date
            $publications = DB::table('publications')
                ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'coautori')->where('idUser', '=', $id)->where('titolo','LIKE','%'.$title.'%')->whereBetween('dataPubblicazione',[$from_date,$to_date])->get();
        }
        else if($title!="") {//inserito solo il titolo
            $publications = DB::table('publications')
                ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'coautori')->where('idUser', '=', $id)->where('titolo','LIKE','%'.$title.'%')->get();
        }
        else if($from_date!=""&&$to_date!="") {//inserite solo le date
            $publications = DB::table('publications')
                ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'coautori')->where('idUser', '=', $id)->whereBetween('dataPubblicazione',[$from_date,$to_date])->get();
        }
        else{
            $publications = DB::table('publications')
                ->select('id', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'coautori')->where('idUser', '=', $id)->get();            
        }
        return view ('users.index', ['publications' => $publications]);
    }
}
