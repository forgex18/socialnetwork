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

                    <div class="container" id="app">

                    


                    @{{msg}}    <small style="color: green">@{{content}}</small>
                    <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                        <textarea v-model="content"></textarea>
                    <button type="submit" class="btn btn-success">submit</button>

                    </form>

                    <div v-for="post in posts">

                        <div class="col-md-12">
                            <div class="col-md-2 pull-left">
                                 <img :src="'{{Config::get('app.url')}}/redsocial/public/img/' + post.pic" style="width: 100px; margin:10px" class="img-rounded">
                            </div>
                            <div class="col-md-10">
                                <h3>@{{post.name}}</h3>
                            </div>
                            
                            <p class="col-md-12">@{{post.content}}</p>

                        </div>
                    </div>
                        
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
