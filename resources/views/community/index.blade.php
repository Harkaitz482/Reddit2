@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            {{-- Left column to show all the links in the DB --}}
            <div class="col-md-8">
                @include('flash-message')


                <h1><a href="/community"> <a href="/community" style="text-decoration: none; color:inherit">
                            <h1>Community <span
                                    style="color: {{ $channel ? $channel->color : 'inherit' }}">{{ $channel ? $channel->title : '' }}</span>
                            </h1>
                        </a></a></h1>

                @if (count($links) > 0)
                    <ul>
                        @foreach ($links as $link)
                            <li class="bg-body">
                                <a class="text-decoration-none label label-default p-1 border-rounded text-black rounded"
                                    href="/community/{{ $link->channel->slug }}"
                                    style="background-color:{{ $link->channel->color }}">{{ $link->channel->title }}</a>
                                <a href="{{ $link->link }}" target="_blank">
                                    {{ $link->title }}
                                </a>
                                <small>Contributed by: {{ $link->creator->name }}
                                    {{ $link->updated_at->diffForHumans() }}</small>
                            </li>
                            <p class="votes">Votos: {{ $link->users->count() }}</p>
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
