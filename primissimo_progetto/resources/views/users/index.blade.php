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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
