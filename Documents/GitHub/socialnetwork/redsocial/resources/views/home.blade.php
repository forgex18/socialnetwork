@extends('profile.master')

@section('content')
<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
    </ol>

    <div class="row">

        @include('profile.sidebar')
        @include('profile.searchSidebar')

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

                        <div class="col-md-7" style="background-color:#fff; border-bottom: #D4E6F1 5px solid; border-width: 1px" id=myList>
                        <li style="list-style:none">
                        <br>
                            <div class="col-md-2 pull-left">
                                 <img :src="'{{Config::get('app.url')}}/redsocial/public/img/' + post.pic" style="width: 65px; height: 65px; margin:10px" class="img-rounded">
                            </div>
                            <div class="col-md-10">
                                <div class="col-md-9"><h4><a :href="'{{url('profile')}}/' +  post.slug" class="user_name"> @{{post.name}}</a></h4><span style="color:#AAADB3">@{{post.mytime | myOwnTime}} <i class="fa fa-hourglass-half" aria-hidden="true"></i></span><br></div>

                                <div class="col-md-3" style="text-align: right" v-if="post.user_id == '{{Auth::user()->id}}'">
                                  <a class="deleteBtn" @click="deletePost(post.idpost)"><i class="fa fa-trash"></i></a>
                                </div>

                                <br>
                                <p align="pull-left" class="col-md-12" style="margin-left:10px" ><br>@{{post.content}}</p>
                            </div>

                            <div style=" margin-left: 15px" class="col-md-12">
                            <p class="likeBtn" @click="likePost(post.idpost)">
                                    <i class="fa fa-heart"></i>
                            </p>
                              @if(Auth::check())
                              <div v-for="like in likes">
                                <div v-if= "post.idpost==like.post_id && like.user_id=='{{Auth::user()->id}}'">
                                  <p>
                                    Te gusta
                                  </p>
                                </div>
                              </div>
                              @endif
                            </div>
                            <br>
                            </li>
                        </div>
                    </div>
                        
                    </div>

                    

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
