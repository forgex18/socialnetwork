@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
    </ol>

    <div class="row">

        <div class="col-md-2">
          <div class="panel panel-default">
                <div class="panel-heading">Mis Videojuegos</div>
                <div class="panel-heading">Buscar Videojuegos</div>
          </div>
        </div>

        <div class="col-md-2 pull-right">
          <div class="panel panel-default">
                <div class="panel-heading">Chat</div>
          </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">Realizar publicación</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-md-12 center-con">
                      <div class="posts_div">
                         <div class="head_har">
                             
                          </div>
                          <div style="background-color: #fff">
                            <div class="row">
                              <div class="col-md-1 pull-left">
                                <img src="{{url('../')}}/public/img/{{Auth::user()->pic}}"
                                 style="width:40px; margin:10px" class="img-rounded">
                              </div>
                              <div class="col-md-11 pull-right">
                                <form method="post" enctype="multipart/form-data" v-on:submit.prevent="addPost">
                                <textarea v-model="content" id="postText" class="form-control"
                                placeholder="¿Qué estás pensando?"></textarea>
                                <button type="submit" class="btn btn-sm btn-info pull-right" style="margin:10px"
                                 id="postBtn">Postear</button>
                                </form>
                                </br>
                              </div>
                            </div>
                          </div>
                      </div>
                      </div>

                </div>
            </div>
        </div>

        <div class="col-md-8" style="margin-left: 195px">
            <div class="panel panel-default">
                <div class="panel-heading">Publicaciones</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container" id="app">

                    <div v-for="post,key in posts">

                        <div class="col-md-7" style="background-color:#fff; border-bottom: #D4E6F1 5px solid; border-width: 1px">
                        <br>
                            <div class="col-md-2 pull-left">
                                 <img :src="'{{Config::get('app.url')}}/redsocial/public/img/' + post.pic" style="width: 75px; height: 75px; margin:10px" class="img-rounded">
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-9"><h4><a :href="'{{url('profile')}}/' +  post.slug" class="user_name"> @{{post.name}}</a></h4></div>

                                <div class="col-md-3" style="text-align: right" v-if="post.user_id == '{{Auth::user()->id}}'">
                                  <a @click="deletePost(post.content)"><i class="fa fa-trash"></i></a>

                                <div class="dropdown-menu">
                                
                                </div>
                                </div>

                                <p align="pull-left" class="col-md-12" style="margin-left:10px" >@{{post.content}}</p>
                                
                            </div>
                            
                            <br>

                        </div>
                    </div>
                        
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
