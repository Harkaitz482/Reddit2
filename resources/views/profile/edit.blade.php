@extends('layouts.app')
@section('content')
    <img src="{{ url('storage/'. Auth::user()->profile->imageUpload) }}">

    <form action="/profile/store" method="POST" id="updateImage" enctype="multipart/form-data">
        @csrf
        ...
        <input type="file" name="imageUpload" class="form-control/">
        <button type="submit" value="subir imagen "> subir imagen </button>
    </form>
@stop
