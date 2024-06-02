@props(['post' => null])


<x-form {{ $attributes }}>
    <x-form-item>
        <x-label required>{{ __('Название поста') }}</x-label>
        <x-input name="title" value="{{ $post->title ?? '' }}" autofocus />
        
        {{-- @if($errors->has('title'))
            <div class="small text-danger pt-2">
                {{ $errors->first('title') }}               
            </div>
        @endif --}}

        <x-error name="title"/>
    </x-form-item>

    <x-form-item>
        <x-select name="category_id" value="" />
    </x-form-item>

    <x-form-item>
        <x-label required>{{ __('Содержание') }}</x-label>
        {{-- <x-textarea name="content" rows="10" /> --}}
        <x-trix name="content" value="{{ $post->content ?? '' }}"/>
    </x-form-item>

    <x-form-item>
        <x-label required>{{ __('Дата публикации') }}</x-label>
        {{-- <x-textarea name="content" rows="10" /> --}}
        <x-input name="published_at" placeholder="dd.mm.yyyy"/>
        <x-error name="published_at"/>
    </x-form-item>

    <x-form-item>
        <x-checkbox name="published">
            {{ __('Опубликовано')}}
        </x-checkbox>
    </x-form-item>
    {{ $slot }}
</x-form>

