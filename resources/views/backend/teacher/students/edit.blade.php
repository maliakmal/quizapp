@extends('layouts.teacher')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Edit Student</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('teacher.students.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::model($student, ['method' => 'PATCH', 'files' => true, 'class'=>'form-horizontal', 'route' => ['teacher.students.update', $student->id]]) !!}
      @include('backend.teacher.students.form')
      {!! Form::hidden('id', $student->id) !!}
    {!! Form::close() !!}

@endsection
