@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Perfil</a></li>
    </ol>

    <div class="row">

        @include('profile.sidebar')

        @foreach($data as $uData)
    
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{$uData->title}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                      
                      <div class="col-sm-6 col-md-12" align="center">
                      
                      <div class="col-md-12" align="center">
                      <h2>{{$uData->title}}  <br> </h2>
                      </div>
                      <div class="col-md-12" align="center" style="padding: 10px">
                      <img src="{{url('../')}}/public/img/games/{{$uData->photo}}" width="300px" heigth="300px">
                      </div>
                       
                        <div class="col-md-12" align="center">    
                        <p><br>{{$uData->des}}<br></p>
                        </div>


                        <object style="padding: 10px" width="425" height="350" data="http://www.youtube.com/v/{{$uData->video}}" type="application/x-shockwave-flash"><param name="src" value="http://www.youtube.com/v/{{$uData->video}}" /></object>
                            
                          <div class="caption">
                            @foreach ($data as $profiledata)
                            @endforeach
                          </div>
                        

                        <p align="right">
                            <br>
                            <a href="" 
                            class="btn btn-info btn-sm">Suscribirse</a>
                        </p>
                      </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
