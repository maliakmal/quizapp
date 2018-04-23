@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Mass Upload Schools</h3>
                <p>
                    Should be in this format: <br>
                    Name,City,Country
                </p>
                <p>Examples:<br>
                  School1,Dubai,United Arab Emirates<br>
                  School2,Dubai,United Arab Emirates
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.schools.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::open(array('route' => 'admin.schools.store_mass_upload','method'=>'POST', 'files' => true)) !!}

        <div class="form-group">
            <strong>Upload CSV:</strong>
            {!! Form::file('csv', null, array('class' => 'form-control')) !!}
        </div>
   
        <button type="submit" class="btn btn-primary">Submit</button>
    {!! Form::close() !!}

@endsection
