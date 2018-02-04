@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Your pubblications</h3>
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
                    @if(count($suePubblicazioni)>0)
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
                                                <input name="{{ 'descr'.$sp->id }}" placeholder=" ">
                                            </td>
                                            <td>
                                                <input class="btn btn-primary" placeholder="Add" onclick="setvalue({{ $sp->id }})" type="submit">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    @else
                        <strong>You have no publications</strong>
                    @endif 
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function setvalue(id){
        document.getElementById("input").value=id;
    }
</script>
@endsection
