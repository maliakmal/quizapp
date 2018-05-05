@extends('layouts.backend')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3>Create Quiz</h3>
            </div>

            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin.quizzes.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('backend.errors')

    {!! Form::open(array('route' => 'admin.quizzes.store','method'=>'POST', 'class'=>'form-horizontal',  'files' => true)) !!}
      @include('backend.admin.quizzes.form')
    {!! Form::close() !!}

@endsection
@section('js')
<script type="text/javascript">
    $(function(){
        $('#accessible_from').datetimepicker({
            format:'Y-m-d H:i',
            onShow:function( ct ){
                this.setOptions({
                    maxDate:$('#accessible_to').val()?$('#accessible_to').val():false
                })
            },
            timepicker:true
        });
        $('#accessible_to').datetimepicker({
            format:'Y-m-d H:i',
            onShow:function( ct ){
                this.setOptions({
                    minDate:$('#accessible_from').val()?$('#accessible_from').val():false
                })
            },
            timepicker:true
        });

    });
</script>
@endsection
