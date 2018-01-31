@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Attività recenti</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @foreach($articles as $a)
                        <h1>{{ $a->nome }}</h2><br>
                        <h2>{{ $a->cognome }}</h1>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
