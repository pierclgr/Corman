@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-6" style="float: left">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Persone</h2>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>
                        @foreach($users as $u)
                        <li>{{ $u->name }} {{ $u->cognome }}</li>
                        @endforeach
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-6" style="float: right">
            <div class="panel panel-default">
                <div class="panel-heading"><h2>Gruppi</h2>
                </div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>
                        @foreach($groups as $g)
                        <li>{{ $g->titolo }}</li>
                        @endforeach</h3>
                </div>
            </div>
        </div>


    </div>
</div>
@endsection
