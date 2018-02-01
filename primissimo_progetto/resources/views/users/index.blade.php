@extends('layouts.app')
<meta charset="UTF-8" http-equiv="X-UA-COMPATIBLE" content="IE=edge" name="viewport" contend="width=device-width, initial-scale=1">
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <img class="img-responsive center-block" src="http://via.placeholder.com/250x250">
            <br>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">cake</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;">{{ Auth::user()->dataNascita }}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">email</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;">{{ Auth::user()->email }}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">phone</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{Auth::user()->telefono}}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">language</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{Auth::user()->nazionalita}}</h7></div></div>
                    <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">location_on</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{ Auth::user()->dipartimento }}</h7></div></div>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div><a style="float: right;" href="{{action('UserController@edit', Auth::id() )}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a><h1 style="vertical-align:middle;">{{Auth::user()->name." ".Auth::user()->cognome}}</h1></div>
            <h4 style="vertical-align:middle;">{{Auth::user()->affiliazione." - ".Auth::user()->linea_ricerca}}</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="content">
                        <form action="{{ action('PublicationController@store') }}" method="POST" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="POST">
                            <h3>New paper</h3>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Title</td><td><input class="form-control" id="titolo" name="titolo" type="text" placeholder="Title (max 255 chars) (*)" required></td>
                                </tr>
                                <tr>
                                    <td>Paper Type</td><td><input class="form-control" id="tipo" name="tipo" type="text" placeholder="Paper Type (*)" required></td>
                                </tr>
                                <tr>
                                    <td>Visibility</td><td class="button-group">
                                        <table style="width: 100%;">
                                        <tr>
                                            <td><center><label style="font-size: 15px;"><input type="radio" name="visibilita" value="1" checked="checked">Public</label></center></td>
                                            <td><center><label style="margin-left: 5px; font-size: 15px;"><input type="radio" name="visibilita" value="0">Private</label></center></td>
                                        </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Tags</td><td><input class="form-control" id="tags" name="tags" type="text" placeholder="Tags separated by a ',' (max 255 chars)"></td>
                                </tr>
                                <tr>
                                    <td>Coauthors</td><td><input class="form-control" id="coautori" name="coautori" type="text" placeholder="Coauthors separated by a ',' (max 255 chars)"></td>
                                </tr>
                                </tbody>
                            </table>
                            <h6 style="float: left;">Fields with (*) must be set.</h6>
                            <button style="float:right;" class="btn btn-success " name="submit" type="submit">Create</button>
                        </form>
                    </div>
                </div>
            </div>

            <div>
                <form action="{{ action('UserController@filter') }}" method="GET" class="form-horizontal">
                    <input name="_method" type="hidden" value="POST">
                    <h3>Filter papers</h3>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Title</td><td><input class="form-control" type="text" name="title" id="name" placeholder="Paper title"></td>
                                <td>From</td><td><input id="from_date" name="from_date" class="form-control" type="date" onchange="check()"></td>
                                <td>To</td><td><input id="to_date" name="to_date" class="form-control" type="date"onchange="check()"></td>
                                <td><button style="float:right;" class="btn btn-success " name="submit" type="submit">Filter</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            @if(count($publications) >0)
                @foreach($publications as $p)
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="content">
                                <a style="float: right; margin-left: 10px;" href="{{action('PublicationController@edit', [$p->id] )}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a>
                                <h6 style="float: left;">{{$p->tipo}}</h6><h5 style="text-align: right;">{{$p->dataPubblicazione}}</h5>
                                <img class="img-responsive" style="float: right;" src="http://via.placeholder.com/250x250"> <!-- $->immagine -->
                                <h2>{{$p->titolo}}</h2>
                                <div><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">people</span><h4 style="vertical-align:middle; margin-left: 25px;">{{$p->coautori}}</h4></div>
                                <div><span class="material-icons" style="font-size:15px; float: left; vertical-align:middle;">local_offer</span><h5 style="vertical-align:middle; margin-left: 25px;">{{$p->tags}}</h5></div>
                                <br><br><br>
                                <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">picture_as_pdf</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.pdf</h4></a></div>
                                <div><a><span class="material-icons" style="font-size:20px; float: left; vertical-align:middle;">attach_file</span><h4 style="vertical-align:middle; margin-left: 25px;">nome_file.est</h4></a></div>
                                <!-- in href inserire la action per scaricare i file e in h4 inserire nome del file $p->pdf o $p->multimedia -->
                            <!--
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>{{ $p->titolo }}</td>
                                            <td>{{ $p->dataPubblicazione }}</td>
                                            <td>{{ $p->pdf }}</td>
                                            <td>{{ $p->immagine }}</td>
                                            <td>{{ $p->multimedia }}</td>
                                            <td>{{ $p->tipo }}</td>
                                            <td>{{ $p->tags }}</td>
                                            <td>{{ $p->coautori }}</td>
                                            <td><a href="{{action('PublicationController@edit', [$p->id] )}}" class="btn btn-warning">Edit</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                                -->
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="content">
                            <strong>We're sorry, but you have never added a paper regarding your research field...</strong><br><br>
                            You can add a new one with the form above or import it from DBLP<br><br>
                            <button type="button" class="btn btn-info">Import my researchs from DBLP</button>
                        </div>
                    </div>
                </div>
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
