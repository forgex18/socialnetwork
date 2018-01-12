@extends('profile.master')

@section('content')


<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="">Amigos</a></li>
    </ol>

    <div class="row">

        @include('profile.sidebar')
        @include('profile.searchSidebar')

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">{{Auth::user()->name}}</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <div class="col-sm-12 col-md-12" id=myList>
                        @if (session()->has('msg'))
                                <p class="alert alert-success"> {{session()->get('msg')}} </p>
                        @endif

                        @foreach($mygames as $uList)
                        <li style="list-style:none">

                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                            <div class="col-md-2 pull-left">
                                <img src="{{url('../')}}/public/img/games/{{$uList->photo}}" width="80px" height="80px" class="img-rounded">
                            </div>

                            <div class="col-md-7 pull-left"> 
                                <h4 style="margin:0px;"><a href="{{url('/game')}}/{{$uList->id}}">{{ucwords($uList->title)}}</a></h4>
                                <p><i class="fa fa-gamepad" aria-hidden="true"></i> {{$uList->year}}  - {{$uList->comp}}</p>
                            </div>

                             <div class="col-md-3 pull-right"> 
                                
                                <p>
                                    <a href="{{url('/')}}/play/{{Auth::user()->nick}}/{{$uList->id}}" 
                                       class="btn btn-info btn-sm">Buscar partida</a>
                                </p>

                                <p>
                                    <a href="{{url('/')}}/unSub/{{$uList->id}}" 
                                       class="btn btn-danger btn-sm">Eliminar suscripción</a>
                                </p>
                                
                            </div>
                      </div>
                      </li>
                      @endforeach
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
