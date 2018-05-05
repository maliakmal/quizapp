@extends('layouts.teacher')

@section('content')
  <div class="row">
    <div class="col-lg-12 margin-tb">
      <h1>Students Leaderboard</h1>
      <div class="well">
        <div>
          {!! Form::open(['method'=>'GET', 'role'=>'search'])  !!}
          <input type="text" name="search" value="{{ isset($params['search'])?$params['search']:'' }}" id="search">
          {!! Form::select('school_id', $schools, null, array('class' => '',  'placeholder'=>'School?', 'style'=>'width:100px;')) !!}
          {!! Form::select('gender', $genders, null, array('class' => '', 'placeholder'=>'Gender?', 'style'=>'width:100px;')) !!}
          {!! Form::select('country', $countries, null, array('class' => '', 'placeholder'=>'Country?', 'style'=>'width:100px;')) !!}
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
      <th>School</th>
      <th>Country</th>
      <th>Category</th>
      <th>Score</th>
    </tr>
    @foreach ($students as $key => $student)
      <tr>
        <td>{{ $student->first_name.' '.$student->last_name }}</td>
        <td>{{ $student->gender }}</td>
        <td>{{ $student->school?$student->school->name:'' }}</td>
        <td>{{ $student->school?$student->school->country:'' }}</td>
        <td>{{ $student->type }}</td>
        <td>{{ $student->score }}</td>
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