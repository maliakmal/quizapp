<div class="row">
  <div class="form-group">
    <label class="control-label col-sm-2" >Title:</label>
    <div class="col-sm-10">
      {!! Form::text('title', Input::old('title'), array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Description:</label>
    <div class="col-sm-10">
      {!! Form::textarea('description', Input::old('description'), array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Duration(minutes):</label>
    <div class="col-sm-10">
      {!! Form::number('duration', Input::old('duration'), array('required' => 'true','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Type:</label>
    <div class="col-sm-10">
      {!! Form::select('type', ['junior'=>'junior', 'senior'=>'senior'], Input::old('type'), array('required' => 'true','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Quiz Accessible From:</label>
    <div class="col-sm-10">
      {!! Form::text('accessible_from', Input::old('accessible_from'), array('placeholder' => '', 'id'=>'accessible_from', 'class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" >Quiz Accessible To:</label>
    <div class="col-sm-10">
      {!! Form::text('accessible_to', Input::old('accessible_to'), array('placeholder' => '', 'id'=>'accessible_to', 'class' => 'form-control')) !!}
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
