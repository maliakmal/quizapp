@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Edit Teacher</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.teachers.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::model($teacher, ['method' => 'PATCH', 'files' => true, 'class'=>'form-horizontal',  'route' => ['admin.teachers.update', $teacher->id]]) !!}
      @include('backend.admin.teacher.form')
      {!! Form::hidden('id', $teacher->id) !!}
    {!! Form::close() !!}

@endsection
