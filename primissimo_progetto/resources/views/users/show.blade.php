@extends('layouts.app')
<meta charset="UTF-8" http-equiv="X-UA-COMPATIBLE" content="IE=edge" name="viewport" contend="width=device-width, initial-scale=1">
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                @if(Auth::user()->immagineProfilo === null)
                <img class="img-responsive center-block" src="http://via.placeholder.com/250x250">
            @else
                <img class="img-responsive center-block" src="{{ URL::to('../storage/app/public/' . Auth::user()->immagineProfilo) }}">
            @endif
                <br>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @foreach($users as $u)
                            @if($u->visibilitaDN === 1)
                                <div>
                                    <div style="float: left;">
                                        <span class="material-icons" style="font-size:22px; vertical-align:middle;">cake</span>
                                    </div>
                                    <div style="margin-left: 25px;">
                                        <h7 style="vertical-align: middle;">{{ $u->dataNascita }}</h7>
                                    </div>
                                </div>
                            @endif
                            @if($u->visibilitaE === 1)
                                <div>
                                    <div style="float: left;">
                                        <span class="material-icons" style="font-size:22px; vertical-align:middle;">email</span>
                                    </div>
                                    <div style="margin-left: 25px;">
                                        <h7 style="vertical-align: middle;">{{ $u->email }}</h7>
                                    </div>
                                </div>
                            @endif
                            @if($u->visibilitaT === 1)
                                <div>
                                    <div style="float: left;">
                                        <span class="material-icons" style="font-size:22px; vertical-align:middle;">phone</span>
                                    </div>
                                    <div style="margin-left: 25px;">
                                        <h7 style="vertical-align: middle;"> {{$u->telefono}}</h7>
                                    </div>
                                </div>
                            @endif
                            @if($u->visibilitaN === 1)
                                <div>
                                    <div style="float: left;">
                                        <span class="material-icons" style="font-size:22px; vertical-align:middle;">language</span>
                                    </div>
                                    <div style="margin-left: 25px;">
                                        <h7 style="vertical-align: middle;"> {{$u->nazionalita}}</h7>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <div>
                            <div style="float: left;">
                                <span class="material-icons" style="font-size:22px; vertical-align:middle;">location_on</span>
                            </div>
                            <div style="margin-left: 25px;">
                                <h7 style="vertical-align: middle;"> {{ $u->dipartimento }}</h7>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div><h1 style="vertical-align:middle;">{{$u->name." ".$u->cognome}}</h1></div>
                <h4 style="vertical-align:middle;">{{$u->affiliazione." - ".$u->linea_ricerca}}</h4>
                @if(count($publications) >0)
                    <div>
                        <form action="{{ route('users.filter',  [$users[0]->id]) }}" method="GET" class="form-horizontal">
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
                            <div class="panel-body">
                                <div class="content">
                                    <h6 style="float: left;">{{$p->tipo}}</h6><h5 style="text-align: right;">{{$p->dataPubblicazione}}</h5>
                                    <!--<img class="img-responsive" style="float: right;" src="http://via.placeholder.com/250x250"> <!-- $->immagine -->
                                    <h2>{{$p->titolo}}</h2>
                                    @if($p->coautori!="")
                                        <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">people</span><h4 style="vertical-align:middle; margin-left: 25px;">{{$p->coautori}}</h4></div>
                                    @endif
                                    @if($p->tags!="")
                                        <div><span class="material-icons" style="font-size:15px; float: left; vertical-align:middle;">local_offer</span><h5 style="vertical-align:middle; margin-left: 25px;">{{$p->tags}}</h5></div>
                                    @endif
                                    <br>
                                    <p>{{$p->descrizione}}</p>
                                    <br>
                                    @if($p->pdf != "")
                                        <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;"><a href="../storage/app/public/{{ $p->pdf }}">PDF</a></h4></a></div>
                                        <!--
                                            <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                        -->
                                    @else
                                        <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;">No PDF avaible</h4></div>
                                        <!--
                                            <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                        -->
                                    @endif
                                    <!-- in href inserire la action per scaricare i file e in h4 inserire nome del file $p->pdf o $p->multimedia -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    @if($filter==1)
                        <div>
                            <form action="{{ route('users.filter',  [$users[0]->id]) }}" method="GET" class="form-horizontal">
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
                        <hr>
                        <center><h4><i>No results</i></h4></center>
                    @else
                        <hr>
                        <center><h4><i>User has no papers</i></h4></center>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function check(){
            var to_date, from_date;
            to_date=document.getElementById('to_date');
            from_date=document.getElementById('from_date');
            if(to_date.value!="" && from_date.value!=""){
                if(to_date.value<=from_date.value){
                    to_date.value=from_date.value+1;
                    alert('Inserire una data valida');
                }
            }
        }
    </script>
@endsection
