@extends('profile.master')

@section('content')


<div class="container">

    <ol class="breadcrumb" style="background: transparent">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="">Actualizar juego</a></li>
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
                    
                    <div class="col-sm-12 col-md-12" id="myList">
                        @foreach($allGames as $uList)

                        <li style="list-style:none">

                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom: 0px; padding: 15px">
                            <div class="col-md-2 pull-left">
                                <img src="{{url('../')}}/public/img/games/{{$uList->photo}}" width="80px" height="80px" class="img-rounded">
                            </div>

                            <div class="col-md-7 pull-left"> 
                                <h4 style="margin:0px;"><a href="{{url('/game')}}/{{$uList->id}}">{{ucwords($uList->title)}}</a></h4>
                                <p><i class="fa fa-gamepad" aria-hidden="true"></i> {{$uList->year}}  - {{$uList->comp}}</p>
                            </div>



                            <div class="col-md-3 pull-right"> 
                            
                                   <p>
                                        <a href="{{url('/')}}/picGame/{{$uList->id}}" 
                                           class="btn btn-info btn-sm">Añadir portada</a>
                                    </p>

                                    <p>
                                         <a href="{{url('/delGame')}}/{{$uList->id}}" 
                                       class="btn btn-danger btn-sm">Eliminar juego</a>
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
