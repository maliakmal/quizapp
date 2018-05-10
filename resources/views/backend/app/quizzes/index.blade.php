@extends('layouts.student')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Quizzes</h1>
        </div>
    </div>
    <div class="row">
        @foreach($quizzes as $quiz)
        <div class="col-3">
            <div class="card card-default">
                <div class="card-body">
                    <p class="lead">{{ $quiz->title }} </p>
                </div>
                <div class="card-footer">
                    <a class="btn btn-dark" href="{{ route('student.quizzes.show', $quiz) }}">Access</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
