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
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control" id="searchBar" name="input" onkeyup="helpSearch()" placeholder="Search" autocomplete="off">
                                
                                <ul class="dropdown-menu" id="searchDropdown" style="display: none; max-height: 500px; overflow: auto;">
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
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    👥 <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="max-height: 400px; min-width: 300px; overflow: auto;">
                                    <!-- Gruppi da amministratore-->
                                    <h5 style="margin-left: 10px">Administrated groups</h5>
                                    <li><a href="#">group 1</a></li>
                                    <li><a href="#">group 2</a></li>
                                    <li><a href="#">group 3</a></li>

                                    <li><hr></li>
                                    <!-- Altri gruppi -->
                                    <h5 style="margin-left: 10px">Your other groups</h5>
                                    <li><a href="#">group A</a></li>
                                    <li><a href="#">group B</a></li>
                                    <li><a href="#">group C</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    🌐 <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" style="max-height: 400px; min-width: 300px; overflow: auto;">
                                    <li><br></li>
                                    <!-- Notifica invito ad entrare nel gruppo-->
                                    <li><a href="#">Mike Wazowski invited you to join Monsters INC researching<br><button>Accept</button>    <button>Decline</button></a></li>
                                    <li><hr></li>
                                    <!-- Notifica nuova pubblicazione nel gruppo -->
                                    <li><a href="#">Mike Wazowski published someting in Monsters INC researching</a></li>
                                    <li><hr></li>
                                    <!-- Notifica nuovo commento sul tuo post -->
                                    <li><a href="#">Mike Wazowski commented your post</a></li>
                                    <li><hr></li>
                                    <!-- Notifica approvazione al gruppo -->
                                    <li><a href="#">Mike Wazowski aproved your subscription to Monsters INC researching</a></li>
                                    <li><hr></li>
                                    <!-- Notifica richiesta aggiunta nel gruppo -->
                                    <li><a href="#">James Sullivan wants to join Monsers INC researching<br><button>Accept</button>    <button>Decline</button></a></li>
                                    <li><br></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{Auth::user()->name}} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/home/user">Profile</a></li>
                                    <li><a href="/groups/create">Create Group</a></li>
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
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>

        window.onclick=function(event){

            //usato nei gruppi
            if(event.target == document.getElementById('addAdmin'))
                document.getElementById('addAdmin').style.display="none";
            if(event.target == document.getElementById('addUser'))
                document.getElementById('addUser').style.display="none";

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
    </script>
    
</body>
</html>
