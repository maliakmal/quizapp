<div class="row">
        <div class="form-group">
            <strong>School:</strong>
            {!! Form::select('school', $schools, null, array('placeholder' => 'Select School','class' => 'form-control','required'=>'true')) !!}
          </div>

        <div class="form-group">
            <strong>First Name:</strong>
          {!! Form::text('first_name', null, array('placeholder' => '','class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            <strong>Last Name:</strong>
          {!! Form::text('last_name', null, array('placeholder' => '','class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            <strong>Email:</strong>
          {!! Form::text('email', null, array('required' => 'true','class' => 'form-control')) !!}
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
</div>
