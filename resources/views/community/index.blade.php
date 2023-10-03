@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Left colum to show all the links in the DB --}}
            <div class="col-md-8">
                <h1>Community</h1>
                @foreach ($links as $link)
                    <li>
                        <a href="{{ $link->link }}" target="_blank">
                            {{ $link->title }}
                        </a>
                        <small>Contributed by: {{ $link->creator->name }} {{ $link->updated_at->diffForHumans() }}</small>
                        <span class="label label-default" style="background: {{ $link->channel->color }}">
                            {{ $link->channel->title }}
                            </span>
                    </li>
                @endforeach

            </div>
            {{-- Right colum to show the form to upload a link --}}
            <div class="col-md-4">
                @include('add-link')
            </div>
        </div>
        {{ $links->links() }}

    </div>
@stop