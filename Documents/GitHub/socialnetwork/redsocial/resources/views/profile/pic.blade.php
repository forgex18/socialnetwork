@extends('profile.master')

@section('content')
<div class="container">

<ol class="breadcrumb" style="background: transparent">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="{{url('/profile')}}/{{Auth::user()->slug}}">Perfil</a></li>
      <li><a href="{{url('/editProfile')}}">Editar perfil</a></li>
      <li><a href="">Cambiar foto</a></li>
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

                    <div class="col-md-4">
                      

                        <img src="{{url('../')}}/public/img/{{Auth::user()->pic}}" width="80px" heigth="80px" class="img-circle"/> <br/> <br>

                            
                        

                        
                        
                        

                    </div>

                    
                    <h3> Actualiza tu foto de perfil </h3>


                        <form action="{{url('/')}}/uploadPhoto" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}"/>

                            <input type="file" name="pic" class="form-control"/>
                            <br>

                            <input type="submit" class="btn btn-success" name="btn"/>
                        </form>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
