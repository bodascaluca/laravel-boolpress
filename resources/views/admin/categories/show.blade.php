@extends('layouts.dashboard')

@section('content')
    <h2><strong>Categoria:</strong>{{ $category->name }}</h2>
    <p><strong>Slug:</strong>{{ $category->slug }}</p>

    <ul>
        @forelse($category->posts as $post)
        <li>
            <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
        </li>
        @empty 
        <li>
            Nessun post collegato
        </li>
        @endforelse
    </ul>
@endsection