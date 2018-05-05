  <div class="form-group">
    <label class="control-label col-sm-2" >First Name:</label>
    <div class="col-sm-10">
      {!! Form::text('first_name', null, array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" >Last Name:</label>
    <div class="col-sm-10">
      {!! Form::text('last_name', null, array('placeholder' => '','class' => 'form-control')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" >Age:</label>
    <div class="col-sm-10">
      {!! Form::select('age', $ages, null, array('class' => 'form-control','required'=>'true')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" >Gender:</label>
    <div class="col-sm-10">
      {!! Form::select('gender', $genders, null, array('class' => 'form-control','required'=>'true')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" >Grade:</label>
    <div class="col-sm-10">
      {!! Form::select('grade', $grades, null, array('class' => 'form-control','required'=>'true')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" >Type:</label>
    <div class="col-sm-10">
      {!! Form::select('type', $types, null, array('class' => 'form-control','required'=>'true')) !!}
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label" >Email:</label>
    <div class="col-sm-10">
      {!! Form::text('email', null, array('required' => 'true','class' => 'form-control')) !!}
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
