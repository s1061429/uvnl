@extends('todo.app')
@section('body')

<br>
<a href='/todo' class="btn btn-warning">back</a>
<div class="col-lg-4 col-lg-offset-4"><h1>Create new item</h1>

    <form class="form-horizontal" action="/todo" method="post">
  <fieldset>
    <legend>Legend</legend>
{{csrf_field()}}
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Textarea</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="textArea" name="body"></textarea>
        <span class="help-block">A longer block of help text that breaks onto a new line and may extend beyond one line.</span>
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default">Cancel</button>
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