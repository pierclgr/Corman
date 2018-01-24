@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Attività recenti</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h2>Your profile details</h2>
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">My profile</a></li>
                            <li><a data-toggle="tab" href="#menu1">My publications</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <h3>My profile</h3>
                                <p>
                                    <div class="table-responsive">          
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>User ID</th>
                                                    <th>Firstname</th>
                                                    <th>Lastname</th>
                                                    <th>E-mail</th>
                                                    <th>Nationality</th>
                                                    <th>Affiliation</th>
                                                    <th>Research field</th>
                                                    <th>Phone</th>
                                                    <th>Edit your profile</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ Auth::id() }}</td>
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
                                </p>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <h3>My publications</h3>
                                <p>
                                    See all my publications <a href="{{action('PublicationController@index')}}"> here</a>.<br>
                                    Or, create a new one <a href="{{action('PublicationController@create')}}">here</a>.
                                </p>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
