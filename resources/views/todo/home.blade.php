@extends('todo.app')

@section('body')
<br>
<a href='/todo/create' class="btn btn-info">add new</a>
<div class="col-lg-4 col-lg-offset-4">
    <center><h1>todo list</h1></center>
    <ul class="list-group">

        @foreach($todos as $todo)
        <li class="list-group-item">    
            {{$todo->body}}
            <span class="pull-right">{{$todo->created_at->diffforHumans()}}</span>
        </li>
        @endforeach

    </ul>
</div>


@endsection