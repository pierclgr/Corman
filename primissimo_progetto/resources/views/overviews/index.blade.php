@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Recent Activities</div>
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
                    <div class="tab-content">
                        @if(count($news) >0)
                            @foreach($news as $n)         
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4>
                                            <a href="/users/{{$n->id}}">{{$n->name}} {{$n->cognome}}</a>
                                             shared {{$n->titolo}} on 
                                            <a href="/groups/{{$n->idGroup}}">{{$n->nomeGruppo}}</a>
                                        </h4>
                                    </div>
                                    <div class="panel-body">
                                        <h5>{{$n->descrizione}}</h5>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <strong>There are no recent activities</strong><br><br>
                            Start with creating a new group, or search one already active
                            <br><br>
                            <form action="{{ action('SearchController@searchGroups') }}" method="GET">
                            <a href="/home/user" class="btn btn-info">Visit your profile</a>
                            <a href="/groups/create" class="btn btn-info">
                                Create a new group
                            </a>
                                    <input type="hidden" name="input" value="">
                                    <input type="submit" class="btn btn-info" value="Search for public groups">
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
