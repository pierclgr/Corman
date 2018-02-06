@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Search researchers</h3>
                </div>
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
                    @if(count($users)>0)
                        <form action="{{route('groups.inviaRichiesta', [$idGroup] )}}" method="GET">
                            <input type="hidden" id="input" name="userID">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Surname</th>
                                        <th>Affiliation</th>
                                        <th>Research Branch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $u)
                                        <tr>
                                            <td>
                                                {{ $u->name }}
                                            </td>
                                            <td>
                                                {{ $u->cognome }}                                                
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
                    @else
                        <strong><h3>There are no researcher to be added</h3></strong>
                    @endif 
                </div>
            </div>
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
