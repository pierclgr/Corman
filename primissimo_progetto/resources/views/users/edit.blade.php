@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <img class="img-responsive center-block" src="http://via.placeholder.com/250x250">
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">cake</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;">27/12/1996</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">email</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;">{{ Auth::user()->email }}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">phone</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{Auth::user()->telefono}}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">language</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{Auth::user()->nazionalita}}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">location_on</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> Dipartimento di Informatica, Via Orabona,9 Bari IT</h7></div></div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h1>{{Auth::user()->name." ".Auth::user()->cognome}}</h1>
            <h4>{{Auth::user()->affiliazione." - ".Auth::user()->linea_ricerca}}</h4>
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
                        <h3>Your profile details</h3>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                                @foreach($users as $u)
                                                    <tr>
                                                        <td>First Name</td><td><input class="form-control" id="name" name="name" type="text" value="{{ $u->name }}" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Last Name</td><td><input class="form-control" id="cognome" name="cognome" type="text" value="{{ $u->cognome }}" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>E-mail</td><td><input class="form-control" id="email" name="email" type="text" value="{{ $u->email }}" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nationality</td><td><input class="form-control" id="nazionalita" name="nazionalita" type="text" value="{{ $u->nazionalita }}" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Affiliation</td><td><input class="form-control" id="affiliazione" name="affiliazione" type="text" value="{{ $u->affiliazione }}" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Research Field</td><td><input class="form-control" id="linea_ricerca" name="linea_ricerca" type="text" value="{{ $u->linea_ricerca }}" /></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Phone</td><td><input class="form-control" id="telefono" name="telefono" type="text" value="{{ $u->telefono }}" /></td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                <button style="float:right;" class="btn btn-success" name="submit" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
