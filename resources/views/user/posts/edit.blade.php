@extends('layouts.main')

@section('page.title', 'Изменить пост')

@section('main.content')

    <x-title>
        {{ __('Изменить пост') }}
        <x-slot name="link">
            <a href="{{ route('user.posts.show', $post) }}">
                {{ __("Назад") }}
            </a>
        </x-slot>
    </x-title>
    
    <x-post.form action="{{ route('user.posts.update', $post) }}" method="put" :post="$post">
        <x-button type="submit">
            {{ __('Изменить пост') }}
        </x-button>
    </x-post.form>

@endsection
