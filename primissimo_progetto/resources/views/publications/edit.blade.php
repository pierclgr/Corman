@extends('layouts.app')

@section('content')
<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(count($publications) === 1)
                        @foreach($publications as $p)
                            <form method="post" action="{{action('PublicationController@update', [$p->idPublication] )}}">
                        @endforeach
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="PUT">
                        <h2>Your profile details</h2>
                        <ul class="nav nav-tabs">
                            <li><a data-toggle="tab" href="#home">My profile</a></li>
                            <li class="active"><a data-toggle="tab" href="#menu1">My publications</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade">
                                <h3>My profile</h3>
                                <p>
                                    Please, finish uploading your publication details and then come here again. Thank you for your patience!
                                </p>
                            </div>
                            <div id="menu1" class="tab-pane fade in active">
                                <h3>My publications</h3>
                                <p>
                                    <div class="table-responsive">          
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Publication ID</th>
                                                    <th>Title</th>
                                                    <th>Publication Date</th>
                                                    <th>PDF File</th>
                                                    <th>Image</th>
                                                    <th>Multimedia</th>
                                                    <th>Type of publication</th>
                                                    <th>Paper visibility</th>
                                                    <th>Publication tags</th>
                                                    <th>List of coauthors</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    @foreach($publications as $p)
                                                        <td>{{ $p->idPublication }}</td>
                                                        <td><input class="form-control" id="titolo" name="titolo" type="text" value="{{ $p->titolo }}" /></td>
                                                        <td>{{ $p->dataPubblicazione }}</td>
                                                        <td>{{ $p->pdf }}</td>
                                                        <td>{{ $p->immagine }}</td>
                                                        <td>{{ $p->multimedia }}</td>
                                                        <td><input class="form-control" id="tipo" name="tipo" type="text" value="{{ $p->tipo }}" /></td>
                                                        <td>
                                                            <div class="button-group">
                                                                <div class="radio">
                                                                    <label><input type="radio" name="visibilita" value="1" checked="checked">Public</label>
                                                                </div>
                                                                <div class="radio">
                                                                    <label><input type="radio" name="visibilita" value="0">Private</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><input class="form-control" id="tags" name="tags" type="text" value="{{ $p->tags }}" /></td>
                                                        <td><input class="form-control" id="coautori" name="coautori" type="text" value="{{ $p->coautori }}" /></td>
                                                    @endforeach
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button class="btn btn-success " name="submit" type="submit">Update</button>
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
@endsection
