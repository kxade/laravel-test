@extends('layouts.main')


@section('main.content')

    <x-title>
        {{ __('Посты') }} {{ $user->name }} - {{ $posts->total() }}
    </x-title>
    
    @if(empty($posts))
        {{ __('Нет ни одного поста') }}
    @else
        @foreach($posts as $post)
            <div class="mb-5">
                <h2 class="h6 m-3">
                    <a href="{{ route('user.posts.show', $post->id) }}">
                        {{ $post->title }}
                    </a>
                </h2>

                <div class="small text-muted">
                    <span>{{ $post->published_at->format('d.m.Y h:i:s') }}
                </div>
            </div>

        @endforeach

        {{ $posts->links() }}
    @endif

@endsection