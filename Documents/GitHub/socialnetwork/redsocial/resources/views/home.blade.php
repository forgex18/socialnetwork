@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
    </ol>

    <div class="row">

        <div class="col-md-2">
          <div class="panel panel-default">
                <div class="panel-heading">Sidebar</div>
          </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($posts as $post)

                    <div class="container">
                        <div class="col-md-12">
                            <div class="col-md-2 pull-left">
                                <img src="{{url('../')}}/public/img/{{$post->pic}}" style="width: 100px; margin:10px" class="img-rounded">
                            </div>
                            <div class="col-md-10">
                                <h3>{{ucwords($post->name)}}</h3>
                            </div>
                            
                            <p class="col-md-12">{{$post->content}}</p>

                        </div>
                        
                        
                    </div>

                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
