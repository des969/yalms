@section('title')
   Edit exam {{$examName}}
@stop

@include('includes.header')
    {{ Form::open(array('url' => $url, 'method' => 'PUT')) }}
        {{ Form::label('name', 'Exam name') }}
        {{ Form::text('name',$examName) }}
        {{ Form::submit('Save change!') }}
    {{ Form::close() }}

@include('includes.footer')
