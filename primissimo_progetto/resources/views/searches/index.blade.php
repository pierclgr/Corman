
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Persone</h3>
                </div>
                <div class="panel-body" style="max-height: 400px; overflow: auto;">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($users as $u)
                        <div>
                            <div><img style="float: left;" src="http://via.placeholder.com/75x75"></div>
                            <div style="margin-left: 85px;"><h4><b>{{$u->name." ".$u->cognome}}</b></h4></div>
                            <div style="margin-left: 85px;"><h6>{{$u->affiliazione}}</h6></div>
                            <div style="margin-left: 85px;"><h6>{{$u->linea_ricerca}}</h6></div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading" ><h3>Gruppi</h3>
                </div>
                <div class="panel-body"style="max-height: 400px; overflow: auto;">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        @foreach($groups as $g)
                            <h4><b>{{ $g->nomeGruppo}}</b></h4>
                            <h6>{{$g->descrizioneGruppo}}</h6>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
