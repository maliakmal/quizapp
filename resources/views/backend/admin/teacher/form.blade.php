<div class="row">
  <div class="form-group">
    <label class="control-label col-sm-2" >School:</label>
    <div class="col-sm-10">
      {!! Form::select('school_id', $schools, null, array('placeholder' => 'Select School','class' => 'form-control','required'=>'true')) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >First Name:</label>
    <div class="col-sm-10">
      {!! Form::text('first_name', null, array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Last Name:</label>
    <div class="col-sm-10">
      {!! Form::text('last_name', null, array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" >Email:</label>
    <div class="col-sm-10">
      {!! Form::text('email', null, array('required' => 'true','class' => 'form-control')) !!}
    </div>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</div>
