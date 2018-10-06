@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <a style="float: right;" href="/groups/{{$idGroup}}" class="btn btn-primary">Go Back</a>
            <h3 style="">Search researchers</h3>
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
            @if(count($users)>0)
                <div>
                    <form action="{{ route('groups.userfilter', [$idGroup]) }}" method="GET" class="form-horizontal">
                        <input name="_method" type="hidden" value="POST">
                        <h3>Filter users</h3>
                        <table class="table">
                            <tbody>
                            <tr>
                                <td>First Name</td><td><input class="form-control" type="text" name="firstName" id="firstName" placeholder="First Name"></td>
                                <td>Last Name</td><td><input class="form-control" type="text" name="lastName" id="lastName" placeholder="Last Name"></td>
                                <td><button style="float:right;" class="btn btn-success " name="submit" type="submit">Filter</button></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="{{route('groups.inviaRichiesta', [$idGroup] )}}" method="GET">
                            <input type="hidden" id="input" name="userID">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Affiliation</th>
                                        <th>Research Branch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $u)
                                        <tr>
                                            <td>
                                                <a href="/users/{{$u->id}}">{{$u->name}} {{$u->cognome}}</a>
                                            </td>
                                            <td>
                                                {{ $u->affiliazione }}
                                            </td>
                                            <td>
                                                {{ $u->linea_ricerca }}
                                            </td>
                                            <td>
                                                <input class="btn btn-primary" value="Send Request" onclick="setvalue({{ $u->id }})" type="submit">
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
                        <form action="{{ route('groups.userfilter', [$idGroup]) }}" method="GET" class="form-horizontal">
                            <input name="_method" type="hidden" value="POST">
                            <h3>Filter users</h3>
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>First Name</td><td><input class="form-control" type="text" name="firstName" id="firstName" placeholder="First Name"></td>
                                    <td>Last Name</td><td><input class="form-control" type="text" name="lastName" id="lastName" placeholder="Last Name"></td>
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
                    <center><h4><i>No addable researchers</i></h4></center>
                @endif

            @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    function setvalue(id){
        document.getElementById("input").value=id;
        alert('Request sent');
    }
</script>

@endsection
