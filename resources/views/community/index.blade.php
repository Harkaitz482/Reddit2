@extends('layouts.app')
@section('content')
@foreach ($links as $link)
<li>{{$link->title}}</li>
@endforeach
{{$links->links()}}
<small>Contributed by: {{$link->creator->name}} {{$link->updated_at->diffForHumans()}}</small>

@stop