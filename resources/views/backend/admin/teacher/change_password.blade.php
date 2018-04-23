@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Change Password for "{{ $item->email }}"</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.teachers.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::open(array('route' => 'admin.teachers.process_change_password','method'=>'POST', 'files' => true)) !!}
      
    <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                {!! Form::hidden('id', $item->id) !!}
                            </div>
                        </div>

                        

        <button type="submit" class="btn btn-primary">Submit</button>
</div>


    {!! Form::close() !!}

@endsection
