@extends('layouts.base')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
                    <div class="text-center">
                        <br/>
                        <h3><i class="fas  fa-graduation-cap" data-fa-transform="shrink-6"></i> Teacher Registration</h3>
                        <br/>
                    </div>


          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group row">
              <label for="school" class="col-md-4 col-form-label text-md-right">{{ __('School') }}</label>
              <div class="col-md-6">
                <select name="school_id" id="school" class="form-control{{ $errors->has('school_id') ? ' is-invalid' : '' }}" required autofocus>
                  <option value="">Select School</option>
                  @foreach($schools as $school)
                    <?php
                      $sel = old('school_id');
                      $selected = '';
                      if ($sel == $school->id) {
                        $selected = "selected='selected'";
                      }
                    ?>
                    <option value="{{ $school->id }}" {{ $selected }}>{{ $school->name }}</option>
                  @endforeach
                </select>
                @if ($errors->has('school'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('school') }}</strong>
                  </span>
                @endif
              </div>
            </div>                        

            <div class="form-group row">
              <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('First Name') }}</label>
              <div class="col-md-6">
                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                @if ($errors->has('first_name'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('first_name') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Last Name') }}</label>
              <div class="col-md-6">
                <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>

                @if ($errors->has('last_name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
            </div>                       

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

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
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                </div>
            </div>
          </form>
        </div>
                        <div class="card-footer">
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                Teachers 
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    Login
                                </a>
                                <!--<a style="display:none;" class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>-->
                            </div>
                        </div>

                </div>

      </div>
    </div>
  </div>
</div>
@endsection
