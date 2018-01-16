@extends('profile.master')

@section('content')


<div class="container">

    <ol class="breadcrumb" style="background: transparent">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="">Buscar amigos</a></li>
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
                        @foreach($allUsers as $uList)

                        <li style="list-style:none">
                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                            <div class="col-md-2 pull-left">
                                <img src="{{url('../')}}/public/img/{{$uList->pic}}" width="80px" height="80px" class="img-rounded"/>
                            </div>

                            <div class="col-md-7 pull-left"> 
                                <h4 style="margin:0px;"><a href="{{url('/profile')}}/{{$uList->slug}}">{{ucwords($uList->name)}}</a></h4>
                                <p><i class="fa fa-globe" aria-hidden="true"></i> {{$uList->city}}  - {{$uList->country}}</p>
                                <p>{{$uList->nick}}</p>

                            </div>

                             <div class="col-md-3 pull-right"> 
                                
                                <?php 
                                $check = DB::table('friendships')
                                        ->where('user_requested', '=', $uList->id)
                                        ->where('requester', '=', Auth::user()->id)
                                        ->first();
                                
                                if($check ==''){
                                ?>
                                   <p>
                                        <a href="{{url('/')}}/addFriend/{{$uList->id}}" 
                                           class="btn btn-info btn-sm">Añadir amigo</a>
                                    </p>
                                <?php } else {?>
                                    <p>Solicitud enviada</p>
                                <?php }?>
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
