@extends('profile.master')

@section('content')


<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="">Solicitudes</a></li>
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
                        @if (session()->has('msg'))
                                <p class="alert alert-success"> {{session()->get('msg')}} </p>
                        @endif

                        @foreach($FriendRequests as $uList)
                        <li style="list-style:none">

                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                            <div class="col-md-2 pull-left">
                                <img src="{{url('../')}}/public/img/{{$uList->pic}}" width="80px" height="80px" class="img-rounded"/>
                            </div>

                            <div class="col-md-7 pull-left"> 
                                <h4 style="margin:0px;"><a href="">{{ucwords($uList->name)}}</a></h4>
                                
                                <p>{{$uList->nick}}</p><br>
                                

                            </div>

                             <div class="col-md-3 pull-right"> 
                                
                                <p>
                                    <a href="{{url('/accept')}}/{{$uList->name}}/{{$uList->id}}" 
                                       class="btn btn-info btn-sm">Aceptar</a>

                                    <a href="{{url('/requestRemove')}}/{{$uList->id}}" 
                                       class="btn btn-default btn-sm">Rechazar</a>
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
