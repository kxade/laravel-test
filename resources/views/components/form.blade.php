@props(['method' => 'GET'])

@php($method = strtoupper($method))
@php($_isStandard = in_array($method, ['GET', 'POST'])) 

<form {{ $attributes }} method="{{ $_isStandard ? $method : 'POST' }}">
    @unless($_isStandard)
        {{-- <input type="hidden" name="_method" method="{{ $method }}"> --}}
        @method($method)
    @endunless

    @if($method !== 'GET') {
        @csrf 
    }
    @endif

    {{ $slot }}
</form>