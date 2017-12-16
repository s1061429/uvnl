@extends('layouts.app')

@section('body')
<a href='/route/create' class="btn btn-info">Toevoegen</a>

<div class="col-lg-4 col-lg-offset-4">
    <center><h1>Routes</h1></center>
    <ul class="list-group">

        @foreach($routes as $route)
        <li class="list-group-item">    
            {{$route->route}}
            <span class="pull-right">{{$route->created_at->diffforHumans()}}</span>
        </li>
        @endforeach

    </ul>
</div>


@endsection