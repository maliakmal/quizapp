@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <h1>Quizzes</h1>
            <div class="well">
            <div class="pull-right">
                <a class="btn btn-default" href="{{ route('admin.quizzes.create') }}"> New Quiz</a>
            </div>
                <div>
                {!! Form::open(['method'=>'GET','url'=>'admin/quizzes','role'=>'search'])  !!}
                    <input type="text" name="search" value="{{ isset($params['search'])?$params['search']:'' }}" id="search">
                    <input type="submit" name="submit" value="Search">
                    <input type="button" name="reset" value="Reset" onclick="window.location='{{ route('admin.quizzes.index') }}'">
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
            <th>Title</th>
            <th>Type</th>
            <th>State</th>
            <th>Number of Questions</th>
            <th width="250px">Action</th>
        </tr>
    @foreach ($quizzes as $key => $quiz)
    <tr>
        <td>
            {{ $quiz->title }}
        </td>
        <td>{{ $quiz->type }}</td>
        <td>@if($quiz->isDraft())
                <span class="label label-warning">DRAFT</span>
            @else
                <span class="label label-info">PUBLISHED</span>
            @endif
        </td>
        <td>
            {{ $quiz->questions()->count() }}
        </td>
        <td>
            <a class="btn btn-default btn-sm" href="{{ route('admin.quizzes.edit',$quiz->id) }}"><i class="glyphicon glyphicon-pencil"></i></a>
            <a class="btn btn-default btn-sm" href="{{ route('admin.quizzes.show',$quiz->id) }}"><i class="glyphicon glyphicon-eye-open"></i></a>        
       </td>
    </tr>

    @endforeach

    </table>

    {!! $quizzes->appends($params)->render() !!}


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