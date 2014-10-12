@section('title')
    {{$exam->name}}
@stop

@include('includes.header')

 Exam name:{{$exam->name}}
 {{ link_to_route('exam.edit', 'Edit', $exam->id) }}
 {{ Form::open(array('route' => array('exam.destroy', $exam->id), 'method' => 'delete')) }}
    <button type="submit" href="{{ URL::route('exam.destroy', $exam->id) }}">Delete</button>
 {{ Form::close() }}


@include('includes.footer')
