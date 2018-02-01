@extends('layouts.app')
<meta charset="UTF-8" http-equiv="X-UA-COMPATIBLE" content="IE=edge" name="viewport" contend="width=device-width, initial-scale=1">
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <img class="img-responsive center-block" src="http://via.placeholder.com/200x200">
        </div>
        <div class="col-md-10">
            <h2 style="text-align: center;">{{Auth::user()->name." ".Auth::user()->cognome}}</h2>
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home">My profile</a></li>
                        <li><a data-toggle="tab" href="#menu1">My publications</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>E-mail</th>
                                        <th>Nationality</th>
                                        <th>Affiliation</th>
                                        <th>Research field</th>
                                        <th>Phone</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @foreach($users as $u)
                                            <td>{{ $u->name }}</td>
                                            <td>{{ $u->cognome }}</td>
                                            <td>{{ $u->email }}</td>
                                            <td>{{ $u->nazionalita }}</td>
                                            <td>{{ $u->affiliazione }}</td>
                                            <td>{{ $u->linea_ricerca }}</td>
                                            <td>{{ $u->telefono }}</td>
                                            <td><a href="{{action('UserController@edit', Auth::id() )}}" class="btn btn-warning">Edit</a></td>
                                        @endforeach
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="tab-content">
                                @if(count($publications) >0)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Publication date</th>
                                                <th>PDF file</th>
                                                <th>Image</th>
                                                <th>Multimedia</th>
                                                <th>Type of publication</th>
                                                <th>Publication Tags</th>
                                                <th>List of coauthors</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($publications as $p)
                                                <tr>
                                                    <td>{{ $p->titolo }}</td>
                                                    <td>{{ $p->dataPubblicazione }}</td>
                                                    <td>{{ $p->pdf }}</td>
                                                    <td>{{ $p->immagine }}</td>
                                                    <td>{{ $p->multimedia }}</td>
                                                    <td>{{ $p->tipo }}</td>
                                                    <td>{{ $p->tags }}</td>
                                                    <td>{{ $p->coautori }}</td>
                                                    <td><a href="{{action('PublicationController@edit', [$p->id] )}}" class="btn btn-warning">Edit</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <strong>We're sorry, but you have never added a paper regarding your research field that you wrote...</strong><br><br>
                                    But, if you want, you can add a new one bor importing it from DBLP by simply pressing one of the buttons below!<br><br>
                                    <a href="{{action('PublicationController@create')}}" class="btn btn-info">Create a new paper</a>
                                    <button type="button" class="btn btn-info">Import my researchs from DBLP</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
