@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
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
                        <form method="post" action="{{action('UserController@update', Auth::id() )}}">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="PUT">
                            <h2>Your profile details</h2>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <p>
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        @foreach($users as $u)
                                                            <td><input class="form-control" id="name" name="name" type="text" value="{{ $u->name }}" /></td>
                                                            <td><input class="form-control" id="cognome" name="cognome" type="text" value="{{ $u->cognome }}" /></td>
                                                            <td><input class="form-control" id="email" name="email" type="text" value="{{ $u->email }}" /></td>
                                                            <td><input class="form-control" id="nazionalita" name="nazionalita" type="text" value="{{ $u->nazionalita }}" /></td>
                                                            <td><input class="form-control" id="affiliazione" name="affiliazione" type="text" value="{{ $u->affiliazione }}" /></td>
                                                            <td><input class="form-control" id="linea_ricerca" name="linea_ricerca" type="text" value="{{ $u->linea_ricerca }}" /></td>
                                                            <td><input class="form-control" id="telefono" name="telefono" type="text" value="{{ $u->telefono }}" /></td>
                                                        @endforeach
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <button class="btn btn-success" name="submit" type="submit">Update</button>
                                        </div>
                                        </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
