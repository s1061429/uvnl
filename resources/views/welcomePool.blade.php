@extends('layouts.app')

@section('content')
            @if(count($errors)>0)
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">    
    {{$error}}
    </div>
    @endforeach
    @endif
@endsection
