@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Groups creation form</div>
                <div class="panel-body">
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
                    <div class="content">
                        <form action="{{ action('GroupController@store') }}" method="POST">
                            {{csrf_field()}}
                            <input name="_method" type="hidden" value="POST">
                            <div class="table-responsive">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Field name</th>
                                            <th>Fill in the field</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Group name (*)</td>
                                            <td>
                                                <div class="col-10">
                                                    <input class="form-control" id="nomeGruppo" name="nomeGruppo" type="text" placeholder="Enter a title (max 100 chars)" required autofocus>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Group description</td>
                                            <td>
                                                <textarea class="form-control" id="descrizioneGruppo" name="descrizioneGruppo" type="text" rows="3" placeholder="Enter a maximum of 3 rows and a maximum of 190 chars"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Select the visibility of the group (*)</td>
                                            <td>
                                                <div class="button-group">
                                                <div class="radio">
                                                    <label><input type="radio" name="tipoVisibilita" value="1" checked="checked">Public</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="tipoVisibilita" value="0">Private</label>
                                                </div>
                                            </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h5>Fields with (*) must be set.</h5>
                                <button class="btn btn-success" name="submit" type="submit">Create a new group</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
