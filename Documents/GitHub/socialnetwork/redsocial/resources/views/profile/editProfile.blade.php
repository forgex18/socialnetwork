@extends('profile.master')

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
                        <div class="thumbnail">
                            <h3 align="center">{{ucwords(Auth::user()->nick)}}</h3> <br>
                            <img src="{{url('../')}}/public/img/{{Auth::user()->pic}}" width="150px" heigth="150px" class="img-circle"/> <br>
                          <div class="caption">
                            @foreach ($userData as $profiledata)
                            @endforeach

                            <p align="center">{{$profiledata->city}} - {{$profiledata->country}}</p> <br>
                            <p align="center"><a href="{{url('/')}}/changePhoto" class="btn btn-primary" role="button">Cambiar imagen</a></p>
                          </div>
                        </div>
                      </div>

                    
                        

                      
                        
                        @foreach ($userData as $profiledata)
                        @endforeach

                        
                      
                       <div class="col-sm-6 col-md-8">
                            <span class="label label-default">Actualiza tu perfil</span>
                            <br>
                            <form action="{{url('/updateProfile')}}" method="post">
                              <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                            <div class="input-group">
                              <span id="basic-addon1">Ciudad</span>
                              <input type="text" class="form-control" style="width:450px" placeholder="Ciudad" name="city">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">País</span>
                              <input type="text" class="form-control" style="width:450px" placeholder="Pais" name="country">
                            </div>

                            <div class="input-group">
                              <span id="basic-addon1">Sobre mi</span>
                              <textarea type="text" class="form-control" rows="6" style="width:450px" name="about"></textarea>
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
