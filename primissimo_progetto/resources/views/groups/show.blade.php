@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="float: left">Admins</h4>
                    <a style="float: right">
                        <button type="button" onclick="display(1)">Add Admin</button>
                    </a>
                    <br>
                </div>
                <div class="panel-body">
                    @if(count($admins)>0)
                        @foreach($admins as $admin)
                            <h5>{{ $admin->name." ".$admin->cognome }}</h5>
                        @endforeach
                      @endif
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 style="float: left;">Partecipants</h4>
                    <a style="float: right">
                        <button type="button" onclick="display(0)">Add Partecipant</button>
                    </a>
                    <br>
                </div>
                <div class="panel-body">
                    @if(count($groupUsers)>0)
                        @foreach($groupUsers as $user)
                            <h5>{{ $user->name." ".$user->cognome }}</h5>
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
                            <a href="#"><button type="button" class="btn btn-primary">Quit group</button></a>
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
                            <h5><a href="#">{{ $p->name." ".$p->cognome }}</a> ------> {{ $p->titolo }}</h5>
                            <h6>{{ $p->descrizione }}</h6>
                            <br>
                            <hr>
                        @endforeach
                        <h5 style="text-align: center">There are no other publications</h5>
                    @else
                        <strong>NESSUNA PUBBLICAZIONE PRESENTE IN QUESTO GRUPPO!</strong>
                    @endif
                    
                </div>
                <div class="panel-footer" style="background-color: white">
                    <a href="{{route('groups.rintraccia', [$admins[0]->idGroup, Auth::user()->id] )}}">
                    <button type="button" class="btn btn-primary">Add a publication in this group</button>
                    </a>
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
                            <a href="#" style="float: right"><button>Promote</button></a>
                        @endforeach
                    @else
                        <h4>No one can be promoted</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="addUser" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px; 
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4);">
        
        <div class="modal-content" style="background-color: #F0f8ff; margin: auto; padding: 20px;
            border: 1px solid #888; width: 50%; height: 80%">
            ciao
        </div>
    </div>

</div>





<script type="text/javascript">
    
    function display(choice){
        var modal;
        if(choice==1){
            modal=document.getElementById('addAdmin');
        }
        else{
            modal=document.getElementById('addUser');
        }
        modal.style.display="block";
    }

    window.onclick=function(event) {
        var modal1=document.getElementById('addAdmin');
        var modal2=document.getElementById('addUser');
        if(event.target == modal1)
            modal1.style.display="none";
        else
            modal2.style.display="none";
    }
</script>

@endsection
