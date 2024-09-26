@extends('layouts.main')

@section('page.title', 'Просмотр поста')

@section('main.content')

    <x-title>
        {{ __('Просмотр поста') }}

        <x-slot name="link">
            <a href="{{ route('user.posts.index') }}">
                {{ __('Назад') }}
            </a>
        </x-slot>

        <x-slot name="right">
            <x-button-link href="{{ route('user.posts.edit', $post->id) }}">
                {{ __('Изменить') }}
            </x-button-link>
        </x-slot>
    </x-title>
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-5">
        <h2 class="h4">
            {{ $post->title }}
        </h2>
    </div>

    <div class="pt-3">
        {!! $post->content !!}
    </div>

@endsection
