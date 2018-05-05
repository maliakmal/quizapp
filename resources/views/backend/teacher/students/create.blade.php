@extends('layouts.teacher')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>New Student</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('teacher.students.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
    @include('backend.errors')



    {!! Form::open(array('route' => 'teacher.students.store','method'=>'POST', 'class'=>'form-horizontal', 'files' => true)) !!}
      @include('backend.teacher.students.form')
    {!! Form::close() !!}
</div>
</div>

@endsection
