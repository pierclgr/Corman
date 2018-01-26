@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Attività recenti</div>
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
                    <div class="tab-content">
                        @if(count($publications) >0)
                            <div class="table-responsive">          
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Publication ID</th>
                                            <th>Title</th>
                                            <th>Publication date</th>
                                            <th>PDF file</th>
                                            <th>Image</th>
                                            <th>Multimedia</th>
                                            <th>Type of publication</th>
                                            <th>Publication Tags</th>
                                            <th>List of coauthors</th>
                                            <th>Edit your paper</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($publications as $p)
                                            <tr>
                                                <td>{{ $p->idPublication }}</td>
                                                <td>{{ $p->titolo }}</td>
                                                <td>{{ $p->dataPubblicazione }}</td>
                                                <td>{{ $p->pdf }}</td>
                                                <td>{{ $p->immagine }}</td>
                                                <td>{{ $p->multimedia }}</td>
                                                <td>{{ $p->tipo }}</td>
                                                <td>{{ $p->tags }}</td>
                                                <td>{{ $p->coautori }}</td>
                                                <td><a href="{{action('PublicationController@edit', [$p->idPublication] )}}" class="btn btn-warning">Edit</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <strong>We're sorry, but you have never added a paper regarding your research field that you wrote...</strong><br><br>
                            But, if you want, you can add a new one bor importing it from DBLP by simply pressing one of the buttons below!<br><br>
                            <a href="{{action('PublicationController@create')}}" class="btn btn-info">Create a new paper</a>
                            <button type="button" class="btn btn-info">Import my researchs from DBLP</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
