@extends('layouts.backend')

@section('content')
  <div class="row">
      <div class="col-lg-12 margin-tb">
        <h1>Schools</h1>
        <div class="well">
<div class="pull-right">
              <a class="btn btn-success" href="{{ route('admin.schools.create') }}"> New School</a>
              <a class="btn btn-success" href="{{ route('admin.schools.import') }}"> Mass Upload</a>
          </div>
              <div>
              {!! Form::open(['method'=>'GET','url'=>'admin/schools','role'=>'search'])  !!}
                  <input type="text" name="search" value="{{ isset($params['search'])?$params['search']:'' }}" id="search">
                  <input type="submit" name="submit" value="Search">
                  <input type="button" name="reset" value="Reset" onclick="window.location='{{ route('admin.schools.index') }}'">
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
            <th>Name</th>
            <th>City</th>
            <th>Country</th>
            <th>Status</th>
            <th width="200px">Action</th>
        </tr>

    @foreach ($schools as $school)

    <tr>
      <td>
        {{ $school->name }}
      </td>
      <td>{{ $school->city }}</td>
      <td>{{ $school->country }}</td>
      <td>
        {!! Form::open(['route' => ['admin.schools.update-status', $school->id],'style'=>'display:inline']) !!}
          {!! Form::hidden('school_id', $school->id) !!}
          <?php
          $statuses = array('1'=>'Enabled','0'=>'Disabled');
          ?>
          {!! Form::select('status', $statuses, $school->status, array('id' => 'status','class' => 'status-selectors form-control')) !!}

        {!! Form::close() !!}        
      </td>
      <td>
          <a class="btn btn-primary" href="{{ route('admin.schools.edit',$school->id) }}">Edit</a>
      </td>
    </tr>

    @endforeach

    </table>

    {!! $schools->appends($params)->render() !!}

    <script>
      function validate_form(form) {
        return confirm('Do you really want to delete this entry?');
      }
    </script>

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