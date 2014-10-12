@section('title')
   Create new exam
@stop

@include('includes.header')

    {{ Form::open(array('url' => 'exam')) }}
        {{ Form::label('name', 'Exam name') }}
        {{ Form::text('name') }}
        {{ Form::submit('Add exam!') }}
    {{ Form::close() }}

@include('includes.footer')
