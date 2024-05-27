@props(['color' => 'primary', 'size' => '',])


<button {{ $attributes
    ->merge(['type' => "button",])
    ->class(["btn btn-{$color}", ($size ? "btn-{$size}" : "")]) }}>
    {{ $slot }}
</button>