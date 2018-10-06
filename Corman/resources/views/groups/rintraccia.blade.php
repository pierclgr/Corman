@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <a style="float: right;" href="/groups/{{$idGroup}}" class="btn btn-primary">Go Back</a>
            <h3 style="">Search publications</h3>
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
                @if(count($suePubblicazioni)>0)
                    <div>
                        <form action="{{ route('groups.publicationfilter', [$idGroup, Auth::id()]) }}" method="GET" class="form-horizontal">
                            <input name="_method" type="hidden" value="POST">
                            <h3>Filter papers</h3>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Title</td><td><input class="form-control" type="text" name="title" id="name" placeholder="Paper title"></td>
                                    <td>Tags</td><td><input class="form-control" type="text" name="tags" id="tags" placeholder="Tag1, Tag2, ..."></td>
                                    <td><button style="float:right;" class="btn btn-success " name="submit" type="submit">Filter</button></td>
                                </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{route('groups.aggiungi', [$idGroup] )}}" method="GET">
                                <input type="hidden" id="input" name="pubID">
                                <table class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Publication title</th>
                                            <th>Type of publication</th>
                                            <th>Publication tags</th>
                                            <th>Coauthors</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($suePubblicazioni as $sp)
                                            <tr>
                                                <td>
                                                    {{ $sp->titolo }}
                                                </td>
                                                <td>
                                                    {{ $sp->tipo }}
                                                </td>
                                                <td>
                                                    {{ $sp->tags }}
                                                </td>
                                                <td>
                                                    {{ $sp->coautori }}
                                                </td>
                                                <td>
                                                    <textarea style="resize: none;" maxlength="191" name="{{ 'descr'.$sp->id }}" placeholder=" "></textarea>
                                                </td>
                                                <td>
                                                    <input class="btn btn-primary" value="Share" onclick="setvalue({{ $sp->id }})" type="submit">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                @else
                    @if($filter==1)
                        <div>
                            <form action="{{ route('groups.publicationfilter', [$idGroup, Auth::id()]) }}" method="GET" class="form-horizontal">
                                <input name="_method" type="hidden" value="POST">
                                <h3>Filter papers</h3>
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Title</td><td><input class="form-control" type="text" name="title" id="name" placeholder="Paper title"></td>
                                        <td>Tags</td><td><input class="form-control" type="text" name="tags" id="tags" placeholder="Tag1, Tag2, ..."></td>
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
                        <center><h4><i>No shareable publications</i></h4></center>
                    @endif
                @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    function setvalue(id){
        document.getElementById("input").value=id;
    }
</script>
@endsection
