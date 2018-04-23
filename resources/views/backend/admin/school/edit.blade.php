@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Edit School</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.schools.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::model($item, ['method' => 'PATCH', 'files' => true, 'route' => ['admin.schools.update', $item->id]]) !!}
      @include('backend.admin.school.form')
    {!! Form::close() !!}

@endsection
