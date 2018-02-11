
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if($users!="" && $groups!="")
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Researchers</h3>
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @for($i = 0; $i<count($users) && $i<3; $i++)
                            <div>
                                <div>@if($users[$i]->immagineProfilo === null)
                                        <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('images/default.jpg')}}">
                                    @else
                                        <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('images/'.$users[$i]->immagineProfilo)}}">
                                    @endif</div>
                                <div style="margin-left: 85px;">
                                    <a href="/users/{{$users[$i]->id}}">
                                        <h4><b>{{$users[$i]->name." ".$users[$i]->cognome}}</b></h4>
                                    </a>
                                </div>
                                @if($users[$i]->affiliazione=="")
                                    <br>
                                @else
                                    <div style="margin-left: 85px;"><h6>{{$users[$i]->affiliazione}}</h6></div>
                                @endif
                                @if($users[$i]->linea_ricerca=="")
                                    <br>
                                @else
                                    <div style="margin-left: 85px;"><h6>{{$users[$i]->linea_ricerca}}</h6></div>
                                @endif
                            </div>
                            <hr>
                        @endfor
                        <form action="{{ action('SearchController@searchPeople') }}" method="GET">
                            <div class="buttonHolder" style="text-align: center;">
                                <input type="hidden" name="input" value="{{$input}}">
                                <input class="btn btn-link" type="submit" value="View All">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading" ><h3>Groups</h3>
                    </div>
                    <div class="panel-body" >
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @for($i = 0; $i<count($groups) && $i<3; $i++)
                                <div>
                                    <div>@if($groups[$i]->immagineGruppo === null)
                                            <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('groups_images/default.jpg')}}">
                                        @else
                                            <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('groups_images/'.$groups[$i]->immagineGruppo)}}">
                                        @endif</div>
                                    <div style="margin-left: 85px;">
                                        <a href="/groups/{{$groups[$i]->idGroup}}">
                                            <h4><b>{{$groups[$i]->nomeGruppo}}</b></h4>
                                        </a>
                                    </div>
                                    @if($groups[$i]->descrizioneGruppo=="")
                                        <br>
                                    @else
                                        <div style="margin-left: 85px;"><h6>{{$groups[$i]->descrizioneGruppo}}</h6></div>
                                    @endif
                                    <br>
                                </div>
                                <hr>
                        @endfor
                        <form action="{{ action('SearchController@searchGroups') }}" method="GET">
                            <div class="buttonHolder" style="text-align: center;">
                                <input type="hidden" name="input" value="{{$input}}">
                                <input class="btn btn-link" type="submit" value="View All">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @elseif($users!="")
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Researchers</h3>
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($users as $u)
                            <div>
                                <div>@if($u->immagineProfilo === null)
                                        <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('images/default.jpg')}}">
                                    @else
                                        <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('images/'.$u->immagineProfilo)}}">
                                    @endif</div>
                                <div style="margin-left: 85px;">
                                    <a href="/users/{{$u->id}}">
                                        <h4><b>{{$u->name." ".$u->cognome}}</b></h4>
                                    </a>
                                </div>
                                <div style="margin-left: 85px;"><h6>{{$u->affiliazione}}</h6></div>
                                <div style="margin-left: 85px;"><h6>{{$u->linea_ricerca}}</h6></div>
                            </div>
                            <hr>
                        @endforeach
                        <h6 style="text-align: center">No more results</h6>
                    </div>
                </div>
            </div>

        @elseif($groups!="")
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="align-self: center">
                    <div class="panel-heading" ><h3>Groups</h3>
                    </div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @foreach($groups as $g)
                                <div>
                                    <div>@if($g->immagineGruppo === null)
                                            <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('groups_images/default.jpg')}}">
                                        @else
                                            <img style="float: left;" class="img-responsive center-block" height="75" width="75" src="{{asset('groups_images/'.$g->immagineGruppo)}}">
                                        @endif</div>
                                    <div style="margin-left: 85px;">
                                        <a href="/groups/{{$g->idGroup}}">
                                            <h4><b>{{$g->nomeGruppo}}</b></h4>
                                        </a>
                                    </div>
                                    @if($g->descrizioneGruppo=="")
                                        <br>
                                    @else
                                        <div style="margin-left: 85px;"><h6>{{$g->descrizioneGruppo}}</h6></div>
                                    @endif
                                    <br>
                                </div>
                                <hr>
                        @endforeach
                        <h6 style="text-align: center">No more results</h6>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
