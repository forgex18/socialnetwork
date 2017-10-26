<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://use.fontawesome.com/595a5020bd.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>O-Play</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                       <b> O-Play</b>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        @if (Auth::check())
                            <li><a href="{{url('/findFriends')}}"><i class="fa fa-user-plus" aria-hidden="true"></i> Buscar amigos</a></li>
                            <li><a href="{{url('/requests')}}"><i class="fa fa-handshake-o" aria-hidden="true"></i> Solicitudes ({{App\friendships::where('status', null)->where('user_requested', Auth::user()->id)->count()}})</a></li>
                            
                            &nbsp;
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Iniciar sesión</a></li>
                            <li><a href="{{ route('register') }}">Registrarse</a></li>
                        @else

                        

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                     <img src="{{url('../')}}/public/img/{{Auth::user()->pic}}" width="25px" heigth="25px" class="img-circle"/><span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">

                                <li><a href="{{url('/profile')}}/{{ Auth::user()->slug}}">Perfil</a></li>

                                    <li>
                                        <a href="{{ url('editProfile') }}">Editar perfil</a>
                                    </li>


                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Cerra sesión
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>

                            <li>
                                <a href="{{url('/friends')}}"><i class="fa fa-users" aria-hidden="true"></i></a>
                            </li>

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-bell-o fa-1x" aria-hidden="true"></i>
                                    <span class="badge"
                                    style="background: red; position: relative; top: -12px; left: -9px;">
                                        {{App\notifications::where('status', 1)
                                        ->where('user_hero', Auth::user()->id)
                                        ->count()}}
                                    </span>
                                </a>

                                <?php
                                $notes = DB::table('users')
                                        ->leftJoin('notifications', 'users.id', 'notifications.user_logged')
                                        ->where('user_hero', Auth::user()->id)
                                       // ->where('status', 1)
                                        ->orderBy('notifications.created_at', 'desc')
                                        ->get();
                                ?>

                                <ul class="dropdown-menu" role="menu">
                                    @foreach($notes as $note)
                                    @if($note->status==1)
                                    <li style="background: #E4E9F2; padding: 10px">
                                    @else
                                    <li style="padding: 10px">
                                    @endif
                                        <div style="width: 400px">
                                        
                                        <a href="{{url('/notifications')}}/{{$note->id}}">
                                        <div class="col-md-2">
                                            <img src="{{url('../')}}/public/img/{{$note->pic}}" style="height: 40px; width: 40px" class="img-circle">
                                        </div>
                                        <div class="col-md.10">
                                            <b></style> {{ucwords($note->name)}}</b>
                                            {{$note->note}}<br>
                                            
                                        </a>
                                        <small>
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                            {{date('F j, Y', strtotime($note->created_at))}} 
                                            at {{date('H: i', strtotime($note->created_at))}}
                                        </small>
                                        </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>

                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
