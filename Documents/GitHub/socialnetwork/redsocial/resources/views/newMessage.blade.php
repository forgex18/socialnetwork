@extends('profile.mastermsg')

@section('content')

<div class="container" id="profile">
<div class="col-md-12 msgDiv" >

  <div style="background-color:#fff" class="col-md-3 pull-left">

    <div class="row">

       <div class="col-md-7"></div>
       
          <h3 align="center">Amigos</h3>
       
    </div>

   @foreach($friends as $friend)

   <li @click = "friendID({{$friend->id}})" v-on:click="seen = true" style="list-style:none;
    margin-top:10px; background-color:#F3F3F3" class="row">


      <div class="col-md-3 pull-left">
           <img src="{{Config::get('app.url')}}/redsocial/public/img/{{$friend->pic}}"
         style="width:50px; border-radius:100%; margin:5px">
       </div>

      <div class="col-md-9 pull-left" style="margin-top:5px">
        <b> {{$friend->name}}</b><br>
        <small>{{$friend->nick}}</small>
     </div>
   </li>
   @endforeach
   <hr>
  </div>



  <div style="background-color:#fff; min-height:174px; border-left:5px solid #F5F8FA"
   class="col-md-6">
   <h3 align="center">Mensaje</h3>
<p class="alert alert-success">@{{msg}}</p>

   <div  v-if="seen">
      
      <textarea class="col-md-12 form-control" v-model="newMsgFrom"></textarea><br>
      <input type="button" value="Enviar mensaje" @click="sendNewMsg()">
  </div>

  </div>

  <div style="background-color:#fff; min-height:174px; border-left:5px solid #F5F8FA"
  class="col-md-3 pull-right">
  <div class="row"  style="padding:20px; margin-left: 23px">
  <a href="{{url('/messages')}}" class="btn btn-sm btn-info">Todas las conversaciones</a>
  <hr>
  </div>
   
  </div>

</div>
</div>

@endsection