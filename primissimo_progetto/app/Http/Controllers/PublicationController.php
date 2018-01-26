<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id=Auth::id();
        $publications = DB::table('publications')
            ->select('idPublication', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags', 'coautori')
            ->where('idUser', '=', $id)->get();
        return view ('publications.index', ['publications' => $publications]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('publications.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'titolo' => 'required|max:255',
            'dataPubblicazione' => '',
            'pdf' => 'mimes:application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf|max:10000',
            'immagine' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'multimedia' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tipo' => 'required',
            'visibilita' => '',
            'tags' => 'max:255',
            'coautori' => 'max:255',
            'idUser' => ''
        ]);
        Publication::create([
            'titolo' => $request['titolo'],
            'dataPubblicazione' => date('Y-m-d H:i:s'),
            'pdf' => '',
            'immagine' => '',
            'multimedia' => '',
            'tipo' => $request['tipo'],
            'visibilita' => $request['visibilita'],
            'tags' => $request['tags'],
            'coautori' => $request['coautori'],
            'idUser' => Auth::id()
        ]);
        return redirect()->route('home');
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
        $publications = DB::table('publications')
            ->select('idPublication', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'visibilita', 'tags', 'coautori', 'idUser')
            ->where('idPublication', '=', $id)
            ->where('idUser', '=', Auth::id())->get();
        return view('publications.edit', ['publications' => $publications]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idPublication)
    {
        //$idPublication=$id;
        $publication=DB::table('publications')->where('idPublication',$idPublication)->update(['titolo' => $request->get('titolo')], ['tipo' => $request->get('tipo')], ['visibilita' => $request->get('visibilita')], ['tags' => $request->get('tags')], ['coautori' => $request->get('coautori')]);
        $this->validate($request, [
            'titolo' => 'required|max:255',
            'dataPubblicazione' => '',
            'pdf' => 'mimes:application/pdf, application/x-pdf,application/acrobat, applications/vnd.pdf, text/pdf, text/x-pdf|max:10000',
            'immagine' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'multimedia' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tipo' => 'required',
            'visibilita' => '',
            'tags' => 'required',
            'coautori' => 'required',
            'idUser' => ''
        ]);
        return redirect()->route('home');
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
