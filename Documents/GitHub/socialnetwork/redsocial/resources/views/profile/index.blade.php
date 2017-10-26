@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Perfil</a></li>
    </ol>

    <div class="row">

        @include('profile.sidebar')

        @foreach($userData as $uData)
    
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{$uData->name}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                      <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                            <h3 align="center">{{ucwords($uData->nick)}}</h3>
                            <img src="{{url('../')}}/public/img/{{$uData->pic}}" width="120px" heigth="120px" class="img-circle"/>
                          <div class="caption">
                            @foreach ($data as $profiledata)
                            @endforeach

                            <p align="center">{{$uData->city}} - {{$uData->country}}</p>

                            @if($uData->user_id == Auth::user()->id)

                            <p align="center"><a href="{{url('/editProfile')}}" class="btn btn-primary" role="button">Editar perfil</a></p>

                            @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 col-md-8">
                        <h4  align="center" class=""><span class="label label-primary">Sobre mi</span></h4>
                        <p>{{$uData->about}}</p>
                      </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
