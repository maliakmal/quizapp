@extends('layouts.teacher')

@section('content')
  <div class="row">
    <div class="col-lg-12 margin-tb">
      <h1>Students {{ Auth::user()->school ? 'at '.Auth::user()->school->name :'' }}</h1>
      <div class="well">
        <div class="pull-right">
          <a class="btn btn-default" href="{{ route('teacher.students.create') }}"> Add Student</a>
        </div>
        <div>
          {!! Form::open(['method'=>'GET', 'role'=>'search'])  !!}
          <input type="text" name="search" value="{{ isset($params['search'])?$params['search']:'' }}" id="search">
          {!! Form::select('grade', $grades, null, array('class' => '',  'placeholder'=>'Grade?', 'style'=>'width:100px;')) !!}
          {!! Form::select('type', $types, null, array('class' => '', 'placeholder'=>'Category?', 'style'=>'width:100px;')) !!}
          <input type="submit" name="submit" value="Search">
          <input type="button" name="reset" value="Reset" onclick="window.location='{{ route('teacher.students.index') }}'">
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  @if ($message = Session::get('success'))
    <div class="alert alert-success">
      <p>{{ $message }}</p>
    </div>
  @endif
  <table class="table table-striped">
    <tr>
      <th>Student</th>
      <th>Gender</th>
      <th>Category</th>
      <th>Grade</th>
      <th>Score</th>
      <th></th>
    </tr>
    @foreach ($students as $key => $student)
      <tr>
        <td>{{ $student->first_name.' '.$student->last_name }}</td>
        <td>{{ $student->gender }}</td>
        <td>{{ $student->type }}</td>
        <td>{{ $student->grade }}</td>
        <td>{{ $student->score }}</td>
        <td>
          <a class="btn btn-primary" href="{{ route('teacher.students.edit',$student->id) }}">Edit</a>
          {{ Form::open(array('style' => 'display: inline-block;', 'onclick'=>'return confirm(\'Are you sure?\')',  'method' => 'DELETE', 'route' => array('teacher.students.destroy', $student->id))) }}
              {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
          {{ Form::close() }}

        </td>
    </tr>

    @endforeach

    </table>

    {!! $students->appends($params)->render() !!}


@endsection
@section('js')
    <script type="text/javascript">
        $(function(){
            $('.status-selectors').change(function(){
                $(this).parents('form').first().submit();
            })
        })

    </script>

@endsection