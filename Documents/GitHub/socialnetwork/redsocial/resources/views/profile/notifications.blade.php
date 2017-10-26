@extends('profile.master')

@section('content')


<div class="container">

    <ol class="breadcrumb">
      <li><a href="{{url('/home')}}">Inicio</a></li>
      <li><a href="">Solicitudes</a></li>
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
                    
                    <div class="col-sm-12 col-md-12">
                        @if (session()->has('msg'))
                                <p class="alert alert-success"> {{session()->get('msg')}} </p>
                        @endif

                        @foreach($notes as $note)

                        <div class="row" style="border-bottom:1px solid #ccc; margin-bottom:15px">
                            <ul>
                                <li>
                                    <p><a href="{{url('/profile')}}/{{$note->slug}}" style="font-weight: bold;">{{$note->name}}</a> {{$note->note}}</p>
                                </li>
                            </ul>
                      </div>
                      @endforeach
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
