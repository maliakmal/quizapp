@extends('layouts.student')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-md-offset-3">
            <div class="card">

                <div class="card card-danger">
                    <div class="card-body">
                        <p class="lead"> Hello {{ Auth::user()->full_name }}!</p>
                        <p class="lead"> No quizzes have been loaded yet - please come back again.</p>
                    </div>
                    <div class="card-footer card-danger">

            @if (Auth::user())
              @guest
            @else
            <a href="{{ route('logout') }}" class="btn btn-light" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>


              @endguest
            @endif

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
