@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div name="al_latoSX" style="text-align: left;">
                        <h2>{{ $admins[0]->nomeGruppo }}</h2><br>{{ $admins[0]->descrizioneGruppo }}
                    </div>
                    <div name="al_latoDX" style="text-align: right;">
                        @if($code==0)
                            <a href="{{route('groups.sendReq',[$admins[0]->idGroup])}}"><button type="button" class="btn btn-primary" onclick="notify()">Enter group</button></a>
                        @elseif($code==3)
                            <button type="button" class="btn btn-primary">Request hanging</button>
                        @else
                            <a href="#"><button type="button" class="btn btn-primary" onclick="quitGroup()">Quit group</button></a>
                        @endif    
                    </div>
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
                    @if(count($publications)>0)
                        @foreach($publications as $p)
                            <h5><a href="/users/{{$p->id}}">{{ $p->name." ".$p->cognome }}</a> ------> {{ $p->titolo }}</h5>
                            <h6>{{ $p->descrizione }}</h6>
                            <br>
                            <hr>
                        @endforeach
                        <h5 style="text-align: center">There are no other publications</h5>
                    @else
                        <strong>THERE ARE NO PUBBLICATIONS HERE!</strong>
                    @endif
                    
                </div>
                <div class="panel-footer" style="background-color: white">
                    @if($code==1 || $code==2)
                        <a href="{{route('groups.rintraccia', [$admins[0]->idGroup, Auth::user()->id] )}}">
                            <button type="button" class="btn btn-primary">Add a publication in this group</button>
                        </a>
                    @else
                        <h5>Enter the group to share a pubblication</h5>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="addAdmin" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; 
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);">
        
        <div class="modal-content" style="background-color: #F0f8ff; margin: auto; padding: 20px;
            border: 1px solid #888; width: 50%; height: 80%">
            <div class="panel">
                <div class="panel-heading"><h3>Add Admin</h3></div>
                <hr>
                <div class="panel-body">
                    @if(count($groupUsers)>0)
                        @foreach($groupUsers as $user)
                            <h5 style="float: left">{{ $user->name." ".$user->cognome }}</h5>
                            <a href="{{route('groups.promote', [$admins[0]->idGroup, $user->id])}}" style="float: right"><button>Promote</button></a>
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

</script>

@endsection
