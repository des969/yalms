@section('title')
    All exams
@stop

@include('includes.header')

    @foreach ($exams as $exam)
      <div class="exam">
        {{ link_to_route('exam.show', $exam->name, $exam->id) }}
      </div>
    @endforeach
    {{$exams->links()}}

@include('includes.footer')
