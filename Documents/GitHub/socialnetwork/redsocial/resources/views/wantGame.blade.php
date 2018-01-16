@extends('profile.master')

@section('content')


<div class="container">

    <ol class="breadcrumb" style="background: transparent">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="">Solicitar juego</a></li>
    </ol>

    <div class="row">

        @include('profile.sidebar')

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->name}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-sm-6 col-md-4">
                       <div class="col-sm-6 col-md-8" style="align-items: center;">
                            <span class="label label-default">Solicitar juego</span>
                            <br>
                            <br>
                            <form action="{{url('/wantGames')}}" method="post">
                              <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                            <div class="input-group">
                              <span id="basic-addon1">Título</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Titulo" name="tit">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Compañía</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Compañia" name="company">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Año de lanzamiento</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Año de lanzamiento" name="years">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Plataforma</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Plataforma" name="console">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Comentarios</span>
                              <textarea type="text" class="form-control" rows="6" style="width:650px" name="coment"></textarea>
                            </div>
                            <br>
                            <div class="input-group">
                              <input type="submit" class="btn btn-success pull-right">
                            </div>

                        </div>
                      </form>

                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
