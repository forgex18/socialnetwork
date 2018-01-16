<div class="col-md-2">
          <div class="panel panel-default">
                <div class="panel-heading">
                  <a href="{{url('/findGames')}}" style="color: black; text-decoration: none; t"><i class="fa fa-search" aria-hidden="true"></i> Buscar Juegos</a>
                </div>
                <div class="panel-heading">
                    <a href="{{url('/mygames')}}" style="color: black; text-decoration: none"><i class="fa fa-gamepad" aria-hidden="true"></i> Mis Videojuegos</a>
                </div>
                <div class="panel-heading">
                    <a href="{{url('/wantGame')}}" style="color: black; text-decoration: none"><i class="fa fa-gamepad" aria-hidden="true"></i> Solicitar juego</a>
                </div>
                @if(Auth::user()->role)
                <div class="panel-heading">
                    <a href="{{url('/admin')}}" style="color: black; text-decoration: none"><i class="fa fa-plus" aria-hidden="true"></i> Añadir Juego</a>
                </div>
                <div class="panel-heading">
                    <a href="{{url('/updateGames')}}" style="color: black; text-decoration: none"><i class="fa fa-eraser" aria-hidden="true"></i> Modificar Juego</a>
                </div>
                @endif
          </div>
        </div>
