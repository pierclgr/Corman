@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        @if($code!=2)
            <center><h1><b>Error 403 Forbidden</b></h1></center>
            <center><h3>You don't have permission to enter this page</h3></center>
            <br>
            <center><a class="btn btn-primary" href="/home">Home</a> </center>
        @else
        <div class="row">
            <div class="col-md-3">
                @if($groups[0]->immagineGruppo === null)
                    <img class="img-responsive center-block" height="250" width="250" src="{{asset('groups_images/default.jpg')}}">
                @else
                    <img class="img-responsive center-block" height="250" width="250" src="{{asset('groups_images/'. $groups[0]->immagineGruppo)}}">
                @endif
                <br>
            </div>

            <div class="col-md-9">
                <div name="al_latoDX" style="float: right;">
                <br>
                <div><a style="float: right;" href="{{action('GroupController@edit', $groups[0]->idGroup)}}"><span class="material-icons" style="font-size:20px; vertical-align:middle;">create</span></a></div>
                <br><br>
                </div>
                <h1 style="vertical-align:middle;">{{ $groups[0]->nomeGruppo }}</h1>
                <h4 style="vertical-align:middle;">{{ $groups[0]->descrizioneGruppo }}</h4>
                <br>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="post" action="{{action('GroupController@update', $groups[0]->idGroup )}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="POST">
                            <h3>Group details</h3>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                            @foreach($groups as $g)
                                                <tr>
                                                    <td>Name</td>
                                                    <td>
                                                        <input class="form-control" id="nomeGruppo" name="nomeGruppo" type="text" value="{{ $g->nomeGruppo }}" disabled/>
                                                        @if ($errors->any())
                                                            <strong style="color: red;">{{ $errors->first() }}</strong>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>
                                                        <textarea style="resize: none;" maxlength="191" class="form-control" id="descrizioneGruppo" name="descrizioneGruppo" rows="3">{{ $g->descrizioneGruppo }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Visibility</td>
                                                    <td class="button-group">
                                                            @if($g->tipoVisibilita==1)
                                                                    <div>
                                                                        <label><input id="tipoVisibilita" type="radio" name="tipoVisibilita" value="1" checked>Public</label>
                                                                    </div>
                                                                    <div>
                                                                        <label><input id="tipoVisibilita" type="radio" name="tipoVisibilita" value="0">Private</label>
                                                                    </div>
                                                            @else
                                                                    <div>
                                                                        <label><input id="tipoVisibilita" type="radio" name="tipoVisibilita" value="1">Public</label>
                                                                    </div>
                                                                    <div>
                                                                        <label><input id="tipoVisibilita" type="radio" name="tipoVisibilita" value="0" checked>Private</label>
                                                                    </div>
                                                            @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Group Image</td>
                                                    <td>
                                                        <input type="file" class="form-control-file space" name="immagineGruppo">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <button style="float:right;" class="btn btn-success" name="submit" type="submit">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @endif
    </div>

@endsection