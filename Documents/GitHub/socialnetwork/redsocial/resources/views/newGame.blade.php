@extends('profile.masteradmin')

@section('content')


<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Perfil</a></li>
      <li><a href="">Editar perfil</a></li>
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
                            <span class="label label-default">Introducir nuevo juego</span>
                            <br>
                            <br>
                            <form action="{{url('/admin/newGames')}}" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                            <div class="input-group">
                              <span id="basic-addon1">Título</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Titulo" name="title">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Compañía</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Compañia" name="comp">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Año de lanzamiento</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Año de lanzamiento" name="year">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Video</span>
                              <input type="text" class="form-control" style="width:650px" placeholder="Video" name="video">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Descripción</span>
                              <textarea type="text" class="form-control" rows="6" style="width:650px" name="des"></textarea>
                            </div>


                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                            <input type="file" name="photo" class="form-control" style="width:650px"/>
                            
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
