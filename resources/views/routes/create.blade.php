@extends('layouts.app')
@section('body')

<br>
<a href='/route' class="btn btn-warning">Terug</a>
<div class="col-lg-4 col-lg-offset-4"><h1>Maak een nieuwe link aan</h1>

    <form class="form-horizontal" action="/route" method="post">
        {{csrf_field()}}
  <fieldset>

      <center><div class="form-group">
      <label class="col-lg-2 control-label">Naam</label>
      <div class="col-lg-10 "><input type="text" class="form-control"  placeholder="Link" name="route"></div>
    </div>
          </center>
      
          <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>

  </fieldset>
</form>
    @if(count($errors)>0)
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">    
    {{$error}}
    </div>
    @endforeach
    @endif
    
    </div>
@endsection