@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>New Teacher</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.teachers.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::open(array('route' => 'admin.teachers.store','method'=>'POST', 'class'=>'form-horizontal',  'files' => true)) !!}
      @include('backend.admin.teacher.form')
    {!! Form::close() !!}

@endsection
