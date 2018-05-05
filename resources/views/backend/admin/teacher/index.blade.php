@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <h1>Teachers</h1>
            <div class="well">
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('admin.teachers.create') }}"> New Teacher</a>
            </div>
                <div>
                {!! Form::open(['method'=>'GET','url'=>'admin/teachers','role'=>'search'])  !!}
                    <input type="text" name="search" value="{{ isset($params['search'])?$params['search']:'' }}" id="search">
                    <input type="submit" name="submit" value="Search">
                    <input type="button" name="reset" value="Reset" onclick="window.location='{{ route('admin.teachers.index') }}'">
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
            <th>School</th>
            <th>Teacher Name</th>
            <th>Email Address</th>
            <th>Status</th>
            <th width="250px">Action</th>
        </tr>

    @foreach ($teachers as $key => $teacher)

    <tr>
        <td>
            {{ ($teacher->school) ? $teacher->school->name:'Unknown' }}
        </td>
        <td>{{ $teacher->first_name.' '.$teacher->last_name }}</td>
        <td>{{ $teacher->email }}</td>
        <td>

            {!! Form::open(['route' => ['admin.teachers.update-status'],'style'=>'display:inline' ]) !!}

                {!! Form::hidden('teacher_id', $teacher->id) !!}
                <?php
                $statuses = array('New','Approved', 'Declined');
                ?>
                {!! Form::select('status', $statuses, $teacher->status, array('id' => 'status','class' => 'status-selectors form-control')) !!}
    
            {!! Form::close() !!}        
        </td>
        <td>
            <a class="btn btn-primary" href="{{ route('admin.teachers.edit',$teacher->id) }}">Edit</a>
            <a class="btn btn-primary" href="{{ route('admin.teachers.change_password',$teacher->id) }}">Change Password</a>
        </td>
    </tr>

    @endforeach

    </table>

    {!! $teachers->appends($params)->render() !!}


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