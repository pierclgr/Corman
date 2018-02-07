@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="/home/user" style=" color: rgb(99,107,111);">
                        <div style="float: left;">
                            <img  src="http://via.placeholder.com/28x28" height="28" width="28" >
                        </div>
                        <div style="margin-left: 40px;">
                            <p style="font-size: 18px;">{{Auth::user()->name." ".Auth::user()->cognome}}</p>
                        </div>
                    </a>
                    <hr>
                    <a href="/groups/create" style="color: rgb(99,107,111);">
                        <div style="float: left;">
                            <span style="font-size:28px;" class="material-icons">people</span>
                        </div>
                        <div style="margin-left: 40px;">
                            <p style="font-size: 18px;">Create a new group</p>
                        </div>
                    </a>
                    <a href="/home/search/groups?input=" style="color: rgb(99,107,111);">
                        <div style="float: left;">
                            <span style="font-size:28px;" class="material-icons">search</span>
                        </div>
                        <div style="margin-left: 40px;">
                            <p style="font-size: 18px;">Search for public groups</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-9">
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
            @if(count($news) >0)
                @foreach($news as $n)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                                <h4 style="float:left;"><a href="/users/{{$n->id}}">{{$n->name." ".$n->cognome}}</a> > <a href="/groups/{{$n->idGroup}}">{{$n->nomeGruppo}}</a></h4><h5 style="text-align: right;">Shared on {{$n->dataoraGP}}</h5>
                                <p style="margin-top: 15px;">{{$n->descrizione}}</p>
                        </div>
                        <div class="panel-body" style=" max-height: 400px; overflow: auto">
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

                            @if($n->id==Auth::id())
                                <a style="float: right; margin-left: 10px;" href="{{action('PublicationController@edit', [$n->id] )}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a>
                            @endif
                            <h6 style="float: left;">{{$n->tipo}}</h6><h5 style="text-align: right;">{{$n->dataPubblicazione}}</h5>
                            <!--<img class="img-responsive" style="float: right;" src="http://via.placeholder.com/250x250"> <!-- $->immagine -->
                            <h2 style="margin-top:0;">{{$n->titolo}}</h2>
                            @if($n->coautori!="")
                                <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">people</span><h4 style="vertical-align:middle; margin-left: 25px;">{{$n->coautori}}</h4></div>
                            @endif
                            @if($n->tags!="")
                                <div><span class="material-icons" style="font-size:15px; float: left; vertical-align:middle;">local_offer</span><h5 style="vertical-align:middle; margin-left: 25px;">{{$n->tags}}</h5></div>
                            @endif
                            <br>
                            <p>{{$n->descr}}</p>
                            <br>
                            @if($n->pdf != "")
                                <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;"><a href="../storage/app/public/{{ $n->pdf }}">PDF</a></h4></a></div>
                                <!--
                                    <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                -->
                            @else
                                <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;">No PDF avaible</h4></div>
                                <!--
                                    <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                -->
                            @endif
                        </div>
                    </div>
                @endforeach
                @else
                    <hr>
                    <center><h4><i>No recent activities</i></h4></center>
                @endif
        </div>
    </div>
</div>
@endsection
