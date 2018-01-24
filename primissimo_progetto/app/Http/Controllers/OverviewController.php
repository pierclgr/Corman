<?php

namespace App\Http\Controllers;

use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = DB::table('publications')
            ->select('idPublication', 'titolo', 'dataPubblicazione', 'pdf', 'immagine', 'multimedia', 'tipo', 'tags')
            ->where('visibilita', '=', '1')->get();
        return view ('overviews.index', ['publications' => $publications]);
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
}
