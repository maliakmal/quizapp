@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Teachers</h2>

                <div>
                {!! Form::open(['method'=>'GET','url'=>'admin/teachers','role'=>'search'])  !!}
                    <input type="text" name="search" value="{{ app('request')->input('search') }}" id="search">
                    <input type="submit" name="submit" value="Search">
                    <input type="button" name="reset" value="Reset" onclick="window.location='{{ route('admin.teachers.index') }}'">
                {!! Form::close() !!}
                </div><br>
            </div>

            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.teachers.create') }}"> New Teacher</a>
            </div><br>
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

    @foreach ($items as $key => $item)

    <tr>
        <td>
            @if ($item->school_name != null)
                {{ $item->school_name->name }}
            @endif
        </td>
        <td>{{ $item->first_name.' '.$item->last_name }}</td>
        <td>{{ $item->email }}</td>
        <td>
            <?php
                $num = ++$i;
                $form_name = "form_".$num;
            ?>
            {!! Form::open(["onchange" => "$('#$form_name').submit()", 'route' => ['admin.teachers.statuses', $item->id],'style'=>'display:inline', 'id' => $form_name ]) !!}

                {!! Form::hidden('teacher_id', $item->id) !!}
                <?php
                $status_arr = array('New','Approved', 'Declined');
                ?>
                {!! Form::select('status', $status_arr, $item->status, array('id' => 'status','class' => 'form-control')) !!}
    
            {!! Form::close() !!}        
        </td>
        <td>
            <a class="btn btn-primary" href="{{ route('admin.teachers.edit',$item->id) }}">Edit</a>
            <a class="btn btn-primary" href="{{ route('admin.teachers.change_password',$item->id) }}">Change Password</a>
        </td>
    </tr>

    @endforeach

    </table>

    {!! $items->appends(['search' => $search])->render() !!}

    <script>
      function validate_form(form) {
        return confirm('Do you really want to delete this entry?');
      }
    </script>

@endsection
