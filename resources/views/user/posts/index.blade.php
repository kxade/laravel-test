@extends('layouts.main')

@section('page.title', 'Мои посты')

@section('main.content')

    <h1> Hello, {{ auth()->user()->name }} </h1>

    <x-title>
        {{ __('Мои посты') }}
        <x-slot name="right">
            <x-button-link href="{{ route('user.posts.create') }}">
                {{ __('Создать') }}
            </x-button-link>
        </x-slot>
    </x-title>

    {{-- Session Messages --}}
    @if (session('delete'))
        <div class="alert alert-success">
            {{ session('delete') }}
        </div>
    @endif
    
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
                    <span>{{ $post->published_at->format('d.m.Y h:i:s') }} by</span>
                    <a href="">{{ $post->user->name }}</a>
                    {{-- Delete the post --}}
                    <form action="{{ route('user.posts.destroy', $post)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Удалить</button>
                    </form>
                </div>

            </div>

        @endforeach

        {{ $posts->links() }}
    @endif

@endsection
