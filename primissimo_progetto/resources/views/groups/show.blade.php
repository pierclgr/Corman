@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @if($code==0 && $admins[0]->tipoVisibilita==0)
        <center><h1><b>Error 403 Forbidden</b></h1></center>
        <center><h3>You don't have permission to enter this page</h3></center>
        <br>
        <center><a class="btn btn-primary" href="/home">Home</a> </center>
    @else
    <div class="row">
        <div class="col-md-3">
            @if($admins[0]->immagineGruppo === null)
                <img class="img-responsive center-block" height="250" width="250" src="{{asset('groups_images/default.jpg')}}">
            @else
                <img class="img-responsive center-block" height="250" width="250" src="{{asset('groups_images/'. $admins[0]->immagineGruppo)}}">
            @endif
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="float: left">Admins</h4>
                    @if($code==2)
                    <a style="float: right">
                        <button style="float:right; padding-top: 2px; padding-bottom: 2px;" class="btn btn-primary" type="button" onclick="display()">
                            Add Admin</button>
                    </a>
                    @endif
                    <br>
                </div>
                <div class="panel-body">
                    @if(count($admins)>0)
                        @foreach($admins as $admin)
                            <h5><a href="/users/{{$admin->id}}">{{ $admin->name." ".$admin->cognome }}</a></h5>
                        @endforeach
                      @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="float: left;">Partecipants</h4>
                    @if($code==2)
                    <a style="float: right" href="{{ route('groups.cerca', [$admins[0]->idGroup]) }}">
                        <button style="float:right; padding-top: 2px; padding-bottom: 2px;" class="btn btn-primary" type="button">
                            Add Partecipant</button>
                    </a>
                    @endif
                    <br>
                </div>
                <div class="panel-body">
                    @if(count($groupUsers)>0)
                        @foreach($groupUsers as $user)
                            <h5><a href="/users/{{$user->id}}">{{ $user->name." ".$user->cognome }}</a></h5>
                        @endforeach
                    @else
                        <h5 style="text-align: center">No other partecipants</h5>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div name="al_latoDX" style="float: right;">
                @if($code==2)
                    <br>
                    <div><a style="float: right;" href="{{action('GroupController@edit', $admins[0]->idGroup)}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a></div>
                    <br><br>
                @endif
                @if($code==0)
                    <a href="{{route('groups.sendReq',[$admins[0]->idGroup])}}"><button type="button" class="btn btn-primary" onclick="notify()">Enter group</button></a>
                @elseif($code==3)
                    <button type="button" class="btn btn-primary">Request hanging</button>
                @else
                    <a href="#"><button type="button" class="btn btn-primary" onclick="quitGroup()">Quit group</button></a>
                @endif
            </div>
            <h1 style="vertical-align:middle;">{{ $admins[0]->nomeGruppo }}</h1>
            <h4 style="vertical-align:middle;">{{ $admins[0]->descrizioneGruppo }}</h4>
            <div style="margin-top: 20px; margin-bottom: 20px;">
                @if($code==1 || $code==2)
                    <center><a href="{{route('groups.rintraccia', [$admins[0]->idGroup, Auth::user()->id] )}}">
                        <button type="button" class="btn btn-primary">Share a publication in this group</button>
                    </a></center>
                @else
                    <h5 style="text-align: center;"><i>Enter the group to share a pubblication</i></h5>
                @endif
            </div>
            @if($code==1||$code==2)
                @if(count($publications)>0)
                    <div>
                        <form action="{{ route('groups.filter', [$admins[0]->idGroup]) }}" method="GET" class="form-horizontal">
                            <input name="_method" type="hidden" value="POST">
                            <h3>Filter papers</h3>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Title</td><td><input class="form-control" type="text" name="title" id="name" placeholder="Paper title"></td>
                                    <td>Tags</td><td><input class="form-control" type="text" name="tags" id="tags" placeholder="Tag1, Tag2, ..."></td>
                                    <td>From</td><td><input id="from_date" name="from_date" class="form-control" type="date" onfocusout="check()"></td>
                                    <td>To</td><td><input id="to_date" name="to_date" class="form-control" type="date"onfocusout="check()"></td>
                                    <td><button style="float:right;" class="btn btn-success " name="submit" type="submit">Filter</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    @foreach($publications as $p)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 style="float:left;"><a href="/users/{{$p->id}}">{{ $p->name." ".$p->cognome }}</a></h4><h5 style="text-align: right;">Shared on {{$p->dataoraGP}}</h5>
                                <p style="margin-top: 15px;">{{ $p->descrizione }}</p>
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

                                @if($p->id==Auth::id())
                                    <a style="float: right; margin-left: 10px;" href="{{action('PublicationController@edit', [$p->idPub] )}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a>
                                @endif
                                <h6 style="float: left;">{{$p->tipo}}</h6><h5 style="text-align: right;">{{$p->dataPubblicazione}}</h5>
                                <!--<img class="img-responsive" style="float: right;" src="http://via.placeholder.com/250x250"> <!-- $->immagine -->
                                <h2 style="margin-top:0;">{{$p->titolo}}</h2>
                                @if($p->coautori!="")
                                    <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">people</span><h4 style="vertical-align:middle; margin-left: 25px;">{{$p->coautori}}</h4></div>
                                @endif
                                @if($p->tags!="")
                                    <div><span class="material-icons" style="font-size:15px; float: left; vertical-align:middle;">local_offer</span><h5 style="vertical-align:middle; margin-left: 25px;">{{$p->tags}}</h5></div>
                                @endif
                                <br>
                                <p>{{$p->descr}}</p>
                                <br>
                                @if($p->pdf != "")
                                    <div><a href="{{asset('pdf')."/".$p->pdf}}"><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;">PDF</h4></a></div>
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
                    @if($filter==0)
                        <hr>
                        <center><h4><i>No papers here</i></h4></center>
                    @else
                        <hr>
                        <center><h4><i>No results</i></h4></center>
                    @endif
                @endif
            @else
                <hr>
                <center><h4><i>You have to be subscribed to see publications</i></h4></center>
            @endif
        </div>
    </div>
    @endif
    <div id="addAdmin" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; 
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);">
        
        <div class="modal-content" style="background-color: #F0f8ff; margin: auto; padding: 20px;
            border: 1px solid #888; width: 50%; height: auto;">
            <div class="panel">
                <div class="panel-heading"><h3>Add Admin</h3></div>
                <hr>
                <div class="panel-body">
                    @if(count($groupUsers)>0)
                        @foreach($groupUsers as $user)
                            <h5 style="float: left">{{ $user->name." ".$user->cognome }}</h5>
                            <a href="{{route('groups.promote', [$admins[0]->idGroup, $user->id])}}" style="float: right"><button class="btn btn-primary">Promote</button></a>
                            <br><hr>
                        @endforeach
                    @else
                        <h4>No one can be promoted</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="quitGroup" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; 
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);">
        
        <div class="modal-content" style="background-color: #F0f8ff; margin: auto; padding: 20px;
            border: 1px solid #888; width: 50%; height: auto">
            <div class="panel">
                <div class="panel-body">
                    @if(count($groupUsers)==0 && count($admins)==1)
                        <h3 style="text-align: center">You are the only one in the group. The group will be erased continue?</h3>
                        <center><a href="{{route('groups.quit',[$admins[0]->idGroup])}}"><button class="btn btn-primary">Yes</button></a>
                        <a href="#"><button class="btn btn-primary" onclick="hideQuit()">No</button></a></center>
                    @elseif(count($admins)==1 && $code==2)
                        <h3 style="text-align: center">You are the only admin, chose a new one before leaving</h3>
                        <center><a href="#"><button class="btn btn-primary" onclick="switchProm()">Chose</button></a></center>
                    @else
                        <h3 style="text-align: center;">Are you sure about quitting?</h3>
                        <center><a href="{{route('groups.quit',[$admins[0]->idGroup])}}"><button class="btn btn-primary">Yes</button></a>
                        <a href="#"><button class="btn btn-primary" onclick="hideQuit()">No</button></a></center>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>



<script type="text/javascript">

    function notify(){
        alert('Request sent');
    }

    function display(){
        document.getElementById('addAdmin').style.display="block";
    }

    function hidePromote(){
        document.getElementById('addAdmin').style.display="none";
    }

    function quitGroup(){
        document.getElementById('quitGroup').style.display="block";
    }

    function hideQuit(){
        document.getElementById('quitGroup').style.display="none";
    }
    
    function switchProm(){
        hideQuit();
        display();
    }

    function check(){
        var to_date, from_date;
        to_date=document.getElementById('to_date');
        from_date=document.getElementById('from_date');
        if(to_date.value!="" && from_date.value!=""){
            if(to_date.value<from_date.value){
                val=to_date.value;
                val++;
                to_date.value=val;
                alert('Inserire una data valida');
            }
        }
    }
</script>

@endsection
