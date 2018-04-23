@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Schools</h2>

                <div>
                {!! Form::open(['method'=>'GET','url'=>'admin/schools','role'=>'search'])  !!}
                    <input type="text" name="search" value="{{ app('request')->input('search') }}" id="search">
                    <input type="submit" name="submit" value="Search">
                    <input type="button" name="reset" value="Reset" onclick="window.location='{{ route('admin.schools.index') }}'">
                {!! Form::close() !!}
                </div><br>
            </div>

            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('admin.schools.create') }}"> New School</a>
                <a class="btn btn-success" href="{{ route('admin.schools.mass_upload') }}"> Mass Upload</a>
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
            <th>Name</th>
            <th>City</th>
            <th>Country</th>
            <th>Status</th>
            <th width="200px">Action</th>
        </tr>

    @foreach ($items as $key => $item)

    <tr>
        <td>
            {{ $item->name }}
        </td>
        <td>{{ $item->city }}</td>
        <td>{{ $item->country }}</td>
        <td>
            <?php
                $num = ++$i;
                $form_name = "form_".$num;
            ?>
            {!! Form::open(["onchange" => "$('#$form_name').submit()", 'route' => ['admin.schools.statuses', $item->id],'style'=>'display:inline', 'id' => $form_name ]) !!}

                {!! Form::hidden('school_id', $item->id) !!}
                <?php
                $status_arr = array('1'=>'Enabled','0'=>'Disabled');
                ?>
                {!! Form::select('status', $status_arr, $item->status, array('id' => 'status','class' => 'form-control')) !!}
    
            {!! Form::close() !!}        
        </td>
        <td>
            <a class="btn btn-primary" href="{{ route('admin.schools.edit',$item->id) }}">Edit</a>
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
