@extends('layouts.student')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-4 offset-md-1">
            <img src="http://via.placeholder.com/500x500" class="img-fluid" alt="Responsive image">
        </div>
        <div class="col-md-6">
            <h1 >{{ $quiz->title }}</h1>
            <p class="lead">
                {{ $quiz->description }}
            </p>
            <div style="bottom:0;width:100%;" class="position-absolute align-items-end" >
                @if($quiz->isCompletedByUser(\Auth::user()->id))
                <div class="mb-0 alert alert-info">
                    You've completed the quiz.
                </div>
                @else
                <form action="{{ route('student.quizzes.start') }}" method="post">
                    {{ csrf_field() }}
                    <input value="{{ $quiz->id }}" name="quiz_id" type="hidden" />
                    <button class="btn btn-lg btn-block btn-primary">Start</button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
