@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <img class="img-responsive center-block" src="http://via.placeholder.com/250x250">
                <br>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">cake</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;">27/12/1996</h7></div></div>
                        <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">email</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;">{{ Auth::user()->email }}</h7></div></div>
                        <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">phone</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{Auth::user()->telefono}}</h7></div></div>
                        <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">language</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> {{Auth::user()->nazionalita}}</h7></div></div>
                        <div><div style="float: left;"><span class="material-icons" style="font-size:22px; vertical-align:middle;">location_on</span></div><div style="margin-left: 25px;"><h7 style="vertical-align: middle;"> Dipartimento di Informatica, Via Orabona,9 Bari IT</h7></div></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h1>{{Auth::user()->name." ".Auth::user()->cognome}}</h1>
                <h4>{{Auth::user()->affiliazione." - ".Auth::user()->linea_ricerca}}</h4>
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if(count($publications) === 1)
                            @foreach($publications as $p)
                                <form method="post" action="{{action('PublicationController@update', [$p->id] )}}">
                            @endforeach
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="PUT">
                            <div class="tab-content">
                                <div id="menu1" class="tab-pane fade in active">
                                    <h3>Publication info</h3>
                                    <p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                        @foreach($publications as $p)
                                                            <tr>
                                                                <td>Title (*)</td><td><input required class="form-control" id="titolo" name="titolo" type="text" value="{{ $p->titolo }}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Type (*)</td><td><input required class="form-control" id="tipo" name="tipo" type="text" value="{{ $p->tipo }}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Paper Year (*)</td><td><input class="form-control" id="year" name="year" type="number" value="{{$p->dataPubblicazione}}" placeholder="Paper Year" min="1900" max="{{date('Y')}}" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td>PDF File</td><td>{{ $p->pdf }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Image</td><td>{{ $p->immagine }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Multimedia</td><td>{{ $p->multimedia }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Visibility</td><td>
                                                                    @if($p->visibilita==0)
                                                                        <div class="button-group">
                                                                            <div class="radio">
                                                                                <label><input type="radio" class="p" name="visibilita" value="1">Public</label>
                                                                            </div>
                                                                            <div class="radio">
                                                                                <label><input type="radio" class="p" name="visibilita" value="0" checked="checked">Private</label>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="button-group">
                                                                            <div class="radio">
                                                                                <label><input type="radio" class="p" name="visibilita" value="1" checked="checked">Public</label>
                                                                            </div>
                                                                            <div class="radio">
                                                                                <label><input type="radio" class="p" name="visibilita" value="0">Private</label>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tags</td><td><input class="form-control" id="tags" name="tags" type="text" value="{{ $p->tags }}" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Description</td><td><textarea style="resize:none;" maxlength="191" class="form-control" id="descrizione" name="descrizione" type="text" value="{{ $p->descrizione }}"></textarea></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Coauthors</td><td><input class="form-control" id="coautori" name="coautori" type="text" value="{{ $p->coautori }}" /></td>
                                                            </tr>
                                                        @endforeach
                                                </tbody>
                                            </table>
                                            <button style="float: right;" class="btn btn-success " name="submit" type="submit">Update</button>
                                        </div>
                                        </p>
                                    </p>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
