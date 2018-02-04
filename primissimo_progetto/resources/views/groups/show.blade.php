@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">
                    @if(count($group)>0)
                        <div name="al_latoSX" style="text-align: left;"><h1>{{ $group[0]->nomeGruppo }}</h1><br>{{ $group[0]->descrizioneGruppo }}</div>
                        <div name="al_latoDX" style="text-align: right;">ESCI</div>
                    @endif
                </div>
                <div class="panel-body">
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
                    @if(count($publications)>0)
                        @foreach($publications as $p)
                            {{ $p->titolo }}<br>
                        @endforeach
                    @else
                        <strong>NESSUNA PUBBLICAZIONE PRESENTE IN QUESTO GRUPPO!</strong>
                    @endif
                    
                    <br>
                    <a href="{{route('groups.rintraccia', [$group[0]->idGroup, Auth::user()->id] )}}">
                    <button type="button" class="btn btn-primary">Add a publication in this group</button>
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
