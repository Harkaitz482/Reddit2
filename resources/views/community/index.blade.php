@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Left column to show all the links in the DB --}}
            <div class="col-md-8">
                @include('flash-message')


                <h1>Community</h1>

                @if (count($links) > 0)
                    <ul>
                        @foreach ($links as $link)
                            <li>
                                <a href="{{ $link->link }}" target="_blank">
                                    {{ $link->title }}
                                </a>
                                <small>Contributed by: {{ $link->creator->name }}
                                    {{ $link->updated_at->diffForHumans() }}</small>
                                <span class="label label-default" style="background: {{ $link->channel->color }}">
                                    {{ $link->channel->title }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    {{ $links->links() }}
                @else
                    <p>No approved contributions yet</p>
                @endif
            </div>

            {{-- Right column to show the form to upload a link --}}
            <div class="col-md-4">
                @include('add-link')
            </div>
        </div>
    </div>
@stop
