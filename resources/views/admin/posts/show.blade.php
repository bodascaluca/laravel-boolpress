@extends('layouts.dashboard')

@section('content')
    <h1> {{ $post->title }} </h1>
    <p>Slug: {{ $post->slug }}</p>
    <p>{{ $post->content }}</p>

    <a class="btn btn-primary" href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">Modifica</a>
@endsection