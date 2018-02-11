<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CORMAN - My Area</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Branding -->
                    <a class="navbar-brand navbar-left" href="{{ url('/home') }}">
                        CORMAN
                    </a>
                    <!-- Searchbar -->
                    @guest
                        <!-- Niente -->
                    @else
                       <form class="navbar-form navbar-left" action="/home/search/" method="get">
                            <div style="margin-left: 60px; width: 150%;" class="form-group has-feedback">
                                <input type="text" style="width: 100%;" class="form-control" id="searchBar" name="input" onkeyup="helpSearch()" placeholder="Search" autocomplete="off">
                                
                                <ul class="dropdown-menu" id="searchDropdown" style="display: none; max-height: 500px; width: 100%; overflow: auto;">
                                    <!-- viene riempito da script -->
                                </ul>
                                <span class="glyphicon glyphicon-search form-control-feedback">
                                </span>
                            </div>
                        </form>
                    @endguest
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" onclick="getGroups()">
                                    <div style="float: left; height: auto;">
                                        <span class="material-icons" style="margin-top: -1px; margin-right: 2px; font-size: 25px;">people</span>
                                    </div><span style="margin-top: 10px; margin-bottom: 10px;" class="caret"></span>
                                </a>
                                <ul id="groups" class="dropdown-menu" style="max-height: 400px; min-width: 300px; overflow: auto;">
                                    <!-- riempito da script -->
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" onclick="getNews()">
                                    <div style="float: left; height: auto;">
                                        <span class="material-icons" style="margin-right: 2px; font-size:22px;">public</span>
                                    </div><span style="margin-top: 10px; margin-bottom: 10px;" class="caret"></span>
                                </a>
                                <ul id="news" class="dropdown-menu" style="max-height: 400px; min-width: 300px; overflow: auto;">
                                    <!-- riempito da script -->
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                        @if(Auth::user()->immagineProfilo==null)
                                            <img style="float:left; border-radius: 50%; margin-right: 6px;" src="{{asset('images/default.jpg')}}" width="21" height="21">
                                        @else
                                            <img style="float:left; border-radius: 50%; margin-right: 6px;" src="{{asset('images/'.Auth::user()->immagineProfilo)}}" width="21" height="21">
                                        @endif
                                        <h style="margin-right: 4px;">{{Auth::user()->name}}</h><span style="margin-top: 10px; margin-bottom: 10px;" class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/home/user">Profile</a></li>
                                    <li><a href="#" onclick="showNewPub()">Add new paper</a></li>
                                    <hr>
                                    <li><a href="/groups/create">Create a new group</a></li>
                                    <li>
                                        <a href="/home/search/groups?input=">Search for public groups</a>
                                    </li>
                                    <lI></lI><hr>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Disconnect
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                    </ul>
                </div>
                <div id="addPaper" class="modal" style="display: none; position: fixed; z-index: 1; padding-top: 100px;
        left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);">
                    <div class="modal-content" style="background-color: #F0f8ff; margin: auto;
            border: 1px solid #888; width: 70%; height: auto">
                        <div class="panel">
                            <div class="panel-body">
                                <form action="{{ action('PublicationController@store') }}" method="POST" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <input name="_method" type="hidden" value="POST">
                                    <h3>New paper</h3>
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td style="width: 50%;">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Title (*)</td><td><input class="form-control" id="titolo" name="titolo" type="text" placeholder="Title (max 255 chars)" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Type (*)</td><td><input class="form-control" id="tipo" name="tipo" type="text" placeholder="Paper Type" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Year (*)</td><td><input class="form-control" id="year" name="year" type="number" placeholder="Paper Year" min="1900" max="{{date('Y')}}" required></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PDF</td>
                                                        <td><input type="file" name="pdf" id="pdf"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td style="width: 50%;">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td>Visibility</td>
                                                        <td class="button-group">
                                                            <table style="width: 100%;">
                                                                <tr>
                                                                    <td>
                                                                        <center>
                                                                            <label style="font-size: 15px;"><input type="radio" name="visibilita" value="1" checked="checked">Public</label>
                                                                        </center>
                                                                    </td>
                                                                    <td>
                                                                        <center>
                                                                            <label style="margin-left: 5px; font-size: 15px;"><input type="radio" name="visibilita" value="0">Private</label>
                                                                        </center>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tags</td><td><input class="form-control" id="tags" name="tags" type="text" placeholder="Tags separated by a ',' (max 255 chars)"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Description</td><td><textarea style="resize:none;" maxlength="191" class="form-control" id="descrizione" name="descrizione" type="text" placeholder="Description (max 255 chars)"></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Coauthors</td><td><input class="form-control" id="coautori" name="coautori" type="text" placeholder="Coauthors separated by a ',' (max 255 chars)"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <h6 style="float: left;">Fields with (*) must be set.</h6>
                                    <button style="float:right;" class="btn btn-success " name="submit" type="submit">Create</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>

        window.onclick=function(event){
            if(event.target==document.getElementById('addPaper'))
                document.getElementById('addPaper').style.display="none";
            //usato nei gruppi
            if(event.target == document.getElementById('addAdmin'))
                document.getElementById('addAdmin').style.display="none";
            if(event.target == document.getElementById('quitGroup'))
                document.getElementById('quitGroup').style.display="none";

            if(event.target==document.getElementById("searchDropdown") ||
                event.target==document.getElementById("searchBar"))
                document.getElementById("searchDropdown").style.display="block";
            else
                hideDropdown();
        }

        function hideDropdown(){
            document.getElementById("searchDropdown").style.display="none";
        }

        function helpSearch(){
            document.getElementById("searchDropdown").style.display="block";

            var input;
            input = document.getElementById("searchBar").value;
            if(input == "")
                hideDropdown();
            else{
                var string='input='+input;
                $.ajax({
                    type: "GET",
                    url: "/helpsearch",
                    data: string,
                    cache: false,
                    success: function(html){
                        $("#searchDropdown").html(html);
                    }
                });
            }
        }
        function getGroups(){
            $.ajax({
                type: "GET",
                url: "/getgroups",
                cache: false,
                success: function(html){
                    $("#groups").html(html);
                }
            });
        }

        function getNews(){
            $.ajax({
                type: "GET",
                url: "/getnews",
                cache: false,
                success: function(html){
                    $("#news").html(html);
                }
            });
        }

        window.onload=function(){
            if($.ajax({
                type: "GET",
                url: "/hasnews",
                cache: false
            })){
                //document.getElementById("nofitications").style.display="none";
            }

            $.ajax({
                type: "GET",
                url: "/getnews",
                cache: false,
                success: function(html){
                    $("#news").html(html);
                }
            });

            $.ajax({
                type: "GET",
                url: "/getgroups",
                cache: false,
                success: function(html){
                    $("#groups").html(html);
                }
            });
        }

        function showNewPub(){
            document.getElementById('addPaper').style.display="block";
        }
    </script>
    
</body>
</html>
