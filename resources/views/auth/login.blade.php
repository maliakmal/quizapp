@extends('layouts.base')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-8 col-offset-2">
      <div class="p-10">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div>
            <div class="text-center">
              <br/>
              <p>
                <b>Sign in with your account</b>
              </p>
              <br/>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <input placeholder="Email Address" id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus />
                @if ($errors->has('email'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <div class="col-12">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password" />
                @if ($errors->has('password'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-8">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-12">
                <button type="submit" class="btn btn-block btn-success">
                  {{ __('Login') }}
                </button>
              </div>
            </div>
          </div>
          <div>
            <div class="form-group row mb-0">
              <div class="col-12">
                Teachers 
                <a class="btn btn-link" href="{{ route('register') }}">
                  Register here
                </a>
                <!--<a style="display:none;" class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>-->
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
